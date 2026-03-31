@extends('layouts.admin')

@section('title', __('Training Sessions'))

@section('actions')
    <a href="{{ route('admin.sessions.create') }}" class="px-5 py-2.5 bg-indigo-600 text-white rounded-lg font-bold hover:bg-indigo-700 transition text-sm">
        {{ __('Add Session') }}
    </a>
@endsection

@section('content')
<div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr class="text-xs font-bold uppercase tracking-widest text-gray-500">
                    <th class="px-8 py-4 text-left">{{ __('Formation') }}</th>
                    <th class="px-8 py-4 text-left">{{ __('Trainer') }}</th>
                    <th class="px-8 py-4 text-left">{{ __('Dates') }}</th>
                    <th class="px-8 py-4 text-center">{{ __('Enrolled') }}</th>
                    <th class="px-8 py-4 text-right">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($sessions as $session)
                <tr class="hover:bg-gray-50 transition duration-150">
                    <td class="px-8 py-5">
                        <div class="font-bold text-gray-900">{{ localized_field($session->formation, 'title') }}</div>
                        <div class="text-[10px] text-gray-400 uppercase tracking-tight">ID #{{ $session->id }} &bull; {{ $session->mode->value }}</div>
                    </td>
                    <td class="px-8 py-5 text-gray-700 font-medium">
                        {{ $session->trainer?->name ?? __('System') }}
                    </td>
                    <td class="px-8 py-5 text-gray-600 font-medium">
                        {{ $session->start_date?->format('d/m/Y') }} &rarr; {{ $session->end_date?->format('d/m/Y') }}
                    </td>
                    <td class="px-8 py-5 text-center">
                        <span class="font-bold text-gray-900">{{ $session->inscriptions_count ?? $session->participants()->count() }}</span>
                        <span class="text-gray-400">/ {{ $session->capacity }}</span>
                    </td>
                    <td class="px-8 py-5 text-right font-bold">
                        <div class="flex justify-end space-x-2">
                            <a href="{{ route('admin.sessions.edit', $session) }}" class="text-indigo-600 hover:underline">
                                {{ __('Edit') }}
                            </a>
                            <form action="{{ route('admin.sessions.destroy', $session) }}" method="POST" onsubmit="return confirm('{{ __('Are you sure?') }}')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:underline">
                                    {{ __('Delete') }}
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-8 py-12 text-center text-gray-400 font-bold italic">
                        {{ __('No sessions found.') }}
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($sessions->hasPages())
    <div class="px-8 py-6 border-t border-gray-50 flex items-center justify-between text-[11px] font-bold text-gray-400">
        {{ __('Total Sessions:') }} {{ $sessions->total() }}
        <div class="premium-pagination">
            {{ $sessions->links() }}
        </div>
    </div>
    @endif
</div>
@endsection
