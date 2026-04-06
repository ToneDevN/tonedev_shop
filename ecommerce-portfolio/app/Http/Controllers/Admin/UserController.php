<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    public function updateRole(Request $request, User $user)
    {
        $request->validate(['role' => 'required|in:guest,member,owner,admin']);

        // ป้องกันการแก้ไข role ของตัวเอง
        if ($user->id === auth('api')->id()) {
            return back()->with('error', 'ไม่สามารถเปลี่ยน Role ของตัวเองได้');
        }

        $user->update(['role' => $request->role]);
        return back()->with('success', 'อัปเดต Role เรียบร้อยแล้ว');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth('api')->id()) {
            return back()->with('error', 'ไม่สามารถลบบัญชีตัวเองได้');
        }
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'ลบผู้ใช้เรียบร้อยแล้ว');
    }
}
