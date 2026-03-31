@extends('layouts.admin')

@section('title', isset($formation) ? __('Edit Formation') : __('Add Formation'))

@section('content')
<div class="max-w-6xl mx-auto py-6">
    <div class="bg-white shadow rounded-lg overflow-hidden border border-gray-100">
        <form action="{{ isset($formation) ? route('admin.formations.update', $formation) : route('admin.formations.store') }}" 
              method="POST" 
              enctype="multipart/form-data" 
              class="p-8">
            @csrf
            @if(isset($formation))
                @method('PATCH')
            @endif

            <!-- Multi-Language Section -->
            <div class="mb-10 p-6 bg-slate-50 rounded-xl border-l-4 border-indigo-500 shadow-sm">
                <h4 class="text-lg font-bold text-gray-800 mb-6 flex items-center">
                    <svg class="h-5 w-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5a18.022 18.022 0 01-3.827-5.802M13.676 10H7M11 21s-2-3-2-8a14.444 14.444 0 008 4.5V21"/></svg>
                    {{ __('Bilingual Information') }}
                </h4>
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
                    <!-- Français -->
                    <div class="space-y-6">
                        <span class="inline-block px-3 py-1 bg-blue-100 text-blue-800 rounded font-bold text-xs">FRANÇAIS</span>
                        <div>
                            <label for="title_fr" class="block text-sm font-semibold text-gray-700 mb-2">{{ __('Title (FR)') }}</label>
                            <input type="text" name="title_fr" id="title_fr" value="{{ old('title_fr', $formation->title_fr ?? '') }}" 
                                class="w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 py-3" required>
                        </div>
                        <div>
                            <label for="short_description_fr" class="block text-sm font-semibold text-gray-700 mb-2">{{ __('Short Description (FR)') }}</label>
                            <textarea name="short_description_fr" id="short_description_fr" rows="3" 
                                class="w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 py-3" required>{{ old('short_description_fr', $formation->short_description_fr ?? '') }}</textarea>
                        </div>
                        <div>
                            <label for="description_fr" class="block text-sm font-semibold text-gray-700 mb-2">{{ __('Full Description (FR)') }}</label>
                            <textarea name="description_fr" id="description_fr" rows="6" 
                                class="w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 py-3" required>{{ old('description_fr', $formation->description_fr ?? '') }}</textarea>
                        </div>
                    </div>

                    <!-- English -->
                    <div class="space-y-6 border-l lg:pl-10">
                        <span class="inline-block px-3 py-1 bg-red-100 text-red-800 rounded font-bold text-xs">ENGLISH</span>
                        <div>
                            <label for="title_en" class="block text-sm font-semibold text-gray-700 mb-2">{{ __('Title (EN)') }}</label>
                            <input type="text" name="title_en" id="title_en" value="{{ old('title_en', $formation->title_en ?? '') }}" 
                                class="w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 py-3" required>
                        </div>
                        <div>
                            <label for="short_description_en" class="block text-sm font-semibold text-gray-700 mb-2">{{ __('Short Description (EN)') }}</label>
                            <textarea name="short_description_en" id="short_description_en" rows="3" 
                                class="w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 py-3" required>{{ old('short_description_en', $formation->short_description_en ?? '') }}</textarea>
                        </div>
                        <div>
                            <label for="description_en" class="block text-sm font-semibold text-gray-700 mb-2">{{ __('Full Description (EN)') }}</label>
                            <textarea name="description_en" id="description_en" rows="6" 
                                class="w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 py-3" required>{{ old('description_en', $formation->description_en ?? '') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- General Settings -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10">
                <div class="col-span-1">
                    <label for="category_id" class="block text-sm font-semibold text-gray-700 mb-2">{{ __('Category') }}</label>
                    <select name="category_id" id="category_id" class="w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 py-3" required>
                        <option value="">{{ __('Select Category') }}</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $formation->category_id ?? '') == $category->id ? 'selected' : '' }}>
                                {{ localized_field($category, 'name') }}
                            </option>
                        @endforeach
                    </select>
                </div>

                @if(auth()->user()->hasRole('Super Admin') || auth()->user()->hasRole('Admin'))
                    <div class="col-span-1">
                        <label for="user_id" class="block text-sm font-semibold text-gray-700 mb-2">{{ __('Trainer/Owner') }}</label>
                        <select name="user_id" id="user_id" class="w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 py-3">
                            <option value="">{{ __('Select a Trainer') }}</option>
                            @foreach($trainers as $trainer)
                                <option value="{{ $trainer->id }}" {{ old('user_id', $formation->user_id ?? '') == $trainer->id ? 'selected' : '' }}>
                                    {{ $trainer->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                @endif

                <div class="col-span-1">
                    <label for="price" class="block text-sm font-semibold text-gray-700 mb-2">{{ __('Price (MAD)') }}</label>
                    <input type="number" step="0.01" name="price" id="price" value="{{ old('price', $formation->price ?? '') }}" 
                        class="w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 py-3" required>
                </div>

                <div class="col-span-1">
                    <label for="level" class="block text-sm font-semibold text-gray-700 mb-2">{{ __('Expertise Level') }}</label>
                    <select name="level" id="level" class="w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 py-3" required>
                        <option value="Débutant" {{ old('level', $formation->level ?? '') == 'Débutant' ? 'selected' : '' }}>{{ __('Beginner') }}</option>
                        <option value="Intermédiaire" {{ old('level', $formation->level ?? '') == 'Intermédiaire' ? 'selected' : '' }}>{{ __('Intermediate') }}</option>
                        <option value="Expert" {{ old('level', $formation->level ?? '') == 'Expert' ? 'selected' : '' }}>{{ __('Expert') }}</option>
                    </select>
                </div>

                <div class="col-span-1">
                    <label for="duration" class="block text-sm font-semibold text-gray-700 mb-2">{{ __('Duration (Hours)') }}</label>
                    <input type="number" name="duration" id="duration" value="{{ old('duration', $formation->duration ?? '') }}" 
                        class="w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 py-3" required>
                </div>

                <div class="col-span-1">
                    <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">{{ __('Status') }}</label>
                    <select name="status" id="status" class="w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 py-3" required>
                        <option value="draft" {{ old('status', $formation->status->value ?? '') == 'draft' ? 'selected' : '' }}>{{ __('Brouillon') }}</option>
                        <option value="published" {{ old('status', $formation->status->value ?? '') == 'published' ? 'selected' : '' }}>{{ __('Publié') }}</option>
                        <option value="archived" {{ old('status', $formation->status->value ?? '') == 'archived' ? 'selected' : '' }}>{{ __('Archivé') }}</option>
                    </select>
                </div>

                <div class="col-span-1">
                    <label for="image" class="block text-sm font-semibold text-gray-700 mb-2">{{ __('Main Image') }}</label>
                    <input type="file" name="image" id="image" class="w-full py-2">
                    @if(isset($formation) && $formation->image)
                        <img src="{{ Storage::url($formation->image) }}" class="h-20 w-auto mt-2 rounded border shadow-sm">
                    @endif
                </div>
            </div>

            <!-- SEO Section -->
            <div x-data="{ expanded: false }" class="mb-10 bg-gray-50 rounded-xl overflow-hidden shadow-inner border border-gray-200">
                <button @click="expanded = !expanded" type="button" class="w-full flex items-center justify-between px-6 py-4 text-left focus:outline-none bg-gray-100 hover:bg-gray-200 transition">
                    <span class="text-sm font-bold text-gray-800 flex items-center">
                        <svg class="h-5 w-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        {{ __('SEO Optimization') }}
                    </span>
                    <svg class="h-5 w-5 text-gray-500 transition" :class="expanded ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>

                <div x-show="expanded" class="p-8 grid grid-cols-1 md:grid-cols-2 gap-8 border-t">
                    <!-- SEO FR -->
                    <div class="space-y-6">
                        <span class="text-xs font-bold text-gray-400">SEO FR</span>
                        <div>
                            <label for="seo_title_fr" class="block text-xs font-semibold text-gray-600 mb-2">{{ __('Meta Title (FR)') }}</label>
                            <input type="text" name="seo_title_fr" id="seo_title_fr" value="{{ old('seo_title_fr', $formation->seo_title_fr ?? '') }}" 
                                class="w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 py-2">
                        </div>
                        <div>
                            <label for="meta_description_fr" class="block text-xs font-semibold text-gray-600 mb-2">{{ __('Meta Description (FR)') }}</label>
                            <textarea name="meta_description_fr" id="meta_description_fr" rows="2" 
                                class="w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 py-2">{{ old('meta_description_fr', $formation->meta_description_fr ?? '') }}</textarea>
                        </div>
                    </div>
                    <!-- SEO EN -->
                    <div class="space-y-6">
                        <span class="text-xs font-bold text-gray-400">SEO EN</span>
                        <div>
                            <label for="seo_title_en" class="block text-xs font-semibold text-gray-600 mb-2">{{ __('Meta Title (EN)') }}</label>
                            <input type="text" name="seo_title_en" id="seo_title_en" value="{{ old('seo_title_en', $formation->seo_title_en ?? '') }}" 
                                class="w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 py-2">
                        </div>
                        <div>
                            <label for="meta_description_en" class="block text-xs font-semibold text-gray-600 mb-2">{{ __('Meta Description (EN)') }}</label>
                            <textarea name="meta_description_en" id="meta_description_en" rows="2" 
                                class="w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 py-2">{{ old('meta_description_en', $formation->meta_description_en ?? '') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit buttons -->
            <div class="mt-10 flex justify-end space-x-4 border-t pt-6">
                <a href="{{ route('admin.formations.index') }}" class="px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-md hover:bg-gray-200 transition duration-300">
                    {{ __('Cancel') }}
                </a>
                <button type="submit" class="px-8 py-3 bg-indigo-600 text-white font-bold rounded-md hover:bg-indigo-700 shadow-lg transform hover:-translate-y-1 transition duration-300">
                    {{ isset($formation) ? __('Update Formation') : __('Create Formation') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
