<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
class ConstanciasController extends Controller
{
	
    public function index(){
    	return view('admin.constancias.index');
    }

    public function visualizar(){
    	$data = ['imagen' => url('images/constancias/sep_logo2.png')];
    	
    	return view('admin.constancias.constancia')->with('data',$data);
    	$pdf = PDF::loadView('admin.constancias.constancia', compact('data'));
    	return $pdf->stream('constancia.pdf');
    	return view('admin.constancias.constancia');
    }
}
