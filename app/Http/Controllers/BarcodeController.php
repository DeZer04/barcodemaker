<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BarcodeController extends Controller
{
    public function index()
    {
        return view('Barcode');
    }

    public function generateBarcode(Request $request)
    {
        $data = $request->input('data');
        $barcode = \DNS1D::getBarcodeHTML($data, 'C39');
        return response()->json(['barcode' => $barcode]);
    }
}
