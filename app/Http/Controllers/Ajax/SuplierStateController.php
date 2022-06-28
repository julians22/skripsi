<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SuplierStateController extends Controller
{
    public function getSupliers(Request $request)
    {
        $search = $request->get('search');
        $supliers = Supplier::where('name', 'like', '%' . $search . '%')->get();
        return response()->json($supliers);
    }
}
