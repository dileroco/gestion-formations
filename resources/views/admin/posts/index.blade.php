@extends('layouts.admin')

@section('title', __('Blog Management'))

@section('actions')
    <a href="{{ route('admin.posts.create') }}" class="px-5 py-2.5 bg-indigo-600 text-white rounded-lg font-bold hover:bg-indigo-700 transition text-sm">
        {{ __('New Post') }}
    </a>
@endsection

@section('content')
<div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr class="text-xs font-bold uppercase tracking-widest text-gray-500">
                    <th class="px-8 py-4 text-left">{{ __('Article') }}</th>
                    <th class="px-8 py-4 text-left">{{ __('Category') }}</th>
                    <th class="px-8 py-4 text-left">{{ __('Author') }}</th>
                    <th class="px-8 py-4 text-center">{{ __('Status') }}</th>
                    <th class="px-8 py-4 text-right">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($posts as $post)
                <tr class="hover:bg-gray-50 transition duration-150">
                    <td class="px-8 py-5">
                        <div class="font-bold text-gray-900 line-clamp-1">{{ $post->title_fr }}</div>
                        <div class="text-[10px] text-gray-400 font-medium uppercase tracking-tight">{{ $post->published_at?->format('d/m/Y') ?? __('Draft') }}</div>
                    </td>
                    <td class="px-8 py-5">
                        <span class="text-xs font-medium text-gray-600">{{ localized_field($post->category, 'name') }}</span>
                    </td>
                    <td class="px-8 py-5">
                        <span class="text-xs font-bold text-gray-900">{{ $post->author?->name ?? __('System') }}</span>
                    </td>
                    <td class="px-8 py-5 text-center">
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-widest bg-{{ $post->status_badge }}-500 text-white">
                            {{ $post->status_label }}
                        </span>
                    </td>
                    <td class="px-8 py-5 text-right font-bold text-sm">
                        <div class="flex justify-end space-x-2">
                            <a href="{{ route('admin.posts.edit', $post) }}" class="text-indigo-600 hover:underline">
                                {{ __('Edit') }}
                            </a>
                            <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" onsubmit="return confirm('{{ __('Are you sure?') }}')">
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
                        {{ __('No blog posts found.') }}
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($posts->hasPages())
    <div class="px-8 py-6 border-t border-gray-50 flex items-center justify-between text-[11px] font-bold text-gray-400">
        {{ __('Total Articles:') }} {{ $posts->total() }}
        <div class="premium-pagination">
            {{ $posts->links() }}
        </div>
    </div>
    @endif
</div>
@endsection
