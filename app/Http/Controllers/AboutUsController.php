<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AboutUsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
    public function edit(string $id)
    {
        //
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


    public function about_ics()
    {
        return view('aboutus.index');
    }

    public function vision_mission()
    {
        return view('aboutus.vision_mission');
    }

    public function history()
    {
        return view('aboutus.history');
    }

    public function logo_symbolism()
    {
        return view('aboutus.logo_symbolism');
    }

    public function student_leaders()
    {
        return view('aboutus.student_leaders');
    }

    public function developers()
    {
        return view('aboutus.developers');
    }

    public function contact()
    {
        return view('aboutus.contact');
    }
}
