<?php

namespace App\Http\Controllers;

use App\Thread;
use App\Channel;
use Illuminate\Http\Request;

class ThreadsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     * Se tiver uma lista de channels associada ele mostra somente
     * as threads daquele chennel. Isso se dá por duas rotas:
     * Uma que mostra todas as threads e outra que mostra somente
     * as threads de uma channel específica. Essa segunda rota pede
     * um parâmetro que é o slug da channel.
     *
     * @param Channel $channel
     * @return \Illuminate\Http\Response
     */
    public function index(Channel $channel)
    {
        $threads = Thread::latest()->get();
        //Como eu tinha feito,usando somente $channelSlug = null como parâmetro:
        // if ($channelSlug) {
        //     $threads = Thread::join('channels', 'threads.channel_id', 'channels.id')
        //     ->where('channels.slug', $channelSlug)
        //     ->orderBy('threads.created_at', 'desc')
        //     ->get();
        // }

        if ($channel->exists) {
            $threads = $channel->threads()->latest()->get();
        }

        return view('threads.index', compact('threads'));
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
    public function store(Request $request)
    {
        $this->validate($request, [
            'title'     => 'required',
            'body'      => 'required',
            'channel_id'=> 'required|exists:channels,id'
        ]);

        $thread = Thread::create([
            'user_id'   => auth()->id(),
            'channel_id'=> request('channel_id'),
            'title'     => request('title'),
            'body'      => request('body')
        ]);

        return redirect($thread->path());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function show($channelId, Thread $thread)
    {
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
    public function update(Request $request, Thread $thread)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function destroy(Thread $thread)
    {
        //
    }
}
