<?php

namespace App\Http\Controllers\Farm;

use App\Http\Controllers\Controller;
use App\Models\Goat;
use App\Models\Report;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Carbon\Carbon;

class GoatController extends Controller
{
    public function index(Request $request)
    {
        $goats = Goat::where('is_active',1)
            ->orderBy('date_of_birth')
            ->get();

        $males = Goat::where('is_active',1)->where('gender','male')
            ->orderBy('is_castrated')->orderBy('date_of_birth')->get();

        $females = Goat::where('is_active',1)->where('gender','female')
            ->with(['children'])
            ->orderBy('date_of_birth')->get();

        foreach ($females as $female) {
            if ($female->children->count() > 0) {
                $lastChild = $female->children->sortBy('date_of_birth')->last();
                $dateOfBirth = Carbon::parse($lastChild->date_of_birth);

                $diff = $dateOfBirth->diff(Carbon::now());

                $years = $diff->y;
                $months = $diff->m;
                $last_child_dif = ($years > 0 ? $years . ' Years ' : '') . ($months > 0 ? $months . ' Months' : '');

                $female['last_child_diff'] = $last_child_dif;
            }else{
                $female['last_child_diff'] = 'N.A.';
            }
        }

        $in_active_goats = Goat::where('is_active',0)
            ->orderBy('date_of_birth')->get();

        $dead_goats = Goat::where('is_active',0)->whereNotNull('date_of_death')
            ->orderBy('date_of_birth')->get();

        $sold_goats = Goat::where('is_active',0)->whereNotNull('sale_date')
            ->orderBy('date_of_birth')->get();

        return view('admin.goat.index',compact('goats','males','females','in_active_goats','dead_goats','sold_goats'));
    }

    public function fetchDetails(Request $request) {
        $id = $request->id;
        $data = Goat::where('id',$id)
            ->with(['mother','father','reports','transactions','children'])
            ->first();

        if ($data->children->count() > 0) {
            foreach ($data->children as $child) {
                $dateOfBirth = Carbon::parse($child->date_of_birth);

                if ($child->is_active == 1) {
                    $diff = $dateOfBirth->diff(Carbon::now());
                } elseif ($child->sale_date) {
                    $diff = $dateOfBirth->diff(Carbon::parse($child->sale_date));
                } elseif ($child->date_of_death) {
                    $diff = $dateOfBirth->diff(Carbon::parse($child->date_of_death));
                }

                $years = $diff->y;
                $months = $diff->m;
                $age = ($years > 0 ? $years . ' Y ' : '') . ($months > 0 ? $months . ' M' : '');
                $child['age'] = $age;
            }
        }


        $dateOfBirth = Carbon::parse($data->date_of_birth);

        if ($data) {
            if ($data->is_active == 1) {
                $diff = $dateOfBirth->diff(Carbon::now());
            } elseif ($data->sale_date) {
                $diff = $dateOfBirth->diff(Carbon::parse($data->sale_date));
            } elseif ($data->date_of_death) {
                $diff = $dateOfBirth->diff(Carbon::parse($data->date_of_death));
            }

            $years = $diff->y;
            $months = $diff->m;
            $age = ($years > 0 ? $years . ' Years ' : '') . ($months > 0 ? $months . ' Months' : '');
            $data['age'] = $age;

        }

        return response()->json($data);
    }

    public function add(Request $request)
    {
        $eightMonthsAgo = Carbon::now()->subMonths(8);

        $mothers = Goat::where('gender','female')->orderBy('id')->get();
        $fathers = Goat::where('gender', 'male')
            ->where('is_castrated', 0)
            ->where(function ($query) use ($eightMonthsAgo) {
                $query->where(function ($query) {
                    $query->whereNull('sale_date')->whereNull('date_of_death');
                })
                    ->orWhere(function ($query) use ($eightMonthsAgo) {
                        $query->where('sale_date', '>', $eightMonthsAgo)
                            ->orWhere('date_of_death', '>', $eightMonthsAgo);
                    });
            })
            ->orderBy('id')
            ->get();

        $mother_id = null;
        if($request->has('mother_id')){
            $mother_id = $request->mother_id ;
        }

        return view('admin.goat.add',compact('mothers','fathers','mother_id'));

    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'unique:goats'
        ]);

        $goat=new Goat();
        $goat->name=$request->name;
        $goat->breed=$request->breed;
        $goat->date_of_birth = $request->dob;
        $goat->gender = $request->gender;
        if($request->type == 'born')
        {
            $goat->mother_id = $request->mother_id;
            $goat->father_id = $request->father_id;
        }
        else{
            $goat->purchase_date = $request->purchase_date;
        }
        if($request->hasFile('image'))
        {
            $imgName = 'GoatAdd_'.time().'.'.$request->image->extension();
            $request->image->move(env("IMAGES_PATH"), $imgName);
            $goat->image = $imgName;
        }
        else{
            $goat->image = 'goat_default.png';
        }

        $goat->save();

        $report = new Report();
        $report->goat_id = $goat->id;
        if($request->hasFile('image')){
            $report->image = $goat->image;
        }
        if($request->has('description'))
        {
            $report->content = $request->description;
        }
        if($request->type == 'buy'){
            $report->title = 'Goat Buy.';
            $report->report_date = $request->purchase_date;
        }else{
            $report->title = 'Goat Born';
            $report->report_date = $request->dob;
        }
        $report->save();

        if($request->type == 'buy'){
            $transaction = new Transaction();
            $transaction->goat_id = $goat->id;
            $transaction->transaction_date = $goat->purchase_date;
            $transaction->type = 'purchase';
            if($request->has('description'))
            {
                $transaction->description = $request->description;
            }else{
                $transaction->description = 'Goat Purchase';
            }
            $transaction->amount = $request->amount;
            $transaction->report_id = $report->id;
            $transaction->save();

        }

        return redirect()->route('goat.index')
            ->with('success','Goat Added to Your Farm successfully');
    }

    public function dead(Request $request){
        $this->validate($request, [
            'id' => 'required , exists:goats,id'
        ]);

        $goat = Goat::find($request->id);

        return view('admin.goat.dead',compact('goat'));


    }

    public function remove(Request $request)
    {
        $this->validate($request, [

        ]);

        $goat = Goat::find($request->id);
        $goat->date_of_death = $request->date_of_death;
        $goat->is_active=0;
        $goat->save();


        $report = new Report();
        $report->goat_id = $goat->id;
        $report->title = 'Goat '.$goat->name.' Death';
        $report->report_date = $request->date_of_death;

        if($request->hasFile('image')){
            $imgName = 'GoatDead_'.time().'.'.$request->image->extension();
            $request->image->move(env("IMAGES_PATH"), $imgName);
            $report->image = $imgName;
        }
        if($request->has('description'))
        {
            $report->content = $request->description;
        }
        $report->save();

        return redirect()->route('goat.index')
            ->with('error','Goat has been moved to Inactive Section');
    }

    public function castrate(Request $request){
        $this->validate($request, [
            'id' => 'required , exists:goats,id'
        ]);

        $goat = Goat::find($request->id);

        return view('admin.goat.castrate',compact('goat'));
    }

    public function castrate_store(Request $request)
    {   $this->validate($request, [

        ]);

        $goat = Goat::find($request->id);
        $goat->is_castrated=1;
        $goat->save();


        $report = new Report();
        $report->goat_id = $goat->id;
        $report->title = 'Goat '.$goat->name.' Castrated';
        $report->report_date = $request->date_of_castrate;

        if($request->hasFile('image')){
            $imgName = 'GoatCastrate_'.time().'.'.$request->image->extension();
            $request->image->move(env("IMAGES_PATH"), $imgName);
            $report->image = $imgName;
        }
        if($request->has('description'))
        {
            $report->content = $request->description;
        }
        $report->save();

        if($request->amount >0){

            $transaction = new Transaction();
            $transaction->goat_id = $goat->id;
            $transaction->transaction_date  = $request->date_of_castrate;
            $transaction->type = 'medical';
            $transaction->description = 'Goat '.$goat->name.' Castration';
            $transaction->amount = $request->amount;
            $transaction->report_id = $report->id;
            $transaction->save();

        }

        return redirect()->route('goat.index')
            ->with('success','Goat has been castrated successfully');
    }
}
