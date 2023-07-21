<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Http\Requests\QuestionFormRequest;

class QuestionController extends BaseController {
    /**
     * Display a listing of the resource.
     */
    public function index() {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(QuestionFormRequest $request) {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Question $question) {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(QuestionFormRequest $request, Question $question) {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Question $question) {
        //
    }
}
