@extends('layouts.admin')

@section('title', __('Dashboard Overview'))

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
    <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm">
        <div class="text-sm font-medium text-gray-500 uppercase tracking-widest mb-1">{{ __('Total Students') }}</div>
        <div class="text-3xl font-bold text-gray-900">{{ $stats['users_count'] }}</div>
    </div>
    
    <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm">
        <div class="text-sm font-medium text-gray-500 uppercase tracking-widest mb-1">{{ __('Active Trainings') }}</div>
        <div class="text-3xl font-bold text-indigo-600">{{ $stats['formations_count'] }}</div>
    </div>

    <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm">
        <div class="text-sm font-medium text-gray-500 uppercase tracking-widest mb-1">{{ __('Upcoming Sessions') }}</div>
        <div class="text-3xl font-bold text-gray-900">{{ $stats['sessions_count'] }}</div>
    </div>

    <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm">
        <div class="text-sm font-medium text-gray-500 uppercase tracking-widest mb-1">{{ __('Pending Reg.') }}</div>
        <div class="text-3xl font-bold text-emerald-600">{{ $stats['pending_inscriptions'] }}</div>
    </div>
</div>

<div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="px-8 py-6 border-b border-gray-50">
        <h2 class="text-lg font-bold text-gray-900">{{ __('Recent Activity') }}</h2>
    </div>
    
    <div class="table-content">
        <table class="min-w-full text-sm">
            <thead>
                <tr class="bg-gray-50 text-gray-500 text-xs font-bold uppercase tracking-widest">
                    <th class="px-8 py-4 text-left">{{ __('Participant') }}</th>
                    <th class="px-8 py-4 text-left">{{ __('Session') }}</th>
                    <th class="px-8 py-4 text-center">{{ __('Status') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse ($recentInscriptions as $inscription)
                <tr class="hover:bg-gray-50 transition duration-150">
                    <td class="px-8 py-4">
                        <div class="font-bold text-gray-900">{{ $inscription->user?->name }}</div>
                        <div class="text-xs text-gray-400">{{ $inscription->user?->email }}</div>
                    </td>
                    <td class="px-8 py-4">
                        <div class="font-medium text-gray-700">{{ localized_field($inscription->trainingSession->formation, 'title') }}</div>
                        <div class="text-xs text-gray-400">{{ $inscription->trainingSession->start_date?->format('d/m/Y') }}</div>
                    </td>
                    <td class="px-8 py-4 text-center">
                        <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-widest bg-{{ $inscription->status_badge }}-500 text-white">
                            {{ $inscription->status_label }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="px-8 py-12 text-center text-gray-400 font-medium italic">
                        {{ __('No recent activity to show.') }}
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
