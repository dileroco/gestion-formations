@extends('layouts.admin')

@section('title', __('Registrations'))

@section('actions')
    <a href="{{ route('admin.inscriptions.create') }}" class="px-5 py-2.5 bg-indigo-600 text-white rounded-lg font-bold hover:bg-indigo-700 transition text-sm">
        {{ __('New Registration') }}
    </a>
@endsection

@section('content')
<div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr class="text-xs font-bold uppercase tracking-widest text-gray-500">
                    <th class="px-8 py-4 text-left">{{ __('Reference') }}</th>
                    <th class="px-8 py-4 text-left">{{ __('Participant') }}</th>
                    <th class="px-8 py-4 text-left">{{ __('Session') }}</th>
                    <th class="px-8 py-4 text-center">{{ __('Status') }}</th>
                    <th class="px-8 py-4 text-right">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($inscriptions as $inscription)
                <tr class="hover:bg-gray-50 transition duration-150">
                    <td class="px-8 py-5 font-mono text-xs font-bold text-gray-400">
                        #{{ $inscription->reference }}
                    </td>
                    <td class="px-8 py-5">
                        <div class="font-bold text-gray-900">{{ $inscription->user?->name }}</div>
                        <div class="text-xs text-gray-400">{{ $inscription->user?->email }}</div>
                    </td>
                    <td class="px-8 py-5">
                        <div class="font-medium text-gray-700 leading-tight">{{ localized_field($inscription->trainingSession->formation, 'title') }}</div>
                        <div class="text-[10px] text-gray-400 uppercase tracking-tight">{{ __('Session') }} #{{ $inscription->trainingSession->id }} &bull; {{ $inscription->trainingSession->start_date?->format('d/m/Y') }}</div>
                    </td>
                    <td class="px-8 py-5 text-center">
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-widest bg-{{ $inscription->status_badge }}-500 text-white shadow-sm">
                            {{ $inscription->status_label }}
                        </span>
                    </td>
                    <td class="px-8 py-5 text-right font-bold">
                        <div class="flex justify-end space-x-2">
                            <a href="{{ route('admin.inscriptions.edit', $inscription) }}" class="text-indigo-600 hover:underline">
                                {{ __('Edit') }}
                            </a>
                            <form action="{{ route('admin.inscriptions.destroy', $inscription) }}" method="POST" onsubmit="return confirm('{{ __('Are you sure?') }}')">
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
                        {{ __('Zero registrations found.') }}
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($inscriptions->hasPages())
    <div class="px-8 py-6 border-t border-gray-50 flex items-center justify-between text-[11px] font-bold text-gray-400">
        {{ __('Total Registrations:') }} {{ $inscriptions->total() }}
        <div class="premium-pagination">
            {{ $inscriptions->links() }}
        </div>
    </div>
    @endif
</div>
@endsection
