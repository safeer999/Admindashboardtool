<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ('indes page');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       return ('createpage');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return ('store page');
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
    public function edit(string $id)
    {
        return ('edit page');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        return ('update page');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return ('desroy page');
    }
}
