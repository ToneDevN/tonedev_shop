<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile page.
     */
    public function show(Request $request): View
    {
        $user = auth('api')->user();

        return view('profile.profile', compact('user'));
    }

    /**
     * Display the user's profile edit form.
     */
    public function edit(Request $request): View
    {
        $user = auth('api')->user();

        return view('profile.edit', compact('user'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request): RedirectResponse
    {
        $user = auth('api')->user();

        $validated = $request->validate([
            'username'     => ['required', 'string', 'max:255', 'unique:users,username,' . $user->id],
            'first_name'   => ['required', 'string', 'max:255'],
            'last_name'    => ['required', 'string', 'max:255'],
            'gender'       => ['nullable', 'string', 'in:male,female,other'],
            'phone_number' => ['nullable', 'string', 'max:20'],
            'birth_date'   => ['nullable', 'date'],
            // ตอนนี้รับเป็น String (Path) ที่ได้จาก API
            'avatar'       => ['nullable', 'string'],
            'image'        => ['nullable', 'string'],
        ], [
            'username.unique'     => 'ชื่อผู้ใช้นี้ถูกใช้งานแล้ว',
            'first_name.required' => 'กรุณากรอกชื่อ',
            'last_name.required'  => 'กรุณากรอกนามสกุล',
            'gender.in'           => 'เพศไม่ถูกต้อง',
        ]);

        // อัปเดต Path รูปภาพที่ส่งมาจาก JavaScript/Internal
        if ($request->filled('avatar')) {
            $user->avatar = $validated['avatar'];
        }

        if ($request->filled('image')) {
            $user->image = $validated['image'];
        }

        // อัปเดตข้อมูลอื่นๆ
        $user->username     = $validated['username'];
        $user->first_name   = $validated['first_name'];
        $user->last_name    = $validated['last_name'];
        $user->gender       = $validated['gender'];
        $user->phone_number = $validated['phone_number'];
        $user->birth_date   = $validated['birth_date'];

        $user->save();

        return Redirect::route('profile.show')->with('status', 'profile-updated');
    }

    public function password(): View
    {
        $user = auth('api')->user();
        return view('profile.password', compact('user'));
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $user = auth('api')->user();

        $request->validate([
            'current_password' => ['required', 'string'],
            'password'         => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'current_password.required' => 'กรุณากรอกรหัสผ่านปัจจุบัน',
            'password.required'         => 'กรุณากรอกรหัสผ่านใหม่',
            'password.min'              => 'รหัสผ่านต้องมีอย่างน้อย 8 ตัวอักษร',
            'password.confirmed'        => 'รหัสผ่านไม่ตรงกัน',
        ]);

        if (!\Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'รหัสผ่านปัจจุบันไม่ถูกต้อง'])->withInput();
        }

        $user->password = \Hash::make($request->password);
        $user->save();

        return redirect()->route('profile.password')->with('status', 'password-updated');
    }

    public function privacy(): View
    {
        $user = auth('api')->user();
        return view('profile.privacy', compact('user'));
    }

    public function orders(): View
    {
        $user   = auth('api')->user();
        $orders = \App\Models\Order::where('user_id', $user->id)
                    ->latest()
                    ->paginate(10);

        return view('profile.orders', compact('user', 'orders'));
    }

    public function notifications(): View
    {
        $user = auth('api')->user();
        return view('profile.notifications', compact('user'));
    }

    public function coupons(): View
    {
        $user = auth('api')->user();
        return view('profile.coupons', compact('user'));
    }

    public function coins(): View
    {
        $user = auth('api')->user();
        return view('profile.coins', compact('user'));
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $user = auth('api')->user();

        if (!$user) {
            return Redirect::route('login');
        }

        $user->delete();

        return Redirect::to('/');
    }
}
