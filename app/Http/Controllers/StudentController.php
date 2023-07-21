<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Http\Requests\StudentFormRequest;

class StudentController extends BaseController {
    /**
     * Display a listing of the resource.
     */
    public function index() {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StudentFormRequest $request) {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student) {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StudentFormRequest $request, Student $student) {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student) {
        //
    }
}
