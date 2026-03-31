@extends('layouts.public')

@section('title', $post->{active_locale() == 'fr' ? 'seo_title_fr' : 'seo_title_en'} ?? localized_field($post, 'title'))
@section('meta_description', $post->{active_locale() == 'fr' ? 'meta_description_fr' : 'meta_description_en'} ?? '')

@section('content')
<section class="py-24 bg-white">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="space-y-12">
            <nav class="flex text-[10px] font-bold uppercase tracking-widest text-indigo-600">
                <a href="{{ route(active_locale().'.blog.index') }}" class="hover:text-indigo-800 transition underline underline-offset-4">{{ __('Blog') }}</a>
                <span class="mx-3 text-gray-300">/</span>
                <span class="text-gray-400">{{ localized_field($post->category, 'name') }}</span>
            </nav>

            <div class="space-y-6">
                <h1 class="text-4xl md:text-5xl font-bold text-gray-900 tracking-tight leading-tight">
                    {{ localized_field($post, 'title') }}
                </h1>
                
                <div class="flex items-center space-x-4 border-b border-gray-50 pb-8">
                    <div class="text-sm">
                        <span class="font-bold text-gray-900">{{ $post->author?->name }}</span>
                        <span class="mx-2 text-gray-300">|</span>
                        <span class="text-gray-400">{{ $post->published_at?->translatedFormat('d F Y') }}</span>
                    </div>
                </div>
            </div>

            <div class="prose prose-indigo prose-lg max-w-none text-gray-700 leading-relaxed">
                @if(str_contains(localized_field($post, 'content'), '<'))
                    {!! localized_field($post, 'content') !!}
                @else
                    {!! nl2br(e(localized_field($post, 'content'))) !!}
                @endif
            </div>

            <div class="pt-16 border-t border-gray-100">
                <div class="bg-gray-50 rounded-xl p-10 text-center space-y-6">
                    <h4 class="text-xl font-bold text-gray-900">{{ __('Share this article') }}</h4>
                    <div class="flex justify-center space-x-8 text-sm font-bold text-indigo-600 uppercase tracking-widest">
                        <a href="https://twitter.com/intent/tweet?text={{ urlencode(localized_field($post, 'title')) }}&url={{ request()->url() }}" class="hover:underline">Twitter</a>
                        <a href="https://linkedin.com/shareArticle?mini=true&url={{ request()->url() }}&title={{ urlencode(localized_field($post, 'title')) }}" class="hover:underline">LinkedIn</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
