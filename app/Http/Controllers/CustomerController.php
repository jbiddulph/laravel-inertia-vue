<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function create(Request $request) {
        // dd($request);
        // sleep(1);
        // Validate
        $fields = $request->validate([
            'name' => ['required', 'max:255'],
            'email' => ['required'],
            'phone' => ['required', 'max:255'],
        ]);
        // Create Customer
        Customer::create($fields);
        // Redirect
        return redirect()->route('dashboard')->with('greet', 'You have created a customer');
    }
}
