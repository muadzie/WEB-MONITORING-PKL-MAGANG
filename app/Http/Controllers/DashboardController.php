<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->isDosen()) {
            return redirect()->route('dosen.dashboard');
        } elseif ($user->isPT()) {
            return redirect()->route('pt.dashboard');
        } elseif ($user->isSiswa()) {
            return redirect()->route('siswa.dashboard');
        }
        
        return view('dashboard');
    }
}