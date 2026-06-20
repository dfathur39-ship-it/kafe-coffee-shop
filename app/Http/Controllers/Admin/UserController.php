<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        $users = User::where('role', User::ROLE_CUSTOMER)
            ->latest()
            ->paginate(15);

        return view('admin.users.index', compact('users'));
    }
}
