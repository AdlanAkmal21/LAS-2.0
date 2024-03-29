<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\ApproverTrait;
use App\Traits\IndexTrait;
use App\Traits\UserTrait;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    use UserTrait;
    use IndexTrait;
    use ApproverTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->off_duty_index();
        $this->check_application_index();
        $this->user_index();

        $dashboard_user_array = $this->dashboard_user(Auth::id());

        // dd($dashboard_user_array);

        (Auth::user()->role_id == 3)
            ? $dashboard_pendings = $this->dashboard_pendings(Auth::id())
            : $dashboard_pendings = null;

        return view('user.dashboard', compact('dashboard_user_array', 'dashboard_pendings'));
    }

    /**
     * Display user detail.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->check_approver($id);
        $user   = User::find($id);

        // dd($user->approver);
        return view('user.employee_detail', compact('user'));
    }

    /**
     * Show the notifications page.
     *
     * @return \Illuminate\Http\Response
     */
    public function view_notifications()
    {
        //Workaround to notifications() 1013 error.
        //Must access User model to use Notifiable trait.
        $user = User::find(Auth::id());
        $notifications = $user->notifications()->paginate(5);

        return view('user.notifications', compact('notifications'));
    }

    /**
     * Marks notifications as read.
     *
     * @return \Illuminate\Http\Response
     */
    public function read_notifications()
    {
        //Must access User model to use Notifiable trait.
        $user = User::find(Auth::id());
        $user->unreadNotifications->markAsRead();

        return redirect()->route('user.view_notifications');
    }

    /**
     * Clears the notifications.
     *
     * @return \Illuminate\Http\Response
     */
    public function clear_notifications()
    {
        //Must access User model to use Notifiable trait.
        $user = User::find(Auth::id());
        $user->notifications()->delete();

        return redirect()->route('user.view_notifications')->withInput()->with('success', 'Notifications cleared.');
    }

}
