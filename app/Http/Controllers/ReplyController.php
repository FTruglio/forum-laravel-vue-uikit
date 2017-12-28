<?php

namespace App\Http\Controllers;

use App\Reply;
use App\Thread;
use App\Rules\SpamFree;
use Illuminate\Http\Request;
use App\Http\Requests\CreatePostForm;

class ReplyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('index', 'show');
    }
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index($channelId, Thread $thread)
    {
        return $thread->replies()->paginate(20);
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create()
    {
        //
    }

    /**
     * @param  string $channelId
     * @param  Thread
     * @param  CreatePostForm // laravel will automatically pick up on requests that are typehinted and submit the form through the form request.
     * @return json $reply
     */
    public function store($channelId, Thread $thread, CreatePostForm $form)
    {
        $reply = $form->persist($thread);
        return $reply->load('owner');
    }

    /**
    * Display the specified resource.
    *
    * @param  \App\Reply  $reply
    * @return \Illuminate\Http\Response
    */
    public function show(Reply $reply)
    {
        //
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  \App\Reply  $reply
    * @return \Illuminate\Http\Response
    */
    public function edit(Reply $reply)
    {
        //
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  \App\Reply  $reply
    * @return \Illuminate\Http\Response
    */
    public function update(Reply $reply)
    {
        $this->authorize('update', $reply);

        $this->validate(request(), ['body' => ['required', new SpamFree]]);

        $reply->update(['body' => request('body')]);
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  \App\Reply  $reply
    * @return \Illuminate\Http\Response
    */
    public function destroy(Reply $reply)
    {
        $this->authorize('update', $reply);

        $reply->delete();

        if (request()->wantsJson()) {
            return response([], 204);
        }
        return back()->with('flash', 'Reply successfully deleted');
    }
}
