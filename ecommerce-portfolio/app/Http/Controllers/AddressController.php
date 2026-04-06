<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AddressController extends Controller
{
    public function index(): View
    {
        $user      = auth('api')->user();
        $addresses = $user->addresses()->latest()->get();

        return view('profile.address', compact('user', 'addresses'));
    }

    public function store(Request $request): RedirectResponse
    {
        $user = auth('api')->user();

        $validated = $request->validate([
            'customer_name' => ['required', 'string', 'max:255'],
            'phone'         => ['required', 'string', 'max:20'],
            'address'       => ['required', 'string', 'max:1000'],
        ], [
            'customer_name.required' => 'กรุณากรอกชื่อผู้รับ',
            'phone.required'         => 'กรุณากรอกเบอร์โทรศัพท์',
            'address.required'       => 'กรุณากรอกที่อยู่',
        ]);

        $user->addresses()->create($validated);

        return redirect()->route('profile.address')->with('status', 'address-created');
    }

    public function update(Request $request, Address $address): RedirectResponse
    {
        $user = auth('api')->user();

        if ($address->user_id !== $user->id) {
            abort(403);
        }

        $validated = $request->validate([
            'customer_name' => ['required', 'string', 'max:255'],
            'phone'         => ['required', 'string', 'max:20'],
            'address'       => ['required', 'string', 'max:1000'],
        ], [
            'customer_name.required' => 'กรุณากรอกชื่อผู้รับ',
            'phone.required'         => 'กรุณากรอกเบอร์โทรศัพท์',
            'address.required'       => 'กรุณากรอกที่อยู่',
        ]);

        $address->update($validated);

        return redirect()->route('profile.address')->with('status', 'address-updated');
    }

    public function destroy(Address $address): RedirectResponse
    {
        $user = auth('api')->user();

        if ($address->user_id !== $user->id) {
            abort(403);
        }

        $address->delete();

        return redirect()->route('profile.address')->with('status', 'address-deleted');
    }
}
