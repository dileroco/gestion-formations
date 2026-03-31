@extends('layouts.public')

@section('title', __('Blog'))

@section('content')
<section class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mb-16">
            <h1 class="text-4xl font-bold text-gray-900 tracking-tight mb-4">{{ __('Insights & News') }}</h1>
            <p class="text-lg text-gray-600 leading-relaxed">{{ __('Discover our latest articles on professional development and training.') }}</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12">
            @foreach($posts as $post)
            <article class="group">
                <div class="aspect-video rounded-xl bg-gray-50 overflow-hidden mb-6 border border-gray-100 shadow-sm">
                    <img src="https://picsum.photos/seed/{{ $post->id }}/800/600" class="w-full h-full object-cover grayscale-0 group-hover:grayscale-0" alt="">
                </div>
                <div class="space-y-3">
                    <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest whitespace-nowrap">
                        {{ $post->published_at?->format('d M, Y') }} &bull; {{ localized_field($post->category, 'name') }}
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 hover:text-indigo-600 transition tracking-tight">
                        <a href="{{ route(active_locale().'.blog.show', $post->{active_locale() == 'fr' ? 'slug_fr' : 'slug_en'}) }}">
                            {{ localized_field($post, 'title') }}
                        </a>
                    </h3>
                </div>
            </article>
            @endforeach
        </div>

        <div class="mt-12">
            {{ $posts->links() }}
        </div>
    </div>
</section>
@endsection
