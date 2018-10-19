<?php

namespace App\Http\Controllers;

use App\User;
use App\Activity;

class ProfilesController extends Controller
{
    public function show(User $user)
    {
        $activities = Activity::feed($user);

        return view('profiles.show', [
            'profileUser' => $user,
            'threads'     => $user->threads()->paginate(4),
            'activities'  => $activities
        ]);
    }
}
