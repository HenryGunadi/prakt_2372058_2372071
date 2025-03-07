@extends('layouts.app')

@section('title', 'Karyawan Dashboard')

@section('content')
    <div class="text-black">
        <h1>Welcome, {{ $user->nama }}</h1>
        <h1>ROLE : {{ $user->role->role}}</h1>
        <p>This is the karyawan dashboard.</p>
        @if ($user->role->role === 'tu')
            <div>THIS IS TU ONLY</div>
        @else
            <div>THIS IS KAPRODI</div>
        @endif
    </div>
@endsection
