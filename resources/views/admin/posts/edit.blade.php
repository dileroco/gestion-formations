@extends('layouts.admin')

@section('title', isset($post) ? __('Edit Post') : __('New Post'))

@section('content')
<div class="max-w-6xl mx-auto py-6 font-medium">
    <div class="bg-white shadow rounded-xl overflow-hidden border border-gray-100">
        <form action="{{ isset($post) ? route('admin.posts.update', $post) : route('admin.posts.store') }}" 
              method="POST" 
              class="p-8">
            @csrf
            @if(isset($post))
                @method('PATCH')
            @endif

            <!-- Multi-Language Section -->
            <div class="mb-10 p-8 bg-slate-50 rounded-2xl border-l-[6px] border-indigo-600 shadow-sm">
                <h4 class="text-xl font-black text-gray-800 mb-8 flex items-center uppercase tracking-tight">
                    <svg class="h-6 w-6 mr-3 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5a18.022 18.022 0 01-3.827-5.802M13.676 10H7M11 21s-2-3-2-8a14.444 14.444 0 008 4.5V21"/></svg>
                    {{ __('Bilingual Blog Content') }}
                </h4>
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                    <!-- Français -->
                    <div class="space-y-8">
                        <span class="inline-block px-4 py-1.5 bg-blue-600 text-white rounded font-black text-[10px] uppercase shadow-sm">FRANÇAIS</span>
                        <div>
                            <label for="title_fr" class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wide">{{ __('Title (FR)') }}</label>
                            <input type="text" name="title_fr" id="title_fr" value="{{ old('title_fr', $post->title_fr ?? '') }}" 
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 py-3 font-bold" required>
                        </div>
                        <div>
                            <label for="content_fr" class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wide">{{ __('Content (FR)') }}</label>
                            <textarea name="content_fr" id="content_fr" rows="12" 
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 py-3 leading-relaxed" required>{{ old('content_fr', $post->content_fr ?? '') }}</textarea>
                        </div>
                    </div>

                    <!-- English -->
                    <div class="space-y-8 border-l lg:pl-12">
                        <span class="inline-block px-4 py-1.5 bg-red-600 text-white rounded font-black text-[10px] uppercase shadow-sm">ENGLISH</span>
                        <div>
                            <label for="title_en" class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wide">{{ __('Title (EN)') }}</label>
                            <input type="text" name="title_en" id="title_en" value="{{ old('title_en', $post->title_en ?? '') }}" 
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 py-3 font-bold" required>
                        </div>
                        <div>
                            <label for="content_en" class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wide">{{ __('Content (EN)') }}</label>
                            <textarea name="content_en" id="content_en" rows="12" 
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 py-3 leading-relaxed" required>{{ old('content_en', $post->content_en ?? '') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Settings Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10 mb-12">
                <div class="col-span-1">
                    <label for="category_id" class="block text-sm font-bold text-gray-700 mb-2">{{ __('Category') }}</label>
                    <select name="category_id" id="category_id" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 py-3 font-bold" required>
                        <option value="">{{ __('Select Category') }}</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $post->category_id ?? '') == $category->id ? 'selected' : '' }}>
                                {{ localized_field($category, 'name') }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-span-1">
                    <label for="status" class="block text-sm font-bold text-gray-700 mb-2">{{ __('Status') }}</label>
                    <select name="status" id="status" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 py-3 font-bold" required>
                        <option value="draft" {{ old('status', $post->status->value ?? '') == 'draft' ? 'selected' : '' }}>{{ __('Brouillon') }} / {{ __('Draft') }}</option>
                        <option value="published" {{ old('status', $post->status->value ?? '') == 'published' ? 'selected' : '' }}>{{ __('Publié') }} / {{ __('Published') }}</option>
                    </select>
                </div>

                <div class="col-span-1">
                    <label for="published_at" class="block text-sm font-bold text-gray-700 mb-2">{{ __('Publication Date') }}</label>
                    <input type="datetime-local" name="published_at" id="published_at" value="{{ old('published_at', isset($post) && $post->published_at ? $post->published_at->format('Y-m-d\TH:i') : '') }}" 
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 py-3">
                </div>
            </div>

            <!-- SEO Accordion -->
            <div x-data="{ expanded: false }" class="mb-12 bg-gray-50 rounded-2xl overflow-hidden shadow-sm border border-gray-200">
                <button @click="expanded = !expanded" type="button" class="w-full flex items-center justify-between px-8 py-5 text-left focus:outline-none bg-indigo-50 hover:bg-indigo-100 transition duration-300">
                    <span class="text-sm font-black text-indigo-900 flex items-center uppercase tracking-widest">
                        <svg class="h-5 w-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        {{ __('SEO Meta Optimization') }}
                    </span>
                    <svg class="h-5 w-5 text-indigo-500 transition-transform duration-300" :class="expanded ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>

                <div x-show="expanded" x-collapse class="p-10 grid grid-cols-1 md:grid-cols-2 gap-12 border-t border-indigo-100">
                    <div class="space-y-6">
                        <span class="text-[10px] font-black text-blue-600 bg-blue-50 px-2 py-1 rounded">SEO FRENCH</span>
                        <div>
                            <label for="seo_title_fr" class="block text-xs font-bold text-gray-500 mb-2">{{ __('Meta Title (FR)') }}</label>
                            <input type="text" name="seo_title_fr" id="seo_title_fr" value="{{ old('seo_title_fr', $post->seo_title_fr ?? '') }}" 
                                class="w-full rounded-lg border-gray-300 py-3 text-sm">
                        </div>
                        <div>
                            <label for="meta_description_fr" class="block text-xs font-bold text-gray-500 mb-2">{{ __('Meta Description (FR)') }}</label>
                            <textarea name="meta_description_fr" id="meta_description_fr" rows="3" 
                                class="w-full rounded-lg border-gray-300 text-sm">{{ old('meta_description_fr', $post->meta_description_fr ?? '') }}</textarea>
                        </div>
                    </div>
                    <div class="space-y-6 border-l lg:pl-10">
                        <span class="text-[10px] font-black text-red-600 bg-red-50 px-2 py-1 rounded">SEO ENGLISH</span>
                        <div>
                            <label for="seo_title_en" class="block text-xs font-bold text-gray-500 mb-2">{{ __('Meta Title (EN)') }}</label>
                            <input type="text" name="seo_title_en" id="seo_title_en" value="{{ old('seo_title_en', $post->seo_title_en ?? '') }}" 
                                class="w-full rounded-lg border-gray-300 py-3 text-sm">
                        </div>
                        <div>
                            <label for="meta_description_en" class="block text-xs font-bold text-gray-500 mb-2">{{ __('Meta Description (EN)') }}</label>
                            <textarea name="meta_description_en" id="meta_description_en" rows="3" 
                                class="w-full rounded-lg border-gray-300 text-sm">{{ old('meta_description_en', $post->meta_description_en ?? '') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="mt-12 flex justify-end space-x-5 border-t border-gray-100 pt-10">
                <a href="{{ route('admin.posts.index') }}" class="px-8 py-3.5 bg-gray-100 text-gray-600 font-bold rounded-xl hover:bg-gray-200 transition duration-300 uppercase text-xs tracking-widest">
                    {{ __('Discard') }}
                </a>
                <button type="submit" class="px-10 py-3.5 bg-indigo-600 text-white font-black rounded-xl hover:bg-indigo-700 shadow-xl shadow-indigo-200 transform hover:-translate-y-1 transition duration-300 uppercase text-xs tracking-widest">
                    {{ isset($post) ? __('Update Article') : __('Publish Article') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
