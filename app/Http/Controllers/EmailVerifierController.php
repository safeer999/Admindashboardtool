<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmailVerifierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('emailverify.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
                return view('emailverify.create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()

    {
            dd('trest');
        return ('dasdfsgds hy ');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
