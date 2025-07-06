<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ferie;
use App\Models\Dipendente;

class AdminController extends Controller
{
    public function index()
    {
        $dipendenti = Dipendente::with('ferie')->get();
        return view('admin.home', compact('dipendenti'));
    }
}
