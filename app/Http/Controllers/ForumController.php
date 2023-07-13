<?php

namespace App\Http\Controllers;

use App\Models\Forum;
use App\Http\Requests\StoreForumRequest;
use App\Http\Requests\UpdateForumRequest;

class ForumController extends BaseController {
    /**
     * Display a listing of the resource.
     */
    public function index() {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreForumRequest $request) {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Forum $forum) {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateForumRequest $request, Forum $forum) {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Forum $forum) {
        //
    }
}
