<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserNotificationsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
      return auth()->user()->unreadNotifications;
    }

    public function destroy(User $user, $notificationId)
    {
      $user->notifications()->find($notificationId)->markAsRead();
    }
}
