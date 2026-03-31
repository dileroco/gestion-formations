@extends('layouts.public')

@section('title', __('Search Results'))

@section('content')
<section class="pt-40 pb-20 bg-white min-h-[70vh]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-16 border-b border-gray-100 pb-10">
            <span class="text-xs font-black uppercase tracking-widest text-indigo-600 italic block mb-4">{{ __('Showing results for') }}</span>
            <h1 class="text-5xl font-black text-gray-900 tracking-tighter italic uppercase underline decoration-indigo-200 decoration-8 underline-offset-8">
                "{{ $query }}"
            </h1>
        </div>

        <div class="space-y-20">
            <!-- Formations Results -->
            @if($formations->isNotEmpty())
            <div>
                <h2 class="text-xl font-black text-gray-400 uppercase tracking-[0.2em] mb-10 flex items-center">
                    <svg class="h-5 w-5 mr-3 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    {{ __('Trainings') }} ({{ $formations->count() }})
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                    @foreach($formations as $formation)
                    <a href="{{ route(active_locale().'.formations.show', $formation->{active_locale() == 'fr' ? 'slug_fr' : 'slug_en'}) }}" class="group block bg-gray-50 rounded-[40px] p-8 border border-gray-100 hover:bg-white hover:shadow-2xl transition duration-500">
                        <div class="flex flex-col h-full">
                            <span class="text-[10px] font-black text-indigo-400 uppercase tracking-widest mb-4 italic">{{ localized_field($formation->category, 'name') }}</span>
                            <h3 class="text-2xl font-black text-gray-900 group-hover:text-indigo-600 transition tracking-tighter italic mb-4">
                                {{ localized_field($formation, 'title') }}
                            </h3>
                            <p class="text-sm text-gray-400 font-medium line-clamp-2 italic mb-6">
                                {{ localized_field($formation, 'short_description') }}
                            </p>
                            <div class="mt-auto flex items-center justify-between">
                                <span class="text-lg font-black text-indigo-600">{{ format_price($formation->price) }}</span>
                                <span class="text-xs font-black uppercase text-gray-400 group-hover:text-indigo-600 italic transition">{{ __('View course') }} &rarr;</span>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Blog Results -->
            @if($posts->isNotEmpty())
            <div>
                <h2 class="text-xl font-black text-gray-400 uppercase tracking-[0.2em] mb-10 flex items-center">
                    <svg class="h-5 w-5 mr-3 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                    {{ __('Blog Articles') }} ({{ $posts->count() }})
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                    @foreach($posts as $post)
                    <a href="{{ route(active_locale().'.blog.show', $post->{active_locale() == 'fr' ? 'slug_fr' : 'slug_en'}) }}" class="group flex items-center space-x-8 bg-gray-50 rounded-[40px] p-6 border border-gray-100 hover:bg-white hover:shadow-2xl transition duration-500">
                        <div class="w-32 h-32 rounded-[28px] overflow-hidden flex-shrink-0 shadow-inner">
                            <img src="https://picsum.photos/seed/{{ $post->id }}/300/300" class="w-full h-full object-cover transform group-hover:scale-110 transition duration-1000" alt="">
                        </div>
                        <div class="flex-grow">
                            <span class="text-[10px] font-black text-indigo-400 uppercase tracking-widest italic block mb-2">{{ $post->published_at?->format('d M Y') }}</span>
                            <h3 class="text-xl font-black text-gray-900 group-hover:text-indigo-600 transition tracking-tighter italic leading-tight">
                                {{ localized_field($post, 'title') }}
                            </h3>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif

            @if($formations->isEmpty() && $posts->isEmpty())
            <div class="py-20 text-center">
                <div class="w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-8">
                    <svg class="h-12 w-12 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <p class="text-2xl font-black text-gray-300 italic uppercase tracking-tighter">{{ __('No results matched your search.') }}</p>
            </div>
            @endif
        </div>
    </div>
</section>
@endsection
