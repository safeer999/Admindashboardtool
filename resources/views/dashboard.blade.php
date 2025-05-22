@extends('layouts.app')

@section('content')

    <p>Welcome, {{ Auth::user()->first_name ?? "Not Loginned"}}!</p>

@endsection

