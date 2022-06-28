<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportController extends Controller
{


    public function index()
    {
        return view('backend.report.index');
    }

    public function sales(Request $request)
    {
        $validate = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);

        // facto

        dd($request->all());
    }
}
