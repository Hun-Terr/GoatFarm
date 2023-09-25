<?php

namespace App\Http\Controllers\Farm;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $data = Customer::orderBy('id','DESC')->get();
        return view('admin.customer.index',compact('data'));

    }

    public function add(Request $request)
    {
        return view('admin.customer.add');

    }

    public function store(Request $request)
    {
        $this->validate($request, [

        ]);
        $customer = new Customer();
        $customer->name = $request->name;
        $customer->contact_information = $request->contact_information ;
        $customer->address = $request->address;
        $customer->save();

        return redirect()->route('customer.index')
            ->with('success','Customer Added successfully');
    }

    public function edit(Request $request,$id)
    {
        $customer = Customer::find($id);

        return view('admin.customer.edit',compact('customer'));

    }

    public function edit_store(Request $request,$id)
    {
        $this->validate($request, [

        ]);
        $customer = Customer::find($id);
        $customer->name = $request->name;
        $customer->contact_information = $request->contact_information ;
        $customer->address = $request->address;
        $customer->save();

        return redirect()->route('customer.index')
            ->with('success','Customer Edited successfully');
    }

    public function delete($id)
    {
        Customer::find($id)->delete();
        return redirect()->route('customer.index')
            ->with('success','Customer removed successfully');
    }

}
