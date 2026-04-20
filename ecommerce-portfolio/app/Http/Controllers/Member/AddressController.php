<?php

declare(strict_types=1);

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Address;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AddressController extends Controller
{
    public function index(): View
    {
        $addresses = auth()->user()->addresses()->latest()->get();

        return view('member.addresses.index', compact('addresses'));
    }

    public function create(): View
    {
        return view('member.addresses.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'label' => ['nullable', 'string', 'max:50'],
            'recipient_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'address' => ['required', 'string', 'max:1000'],
            'city' => ['nullable', 'string', 'max:100'],
            'state' => ['nullable', 'string', 'max:100'],
            'zip_code' => ['nullable', 'string', 'max:10'],
            'is_default' => ['boolean'],
        ]);

        DB::transaction(function () use ($validated): void {
            if ($validated['is_default'] ?? false) {
                auth()->user()->addresses()->update(['is_default' => false]);
            }

            auth()->user()->addresses()->create($validated);
        });

        return redirect()->route('addresses.index')->with('success', 'เพิ่มที่อยู่เรียบร้อยแล้ว');
    }

    public function edit(Address $address): View
    {
        abort_unless($address->user_id === auth()->id(), 403);

        return view('member.addresses.edit', compact('address'));
    }

    public function update(Request $request, Address $address): RedirectResponse
    {
        abort_unless($address->user_id === auth()->id(), 403);

        $validated = $request->validate([
            'label' => ['nullable', 'string', 'max:50'],
            'recipient_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'address' => ['required', 'string', 'max:1000'],
            'city' => ['nullable', 'string', 'max:100'],
            'state' => ['nullable', 'string', 'max:100'],
            'zip_code' => ['nullable', 'string', 'max:10'],
            'is_default' => ['boolean'],
        ]);

        DB::transaction(function () use ($address, $validated): void {
            if ($validated['is_default'] ?? false) {
                auth()->user()->addresses()
                    ->where('id', '!=', $address->id)
                    ->update(['is_default' => false]);
            }

            $address->update($validated);
        });

        return redirect()->route('addresses.index')->with('success', 'แก้ไขที่อยู่เรียบร้อยแล้ว');
    }

    public function destroy(Address $address): RedirectResponse
    {
        abort_unless($address->user_id === auth()->id(), 403);
        $address->delete();

        return redirect()->route('addresses.index')->with('success', 'ลบที่อยู่เรียบร้อยแล้ว');
    }
}
