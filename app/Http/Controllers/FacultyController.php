<?php

namespace App\Http\Controllers;

use App\Models\Faculty;
use App\Http\Requests\StoreFacultyRequest;
use App\Http\Requests\UpdateFacultyRequest;

class FacultyController extends BaseController {
    /**
     * Display a listing of the resource.
     */
    public function index() {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFacultyRequest $request) {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Faculty $faculty) {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFacultyRequest $request, Faculty $faculty) {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Faculty $faculty) {
        //
    }
}
