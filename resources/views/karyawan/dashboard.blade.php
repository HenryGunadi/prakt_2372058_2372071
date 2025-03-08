@extends('karyawan.layouts.app')

@section('content')
    <h2 class="font-semibold text-xl text-white leading-tight">
        {{ __('Karyawan - Dashboard') }}
    </h2>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if(auth('karyawan')->check())
                        <p>Welcome, {{ auth('karyawan')->user()->nama }}!</p>
                        <p>Email: {{ auth('karyawan')->user()->email }}</p>
                        <p>Role: {{ auth('karyawan')->user()->role->role }}</p>
                    @else
                        <p>No user is logged in.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
