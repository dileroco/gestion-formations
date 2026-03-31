@extends('layouts.public')

@section('title', __('Our Trainings'))

@section('content')
<section class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mb-16">
            <h1 class="text-4xl font-bold text-gray-900 tracking-tight mb-4">
                {{ __('Professional Trainings') }}
            </h1>
            <p class="text-lg text-gray-600 leading-relaxed">
                {{ __('Explore our selection of professional training programs designed to help you excel in the modern marketplace.') }}
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($formations as $formation)
            <div class="bg-white rounded-xl overflow-hidden border border-gray-100 shadow-sm flex flex-col">
                <div class="h-56 bg-gray-50 overflow-hidden relative border-b border-gray-50">
                    @if($formation->image)
                        <img src="{{ Storage::url($formation->image) }}" class="w-full h-full object-cover" alt="">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-300">
                            <svg class="h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                    @endif
                    <div class="absolute top-4 left-4">
                        <span class="px-2.5 py-1 bg-white text-gray-900 text-[10px] font-bold uppercase tracking-widest rounded-lg shadow-sm border border-gray-100">
                            {{ localized_field($formation->category, 'name') }}
                        </span>
                    </div>
                </div>
                
                <div class="p-6 flex-1 flex flex-col">
                    <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-3">
                        {{ $formation->duration }} {{ __('Hours') }} &bull; {{ $formation->level }}
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">
                        {{ localized_field($formation, 'title') }}
                    </h3>
                    <p class="text-sm text-gray-500 mb-6 line-clamp-3 leading-relaxed">
                        {{ localized_field($formation, 'short_description') }}
                    </p>
                    
                    <div class="mt-auto pt-6 border-t border-gray-50 flex items-center justify-between">
                        <span class="text-lg font-bold text-gray-900">{{ format_price($formation->price) }}</span>
                        <a href="{{ route(active_locale().'.formations.show', $formation->{active_locale() == 'fr' ? 'slug_fr' : 'slug_en'}) }}" class="text-indigo-600 text-sm font-bold hover:underline">
                            {{ __('View Details') }} &rarr;
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-3 py-20 text-center">
                <p class="text-xl font-medium text-gray-400">{{ __('No trainings available at the moment.') }}</p>
            </div>
            @endforelse
        </div>

        <div class="mt-12">
            {{ $formations->links() }}
        </div>
    </div>
</section>
@endsection
