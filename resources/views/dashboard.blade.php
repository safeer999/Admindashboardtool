@extends('layouts.app')

@section('content')

    <p>Welcome, {{ Auth::user()->name ?? "Not Loginned"}}!</p>

@endsection

