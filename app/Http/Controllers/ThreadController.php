<?php

namespace App\Http\Controllers;

use App\Thread;
use App\Channel;
use App\Trending;
use App\Rules\SpamFree;
use App\Rules\Recaptcha;
use Illuminate\Http\Request;
use App\Filters\ThreadFilters;

class ThreadController extends Controller
{
    /**
     * Restricting users with auth middleware
     */
    public function __construct()
    {
        $this->middleware('auth')->except('index', 'show');
    }
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index(Channel $channel, ThreadFilters $filters, Trending $trending)
    {
        $threads = $this->getThreads($channel, $filters);

        if (request()->wantsJson()) {
            return $threads;
        }

        return view('threads.index', [
            'threads' => $threads,
            'trending' => $trending->get()
        ]);
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create()
    {
        return view('threads.create');
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(Recaptcha $recaptcha)
    {
        request()->validate([
            'channel_id' => 'required|exists:channels,id',
            'title' => ['required', new SpamFree],
            'body' => ['required', new SpamFree],
            'g-recaptcha-response' => ['required', $recaptcha]
        ]);

        $thread = Thread::create([
            'user_id' => auth()->id(),
            'channel_id' => request('channel_id'),
            'title' => request('title'),
            'body' => request('body')
        ]);

        if (request()->wantsJson()) {
            return response($thread, 201);
        }
        return redirect($thread->path())->with('flash', 'Your new thread has been created!');
    }

    /**
    * Display the specified resource.
    * @param $channel
    * @param  \App\Thread  $thread
    * @return \Illuminate\Http\Response
    */
    public function show($channel, Thread $thread, Trending $trending)
    {
        // Record that the user visited this page
        // Redord a timestamp of when they visited.
        if (auth()->check()) {
            auth()->user()->readThread($thread);
        }

        $trending->push($thread);

        $thread->visits()->record();

        return view('threads.show', compact('thread'));
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  \App\Thread  $thread
    * @return \Illuminate\Http\Response
    */
    public function edit(Thread $thread)
    {
        //
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\Thread  $thread
    * @return \Illuminate\Http\Response
    */
    public function update($channel, Thread $thread)
    {
        $this->authorize('update', $thread);

        request()->validate([
            'title' => ['required', new SpamFree],
            'body' => ['required', new SpamFree],
        ]);

        $thread->update([
            'title' => request('title'),
            'body' => request('body')
        ]);

        return $thread;
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  \App\Thread  $thread
    * @return \Illuminate\Http\Response
    */
    public function destroy($channel, Thread $thread)
    {
        $this->authorize('update', $thread);

        $thread->delete();
        if (request()->wantsJson()) {
            return response([], 204);
        }
        return redirect('/threads')->with('flash', 'Thread successfully deleted');
    }

    /**
     * returns threads with filters
     */

    public function getThreads($channel, $filters)
    {
        $threads =  Thread::latest()->filter($filters);
        if ($channel->exists) {
            $threads->where('channel_id', $channel->id);
        }
        return $threads->paginate(25);
    }
}
