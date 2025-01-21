@extends('layouts.master')

@section('content')
    <div class="container">
        <h1>Welcome to Your Regular Dashboard, {{ Auth::user()->name }}</h1>
        <!-- Add the content for regular users here -->
        <p>Manage your profile, see transaction history, etc.</p>
    </div>
@endsection
