<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\User\SendUserNotificationsJob;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NotificationController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $users = $this->query($request)->paginate(20)->withQueryString();

        return view('admin.notifications.create', compact('users'));
    }

    public function query(Request|array $request): User|Builder
    {
        if ($request instanceof Request) {
            $request = $request->all();
        }

        if (! empty($request['user_id'])) {
            $users = (new User)->where('id', $request['user_id']);
        } else {
            $users = User::query();

            if (! empty($request['user'])) {
                $user = $request['user'];

                if ($user == 'active') {
                    // 寻找有 host 的用户
                    $users = $users->whereHas('hosts');
                } elseif ($user == 'normal') {
                    $users = $users->whereNull('banned_at');
                } elseif ($user == 'banned') {
                    $users = $users->whereNotNull('banned_at');
                }
            }
        }

        // 是否是营销邮件
        if (! empty($request['receive_marketing_email'])) {
            $users = $users->where('receive_marketing_email', true);
        }

        return $users;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'user_id' => 'nullable',
            'user' => 'nullable',
            'send_mail' => 'boolean',
        ]);

        // send mail 是 checkbox，值为 1
        $send_mail = 1;

        dispatch(new SendUserNotificationsJob($request->toArray(), $request->input('title'), $request->input('content'), $send_mail));

        return back()->with('success', '通知发送成功。')->withInput();
    }
}
