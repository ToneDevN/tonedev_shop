@extends('layouts.admin')

@section('title', 'จัดการผู้ใช้')
@section('page-title', 'จัดการผู้ใช้งาน')
@section('page-subtitle', 'ดูและจัดการบัญชีผู้ใช้ทั้งหมดในระบบ')

@section('content')
<div class="space-y-6">

    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <p class="text-gray-400 text-sm">ผู้ใช้ทั้งหมด <span class="text-white font-semibold">{{ $users->total() }}</span> บัญชี</p>
        </div>
    </div>

    {{-- Table --}}
    <div class="bg-slate-900 border border-white/[0.06] rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-white/5">
                        <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider px-5 py-4">ผู้ใช้</th>
                        <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider px-5 py-4">Role</th>
                        <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider px-5 py-4">เบอร์โทร</th>
                        <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider px-5 py-4">สมัครเมื่อ</th>
                        <th class="text-right text-xs font-semibold text-gray-500 uppercase tracking-wider px-5 py-4">การจัดการ</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/[0.04]">
                    @forelse($users as $u)
                    <tr class="hover:bg-white/[0.02] transition-colors">
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-gradient-to-br from-violet-500 to-purple-600 flex items-center justify-center font-bold text-white text-sm shrink-0">
                                    {{ strtoupper(substr($u->first_name ?? 'U', 0, 1)) }}
                                </div>
                                <div>
                                    <p class="text-white text-sm font-medium">{{ $u->first_name }} {{ $u->last_name }}</p>
                                    <p class="text-gray-500 text-xs">{{ $u->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-4">
                            @php
                                $roleColors = [
                                    'admin'  => 'bg-rose-500/15 text-rose-400 ring-rose-500/20',
                                    'owner'  => 'bg-violet-500/15 text-violet-400 ring-violet-500/20',
                                    'member' => 'bg-blue-500/15 text-blue-400 ring-blue-500/20',
                                    'guest'  => 'bg-gray-500/15 text-gray-400 ring-gray-500/20',
                                ];
                                $rc = $roleColors[$u->role] ?? 'bg-gray-500/15 text-gray-400 ring-gray-500/20';
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-xs font-semibold ring-1 {{ $rc }}">
                                {{ $u->role }}
                            </span>
                        </td>
                        <td class="px-5 py-4">
                            <span class="text-gray-400 text-sm">{{ $u->phone_number ?? '—' }}</span>
                        </td>
                        <td class="px-5 py-4">
                            <span class="text-gray-500 text-xs">{{ $u->created_at->format('d/m/Y') }}</span>
                        </td>
                        <td class="px-5 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                {{-- Change role form --}}
                                <form action="{{ route('admin.users.updateRole', $u) }}" method="POST" class="flex items-center gap-2">
                                    @csrf @method('PATCH')
                                    <select name="role"
                                            class="bg-slate-800 border border-white/10 text-white text-xs rounded-lg px-2 py-1.5 focus:outline-none focus:ring-1 focus:ring-rose-500">
                                        @foreach(['guest','member','owner','admin'] as $r)
                                        <option value="{{ $r }}" @selected($u->role === $r)>{{ $r }}</option>
                                        @endforeach
                                    </select>
                                    <button type="submit"
                                            class="bg-rose-500/15 hover:bg-rose-500/25 text-rose-400 text-xs px-3 py-1.5 rounded-lg font-medium transition-colors">
                                        บันทึก
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-5 py-12 text-center text-gray-500 text-sm">ไม่พบผู้ใช้งาน</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
        <div class="px-5 py-4 border-t border-white/5">
            {{ $users->links() }}
        </div>
        @endif
    </div>

</div>
@endsection
