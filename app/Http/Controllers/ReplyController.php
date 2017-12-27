<?php

namespace App\Http\Controllers;

use App\Reply;
use App\Thread;
use App\Inspections\Spam;
use Illuminate\Http\Request;

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
     * @param  Spam
     * @return [type]
     */
    public function store($channelId, Thread $thread, Spam $spam)
    {
        try {
            $this->validateReply();

            $reply = $thread->addReply(
                [
                    'user_id' => auth()->id(),
                    'body' => request('body')
                ]
            );
        } catch (\Exception $e) {
            return response(
                'Sorry, your reply could not be saved at this time.',
                422
            );
        }
        // For ajax requests that expect json
        if (request()->expectsJson()) {
            return $reply->load('owner');
        }

        return back()->with('flash', 'Your reply has been added to the thread!');
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
    public function update(Reply $reply, Spam $spam)
    {
        $this->authorize('update', $reply);

        try {
            $this->validateReply();

            $reply->update(['body' => request('body')]);
        } catch (\Exception $e) {
            return response(
                'Sorry, your reply could not be saved at this time.',
                422
            );
        }
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

    public function validateReply()
    {
        $this->validate(request(), ['body' => 'required']);
        resolve(Spam::class)->detect(request('body'));
    }
}
