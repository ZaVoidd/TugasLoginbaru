@extends('backend.v_layouts.app')
@section('content')

<h3>{{ $judul }}</h3>

<p>
    selamat datang, <b>{{ Auth::user()->nama }}</b> pada aplikasi toko online dengan hak akses yang anda miliki sebagai 
    <b>
        @if (Auth::user()->role == 1)
        Super Admin
        @elseif (Auth::user()->role ==0)
        Admin
        @endif
    </b>
     ini adalah halaman utama aplikasi ini 
</p>

@endsection
