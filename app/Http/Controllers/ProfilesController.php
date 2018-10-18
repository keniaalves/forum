<?php

namespace App\Http\Controllers;

use App\User;

class ProfilesController extends Controller
{
    public function show(User $user)
    {
        $activities = $user->activities()->latest()->with('subject')->get()->groupBy(function ($activity) {
            return $activity->created_at->format('Y-m-d');
        });

        return view('profiles.show', [
            'profileUser' => $user,
            'threads'     => $user->threads()->paginate(4),
            'activities'  => $activities
        ]);
    }
}
