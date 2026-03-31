@extends('layouts.public')

@section('title', __('Welcome'))

@section('content')
<!-- Hero Section -->
<section class="py-24 bg-white border-b border-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="space-y-6">
                <h1 class="text-5xl md:text-6xl font-bold text-gray-900 tracking-tight leading-tight">
                    {{ __('Elevate Your') }} <br>
                    <span class="text-indigo-600 underline">Career</span>
                </h1>
                <p class="text-lg text-gray-600 font-medium max-w-lg leading-relaxed">
                    {{ __('Master the most in-demand skills with our professional training programs. From technology to leadership, we build tomorrow.') }}
                </p>

                <div class="flex flex-wrap gap-4 pt-4">
                    <a href="{{ route(active_locale().'.formations.index') }}" class="px-8 py-3 bg-indigo-600 text-white rounded-lg font-bold hover:bg-indigo-700 transition text-sm">
                        {{ __('Explore Trainings') }}
                    </a>
                    <a href="{{ route(active_locale().'.contact.show') }}" class="px-8 py-3 bg-white text-gray-900 border border-gray-200 rounded-lg font-bold hover:bg-gray-50 transition text-sm">
                        {{ __('Contact Us') }}
                    </a>
                </div>
            </div>

            <div class="hidden lg:block">
                <div class="rounded-2xl overflow-hidden shadow-sm border border-gray-100">
                    <img src="{{ '/hero_training_1774982427914.png' }}" alt="Hero" class="w-full h-auto object-cover grayscale-0">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Courses -->
<section class="py-24 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-row items-end justify-between mb-12">
            <h2 class="text-3xl font-bold text-gray-900 tracking-tight">{{ __('Featured Trainings') }}</h2>
            <a href="{{ route(active_locale().'.formations.index') }}" class="text-indigo-600 font-bold text-sm border-b-2 border-indigo-100 hover:border-indigo-600 transition pb-1">
                {{ __('View All') }} &rarr;
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($featuredFormations as $formation)
            <div class="bg-white rounded-xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-md transition">
                <div class="h-48 bg-gray-100 overflow-hidden relative">
                    @if($formation->image)
                        <img src="{{ Storage::url($formation->image) }}" class="w-full h-full object-cover" alt="">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-300">
                            <svg class="h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                    @endif
                </div>
                <div class="p-6">
                    <span class="text-[10px] font-bold text-indigo-600 uppercase tracking-widest block mb-2">{{ localized_field($formation->category, 'name') }}</span>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">{{ localized_field($formation, 'title') }}</h3>
                    <p class="text-sm text-gray-500 mb-6 line-clamp-2">{{ localized_field($formation, 'short_description') }}</p>
                    <div class="flex items-center justify-between pt-4 border-t border-gray-50">
                        <span class="text-lg font-bold text-gray-900">{{ format_price($formation->price) }}</span>
                        <a href="{{ route(active_locale().'.formations.show', $formation->{active_locale() == 'fr' ? 'slug_fr' : 'slug_en'}) }}" class="text-indigo-600 text-sm font-bold hover:underline">
                            {{ __('Learn More') }}
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Blog Section -->
<section class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold text-gray-900 tracking-tight">{{ __('From Our Blog') }}</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
            @foreach($recentPosts as $post)
            <article>
                <div class="aspect-video rounded-xl bg-gray-100 overflow-hidden mb-6">
                    <img src="https://picsum.photos/seed/{{ $post->id }}/800/600" class="w-full h-full object-cover grayscale-0 group-hover:grayscale-0" alt="">
                </div>
                <div class="space-y-3">
                    <div class="text-xs font-medium text-gray-500 uppercase">
                        {{ $post->published_at?->format('d M, Y') }} &bull; {{ localized_field($post->category, 'name') }}
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 hover:text-indigo-600 transition">
                        <a href="{{ route(active_locale().'.blog.show', $post->{active_locale() == 'fr' ? 'slug_fr' : 'slug_en'}) }}">
                            {{ localized_field($post, 'title') }}
                        </a>
                    </h3>
                </div>
            </article>
            @endforeach
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="py-20 bg-indigo-600 text-white text-center">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold mb-8 transition">{{ __('Ready to Start Your Journey?') }}</h2>
        <a href="{{ route(active_locale().'.contact.show') }}" class="inline-block px-10 py-4 bg-white text-indigo-600 font-bold rounded-lg hover:bg-gray-100 transition text-sm">
            {{ __('Get in Touch Now') }}
        </a>
    </div>
</section>
@endsection
