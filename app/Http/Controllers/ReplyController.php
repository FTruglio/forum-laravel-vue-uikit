<?php

namespace App\Http\Controllers;

use App\Reply;
use App\Thread;
use App\Rules\SpamFree;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
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
        // If you want to catch the policy error and return a custom error message us the Gate facade.

        // if (Gate::denies('create', new Reply)) {
        //     return response(
        //         'You are posting to frequently. Please take a break',
        //         429
        //     );
        // }

        // If you do not need to catch the customer error message you can validate the policy short hand.
        // $this->authorize('create', new Reply);

        // $this->validate(request(), ['body' => ['required', new SpamFree]]);
        $form->persist($thread);
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

        try {
            $this->validate(request(), ['body' => ['required', new SpamFree]]);

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
}
