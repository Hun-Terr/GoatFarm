<?php

namespace App\Http\Controllers\Farm;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Goat;
use App\Models\Report;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
         $data = Transaction::orderBy('transaction_date','DESC')
             ->with(['report','goat','customer'])
             ->get();
        return view('admin.transaction.index',compact('data'));
    }
    public function add(Request $request)
    {
        // $data = User::orderBy('id','DESC')->get();
        $transaction_types = [
                            'sale' => 'Sale',
                            'feed' => 'Feed' ,
                            'shelter' => 'Shelter',
                            'medical' => 'Medical',
                            'other'  => 'Other'
                            ];
        if($request->has('sell_goat_id') && $request->sell_goat_id != 0){
            $sell_goat_id = $request->sell_goat_id;
        }else{
            $sell_goat_id = null;
        }
        $goats = Goat::orderBy('id','asc')->where('is_active',1)->get();
        $customers = Customer::get();
        return view('admin.transaction.add',compact('transaction_types','sell_goat_id','goats','customers'));

    }
    public function store(Request $request)
    {
        $this->validate($request, [

        ]);

        $report = new Report();
        $report->title = 'Transaction :'.$request->type;
        $report->content = $request->description;
        $report->report_date = $request->transaction_date;
        if($request->hasFile('image'))
        {
            $imgName = 'TransactionAdd_'.time().'.'.$request->image->extension();
            $request->image->move(env("IMAGES_PATH"), $imgName);
            $report->image = $imgName;
        }
        if($request->has('goat_id')){
            $report->goat_id = $request->goat_id;
        }

        $report->save();

        $transaction = new Transaction();
        $transaction->type = $request->type;
        $transaction->description = $request->description;
        $transaction->amount = $request->amount;
        $transaction->transaction_date = $request->transaction_date;
        $transaction->report_id = $report->id;
        if($request->has('goat_id') && $request->type == 'sale'){
            $transaction->goat_id = $request->goat_id;
            $goat = Goat::find($request->goat_id);
            $goat->sale_date = $request->transaction_date;
            $goat->is_active = 0;
            $goat->save();
        }
        if($request->has('customer_id')){
            $transaction->customer_id = $request->customer_id ;
        }
        $transaction->save();

        return redirect()->route('transaction.index')
            ->with('success','Transaction Added to Your Balance Sheet successfully');

        return view('admin.transaction.index');
    }
}
