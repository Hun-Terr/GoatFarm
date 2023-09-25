<?php

namespace App\Http\Controllers;

use App\Models\Goat;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function showLogin(){
        return view('auth.login');
    }

    public function login(Request $request){
        $credentials = $request->only('email', 'password');

        // Attempt to log in the user
        if (Auth::attempt($credentials)) {
            // Authentication was successful
            return redirect('/dashboard'); // Redirect to a dashboard or another page
        } else {
            // Authentication failed
            return back()->withErrors(['email' => 'Invalid credentials']); // Redirect back with an error message
        }

    }

    public function dashboard(Request $request){

        $goatsData = Goat::where('is_active',1)->select('id','gender','date_of_birth')->get();
        foreach ($goatsData as $goat) {
            $dateOfBirth = \Carbon\Carbon::parse($goat->date_of_birth);
            $ageInMonths = $dateOfBirth->diffInMonths(Carbon::now());

            // Now you can use $ageInMonths in your code
            $goat->ageMonths = $ageInMonths;
        }

        $expenseData = [
            'labels' => ["Medical", "Feed", "Purchase", "Shelter","Other"],
            'datasets' => [
                [
                    'data' => [], // Initialize with zeros
                    'backgroundColor' => ["#FF5733", "#FFC300", "#FF8542", "#FFB347","#4287f5"],
                ],
            ],
        ];

// Fetch and process your transaction data, grouped by type
        $transactions = Transaction::select('type', \DB::raw('SUM(amount) as total_amount'))
            ->groupBy('type')
            ->get();

// Fill in the dataset data array based on the transaction types
        foreach ($transactions as $transaction) {
            switch ($transaction->type) {
                case 'medical':
                    $expenseData['datasets'][0]['data'][0] = $transaction->total_amount;
                    break;
                case 'feed':
                    $expenseData['datasets'][0]['data'][1] = $transaction->total_amount;
                    break;
                case 'purchase':
                    $expenseData['datasets'][0]['data'][2] = $transaction->total_amount;
                    break;
                case 'shelter':
                    $expenseData['datasets'][0]['data'][3] = $transaction->total_amount;
                    break;
                case 'other':
                    $expenseData['datasets'][0]['data'][4] = $transaction->total_amount;
                    break;
            }
        }

        $data = new \stdClass();;
        $data->total_goats = Goat::get()->count();
        $data->active_goats = Goat::where('is_active',1)->get()->count();
        $data->dead_goats = Goat::where('is_active',0)->whereNotnull('date_of_death')->get()->count();
        $data->sold_goats = Goat::where('is_active',0)->whereNotnull('sale_date')->get()->count();
        $data->active_male_goats = Goat::where('is_active',1)->where('gender','male')->get()->count();
        $data->active_female_goats = Goat::where('is_active',1)->where('gender','female')->get()->count();
        $data->total_investment = Transaction::where('type','<>','sale')->get()->sum('amount');
        $data->total_revenue = Transaction::where('type','sale')->get()->sum('amount');
        $data->net_profit = $data->total_revenue-$data->total_investment;

        return view('dashboard',compact('goatsData','expenseData','data'));
    }

    public function index(Request $request)
    {
        $data = User::orderBy('id','DESC')->get();
        return view('admin.user.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email:rfc,dns|unique:users,email',
            'password' => 'required|same:confirm-password',
      ]);

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);

        $user =new User();
        $user->name=$request->name;
        $user->email=$request->email;
        $user->password=  $input['password'];
        $user->save();

        return redirect()->route('user.index')
            ->with('success','User created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->route('user.index')
            ->with('success','User deleted successfully');
    }



}
