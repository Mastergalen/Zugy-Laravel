<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        if($request->has('name')) {
            $customers = User::where('name', 'LIKE', "%{$request->input('name')}%")->paginate(30);
        } else {
            $customers = User::paginate(30);
        }

        return view('admin.pages.customer.index-customer')->with(['customers' => $customers]);
    }

    public function show($id)
    {
        $customer = User::findOrFail($id);

        return view('admin.pages.customer.show-customer')->with(['customer' => $customer]);
    }
}