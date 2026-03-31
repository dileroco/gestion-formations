@extends('layouts.public')

@section('title', localized_field($formation, 'title'))

@section('content')
<section class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-16">
            <!-- Left: Content -->
            <div class="lg:col-span-2 space-y-10">
                <nav class="flex text-[11px] font-bold uppercase tracking-widest text-indigo-600">
                    <a href="{{ route(active_locale().'.formations.index') }}" class="hover:text-indigo-800 transition underline underline-offset-4">{{ __('Trainings') }}</a>
                    <span class="mx-3 text-gray-300">/</span>
                    <span class="text-gray-400">{{ localized_field($formation->category, 'name') }}</span>
                </nav>

                <div class="space-y-6">
                    <h1 class="text-5xl font-bold text-gray-900 tracking-tight leading-tight">
                        {{ localized_field($formation, 'title') }}
                    </h1>
                    <p class="text-xl text-gray-600 leading-relaxed border-l-4 border-indigo-100 pl-6">
                        {{ localized_field($formation, 'short_description') }}
                    </p>
                </div>

                @if($formation->image)
                <div class="rounded-xl overflow-hidden border border-gray-100 shadow-sm">
                    <img src="{{ Storage::url($formation->image) }}" class="w-full h-auto" alt="">
                </div>
                @endif

                <div class="prose prose-indigo prose-lg max-w-none text-gray-600 border-t border-gray-50 pt-10">
                    {!! nl2br(e(localized_field($formation, 'description'))) !!}
                </div>

                <!-- Sessions section -->
                <div class="mt-16 pt-16 border-t border-gray-50">
                    <h3 class="text-2xl font-bold text-gray-900 mb-8">
                        {{ __('Upcoming Sessions') }}
                    </h3>

                    <div class="space-y-4">
                        @forelse($formation->trainingSessions as $session)
                        <div class="bg-gray-50 rounded-xl p-6 border border-gray-100 flex flex-col md:flex-row md:items-center justify-between">
                            <div class="space-y-2 mb-6 md:mb-0">
                                <div class="flex items-center space-x-3">
                                    <span class="px-2 py-0.5 bg-indigo-600 text-white text-[10px] font-bold uppercase tracking-widest rounded">{{ $session->mode->value }}</span>
                                    @if($session->city)
                                        <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">&bull; {{ $session->city }}</span>
                                    @endif
                                </div>
                                <div class="text-xl font-bold text-gray-900">
                                    {{ $session->start_date?->translatedFormat('d F Y') }} <span class="text-gray-300 mx-2">&mdash;</span> {{ $session->end_date?->translatedFormat('d F Y') }}
                                </div>
                                <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">
                                    {{ $session->capacity }} {{ __('seats available') }} &bull; {{ $session->trainer?->name }}
                                </div>
                            </div>
                            
                            @auth
                                <form action="{{ route('admin.inscriptions.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="training_session_id" value="{{ $session->id }}">
                                    <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                                    <button type="submit" class="w-full md:w-auto px-8 py-3 bg-indigo-600 text-white rounded-lg font-bold hover:bg-indigo-700 transition text-sm">
                                        {{ __('Register Now') }}
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('register') }}" class="w-full md:w-auto px-8 py-3 border border-indigo-600 text-indigo-600 rounded-lg font-bold hover:bg-indigo-600 hover:text-white transition text-sm text-center">
                                    {{ __('Sign in to Register') }}
                                </a>
                            @endauth
                        </div>
                        @empty
                        <div class="py-8 text-center text-gray-400 font-medium bg-gray-50 rounded-xl border border-dashed border-gray-200">
                            {{ __('No upcoming sessions for this training.') }}
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Right: Sidebar -->
            <div class="lg:col-span-1">
                <div class="sticky top-32 space-y-6">
                    <div class="bg-gray-900 rounded-xl p-8 text-white shadow-sm">
                        <div class="flex flex-col">
                            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">{{ __('Program Investment') }}</span>
                            <div class="text-3xl font-bold mb-8 pb-8 border-b border-white/10">
                                {{ format_price($formation->price) }}
                            </div>

                            <ul class="space-y-4 mb-8">
                                <li class="flex items-center text-sm">
                                    <span class="text-gray-400 mr-2 uppercase tracking-wide text-[10px] font-bold w-20">{{ __('Duration') }}:</span> 
                                    <span class="font-bold">{{ $formation->duration }} {{ __('Hours') }}</span>
                                </li>
                                <li class="flex items-center text-sm">
                                    <span class="text-gray-400 mr-2 uppercase tracking-wide text-[10px] font-bold w-20">{{ __('Level') }}:</span> 
                                    <span class="font-bold">{{ $formation->level }}</span>
                                </li>
                                <li class="flex items-center text-sm">
                                    <span class="text-gray-400 mr-2 uppercase tracking-wide text-[10px] font-bold w-20">{{ __('Status') }}:</span> 
                                    <span class="font-bold text-green-400">{{ __('Open') }}</span>
                                </li>
                            </ul>

                            <button @click="document.querySelector('.mt-16').scrollIntoView({behavior: 'smooth'})" class="w-full py-4 bg-indigo-600 text-white rounded-lg font-bold hover:bg-indigo-700 transition text-sm text-center">
                                {{ __('Jump to Sessions') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
