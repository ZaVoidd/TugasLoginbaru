<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class BerandaController extends Controller
{
    public function berandaBackend()
    {
        return view('backend.v_beranda.index', [
            'judul' => 'halaman beranda'
        ]);
    }
}
