@extends('layouts.admin')

@section('title', __('Trainings Library'))

@section('actions')
    <a href="{{ route('admin.formations.create') }}" class="px-5 py-2.5 bg-indigo-600 text-white rounded-lg font-bold hover:bg-indigo-700 transition text-sm">
        {{ __('New Training') }}
    </a>
@endsection

@section('content')
<div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr class="text-xs font-bold uppercase tracking-widest text-gray-500">
                    <th class="px-8 py-4 text-left">{{ __('Training Title') }}</th>
                    <th class="px-8 py-4 text-left">{{ __('Category') }}</th>
                    <th class="px-8 py-4 text-center">{{ __('Price') }}</th>
                    <th class="px-8 py-4 text-center">{{ __('Status') }}</th>
                    <th class="px-8 py-4 text-right">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($formations as $formation)
                <tr class="hover:bg-gray-50 transition duration-150">
                    <td class="px-8 py-5">
                        <div class="font-bold text-gray-900 line-clamp-1">{{ localized_field($formation, 'title') }}</div>
                        <div class="text-[10px] text-gray-400 font-medium uppercase tracking-tight">{{ $formation->id }} &bull; {{ $formation->duration }} {{ __('Hours') }}</div>
                    </td>
                    <td class="px-8 py-5">
                        <span class="px-3 py-1 bg-gray-100 text-gray-600 rounded-lg text-[10px] font-bold uppercase tracking-widest">
                            {{ localized_field($formation->category, 'name') }}
                        </span>
                    </td>
                    <td class="px-8 py-5 text-center">
                        <span class="text-sm font-bold text-gray-900">{{ format_price($formation->price) }}</span>
                    </td>
                    <td class="px-8 py-5 text-center">
                        <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-widest bg-{{ $formation->status_badge }}-500 text-white">
                            {{ $formation->status_label }}
                        </span>
                    </td>
                    <td class="px-8 py-5 text-right">
                        <div class="flex justify-end space-x-2">
                            <a href="{{ route('admin.formations.edit', $formation) }}" class="text-indigo-600 font-bold hover:underline">
                                {{ __('Edit') }}
                            </a>
                            <form action="{{ route('admin.formations.destroy', $formation) }}" method="POST" onsubmit="return confirm('{{ __('Are you sure?') }}')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 font-bold hover:underline">
                                    {{ __('Delete') }}
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-8 py-12 text-center text-gray-400 font-medium italic">
                        {{ __('No trainings found.') }}
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($formations->hasPages())
    <div class="px-8 py-6 border-t border-gray-50 flex items-center justify-between text-[11px] font-bold text-gray-400">
        {{ __('Total Programs:') }} {{ $formations->total() }}
        <div class="premium-pagination">
            {{ $formations->links() }}
        </div>
    </div>
    @endif
</div>
@endsection
