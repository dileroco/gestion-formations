@extends('layouts.admin')

@section('title', __('Categories Management'))

@section('actions')
    <a href="{{ route('admin.categories.create') }}" class="px-5 py-2.5 bg-indigo-600 text-white rounded-lg font-bold hover:bg-indigo-700 transition text-sm">
        {{ __('New Category') }}
    </a>
@endsection

@section('content')
<div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr class="text-xs font-bold uppercase tracking-widest text-gray-500">
                    <th class="px-8 py-4 text-left">{{ __('Name (FR)') }}</th>
                    <th class="px-8 py-4 text-left">{{ __('Name (EN)') }}</th>
                    <th class="px-8 py-4 text-right">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($categories as $category)
                <tr class="hover:bg-gray-50 transition duration-150">
                    <td class="px-8 py-5 font-bold text-gray-900">{{ $category->name_fr }}</td>
                    <td class="px-8 py-5 font-bold text-gray-900">{{ $category->name_en }}</td>
                    <td class="px-8 py-5 text-right font-bold">
                        <div class="flex justify-end space-x-2">
                            <a href="{{ route('admin.categories.edit', $category) }}" class="text-indigo-600 hover:underline">
                                {{ __('Edit') }}
                            </a>
                            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" onsubmit="return confirm('{{ __('Are you sure?') }}')">
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
                    <td colspan="3" class="px-8 py-12 text-center text-gray-400 font-bold italic">
                        {{ __('No categories found.') }}
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($categories->hasPages())
    <div class="px-8 py-6 border-t border-gray-50 flex items-center justify-between text-[11px] font-bold text-gray-400">
        {{ __('Total Categories:') }} {{ $categories->total() }}
        <div class="premium-pagination">
            {{ $categories->links() }}
        </div>
    </div>
    @endif
</div>
@endsection
