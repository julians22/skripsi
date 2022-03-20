<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerStateController extends Controller
{
    public function getCustomers(Request $request)
    {
        $search = $request->get('search');
        $customers = Customer::where('name', 'like', '%' . $search . '%')->get();
        return response()->json($customers);
    }
}
