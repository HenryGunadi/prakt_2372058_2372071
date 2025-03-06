@extends('layouts.app')

@section('title', 'Mahasiswa Dashboard')

@section('content')
    <h1>Welcome, {{ $user->nama }}</h1>
    <p>This is the mahasiswa dashboard.</p>
@endsection
