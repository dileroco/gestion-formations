@extends('layouts.admin')

@section('title', __('Users Management'))

@section('actions')
    <a href="{{ route('admin.users.create') }}" class="px-5 py-2.5 bg-indigo-600 text-white rounded-lg font-bold hover:bg-indigo-700 transition text-sm">
        {{ __('New User') }}
    </a>
@endsection

@section('content')
<div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr class="text-xs font-bold uppercase tracking-widest text-gray-500">
                    <th class="px-8 py-4 text-left">{{ __('User') }}</th>
                    <th class="px-8 py-4 text-left">{{ __('Role') }}</th>
                    <th class="px-8 py-4 text-center">{{ __('Active') }}</th>
                    <th class="px-8 py-4 text-right">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($users as $user)
                <tr class="hover:bg-gray-50 transition duration-150">
                    <td class="px-8 py-5">
                        <div class="font-bold text-gray-900">{{ $user->name }}</div>
                        <div class="text-xs text-gray-400 font-medium">{{ $user->email }}</div>
                    </td>
                    <td class="px-8 py-5">
                        <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-lg text-[10px] font-bold uppercase tracking-widest">
                            {{ $user->getRoleNames()->first() }}
                        </span>
                    </td>
                    <td class="px-8 py-5 text-center" x-data="{ active: {{ $user->is_active ? 'true' : 'false' }} }">
                        <button @click="active = !active; toggleStatus({{ $user->id }})" class="relative inline-flex h-5 w-10 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 focus:outline-none" :class="active ? 'bg-indigo-600' : 'bg-gray-200'">
                            <span class="pointer-events-none inline-block h-4 w-4 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out" :class="active ? 'translate-x-5' : 'translate-x-0'"></span>
                        </button>
                    </td>
                    <td class="px-8 py-5 text-right">
                        <div class="flex justify-end space-x-2">
                            <a href="{{ route('admin.users.edit', $user) }}" class="text-indigo-600 font-bold hover:underline">
                                {{ __('Edit') }}
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-8 py-12 text-center text-gray-400 font-medium italic">
                        {{ __('No users found.') }}
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($users->hasPages())
    <div class="px-8 py-6 border-t border-gray-50 flex items-center justify-between text-[11px] font-medium text-gray-400">
        {{ __('Total Users:') }} {{ $users->total() }}
        <div class="premium-pagination">
            {{ $users->links() }}
        </div>
    </div>
    @endif
</div>

@push('scripts')
<script>
    function toggleStatus(id) {
        fetch(`/admin/users/${id}/toggle-active`, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        });
    }
</script>
@endpush
@endsection
