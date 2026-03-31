@extends('layouts.admin')

@section('title', isset($category) ? __('Edit Category') : __('New Category'))

@section('content')
<div class="max-w-3xl mx-auto py-10">
    <div class="bg-white shadow-2xl rounded-2xl overflow-hidden border border-gray-100">
        <form action="{{ isset($category) ? route('admin.categories.update', $category) : route('admin.categories.store') }}" 
              method="POST" 
              class="p-10">
            @csrf
            @if(isset($category))
                @method('PATCH')
            @endif

            <div class="space-y-10">
                <h4 class="text-lg font-black text-gray-800 uppercase tracking-widest flex items-center border-b pb-4">
                    <svg class="h-6 w-6 mr-3 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                    {{ __('Category Details') }}
                </h4>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                    <!-- Français -->
                    <div>
                        <label for="name_fr" class="block text-xs font-black text-blue-600 uppercase tracking-widest mb-3">{{ __('Name (FR)') }}</label>
                        <input type="text" name="name_fr" id="name_fr" value="{{ old('name_fr', $category->name_fr ?? '') }}" 
                            class="w-full rounded-xl border-gray-200 shadow-sm focus:ring-4 focus:ring-blue-100 focus:border-blue-400 py-4 font-bold text-gray-800 transition" required>
                        @error('name_fr') <p class="mt-2 text-xs text-red-500 font-bold italic">{{ $message }}</p> @enderror
                    </div>

                    <!-- English -->
                    <div>
                        <label for="name_en" class="block text-xs font-black text-red-600 uppercase tracking-widest mb-3">{{ __('Name (EN)') }}</label>
                        <input type="text" name="name_en" id="name_en" value="{{ old('name_en', $category->name_en ?? '') }}" 
                            class="w-full rounded-xl border-gray-200 shadow-sm focus:ring-4 focus:ring-red-100 focus:border-red-400 py-4 font-bold text-gray-800 transition" required>
                        @error('name_en') <p class="mt-2 text-xs text-red-500 font-bold italic">{{ $message }}</p> @enderror
                    </div>
                </div>

                @if(isset($category))
                <div class="bg-gray-50 p-6 rounded-xl border border-gray-100">
                    <div class="text-[10px] font-black text-gray-400 uppercase mb-4 tracking-tighter">{{ __('Generated Slugs') }}</div>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="text-[11px] font-mono"><span class="font-bold text-blue-600">FR:</span> /{{ $category->slug_fr }}</div>
                        <div class="text-[11px] font-mono"><span class="font-bold text-red-600">EN:</span> /{{ $category->slug_en }}</div>
                    </div>
                </div>
                @endif
            </div>

            <div class="mt-12 flex justify-end space-x-5 pt-8 border-t">
                <a href="{{ route('admin.categories.index') }}" class="px-8 py-4 bg-gray-50 text-gray-500 font-black rounded-xl hover:bg-gray-100 transition uppercase text-[10px] tracking-widest">
                    {{ __('Cancel') }}
                </a>
                <button type="submit" class="px-12 py-4 bg-indigo-600 text-white font-black rounded-xl hover:bg-indigo-700 shadow-2xl shadow-indigo-200 transform hover:-translate-y-1 transition uppercase text-[10px] tracking-widest">
                    {{ isset($category) ? __('Update Category') : __('Save Category') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
