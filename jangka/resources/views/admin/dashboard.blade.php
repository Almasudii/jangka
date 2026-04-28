@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1>Admin Dashboard</h1>
    <p>Selamat datang, {{ auth()->user()->name }} (Role: {{ auth()->user()->role }})</p>

    <form method="POST" action="{{ route('admin.logout') }}">
        @csrf
        <button type="submit" class="btn btn-danger">Logout</button>
    </form>
</div>
@endsection
