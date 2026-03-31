@extends('layouts.admin')

@section('title', isset($session) ? __('Edit Session') : __('Add Session'))

@section('content')
<div class="max-w-4xl mx-auto py-6">
    <div class="bg-white shadow rounded-lg overflow-hidden border border-gray-100">
        <form action="{{ isset($session) ? route('admin.sessions.update', $session) : route('admin.sessions.store') }}" 
              method="POST" 
              class="p-8">
            @csrf
            @if(isset($session))
                @method('PATCH')
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-6">
                <!-- Training Linked -->
                <div class="col-span-1">
                    <label for="formation_id" class="block text-sm font-semibold text-gray-700 mb-2">{{ __('Linked Training') }}</label>
                    <select name="formation_id" id="formation_id" class="w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 py-3" required>
                        <option value="">{{ __('Select Training') }}</option>
                        @foreach($formations as $formation)
                            <option value="{{ $formation->id }}" {{ old('formation_id', $session->formation_id ?? '') == $formation->id ? 'selected' : '' }}>
                                {{ localized_field($formation, 'title') }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Trainer Linked -->
                @if(auth()->user()->hasRole('Super Admin') || auth()->user()->hasRole('Admin'))
                <div class="col-span-1">
                    <label for="trainer_id" class="block text-sm font-semibold text-gray-700 mb-2">{{ __('Trainer') }}</label>
                    <select name="trainer_id" id="trainer_id" class="w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 py-3">
                        <option value="">{{ __('Select a Trainer') }}</option>
                        @foreach($trainers as $trainer)
                            <option value="{{ $trainer->id }}" {{ old('trainer_id', $session->trainer_id ?? '') == $trainer->id ? 'selected' : '' }}>
                                {{ $trainer->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @endif

                <!-- Start Date -->
                <div class="col-span-1">
                    <label for="start_date" class="block text-sm font-semibold text-gray-700 mb-2">{{ __('Start Date') }}</label>
                    <input type="datetime-local" name="start_date" id="start_date" value="{{ old('start_date', isset($session) ? $session->start_date?->format('Y-m-d\TH:i') : '') }}" 
                        class="w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 py-3" required>
                </div>

                <!-- End Date -->
                <div class="col-span-1">
                    <label for="end_date" class="block text-sm font-semibold text-gray-700 mb-2">{{ __('End Date') }}</label>
                    <input type="datetime-local" name="end_date" id="end_date" value="{{ old('end_date', isset($session) ? $session->end_date?->format('Y-m-d\TH:i') : '') }}" 
                        class="w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 py-3" required>
                </div>

                <!-- Capacity -->
                <div class="col-span-1">
                    <label for="capacity" class="block text-sm font-semibold text-gray-700 mb-2">{{ __('Capacity (Participants)') }}</label>
                    <input type="number" name="capacity" id="capacity" min="1" value="{{ old('capacity', $session->capacity ?? 20) }}" 
                        class="w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 py-3" required>
                </div>

                <!-- Mode -->
                <div class="col-span-1">
                    <label for="mode" class="block text-sm font-semibold text-gray-700 mb-2">{{ __('Session Mode') }}</label>
                    <select name="mode" id="mode" class="w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 py-3" required>
                        <option value="presentiel" {{ old('mode', $session->mode->value ?? '') == 'presentiel' ? 'selected' : '' }}>{{ __('En présentiel') }}</option>
                        <option value="online" {{ old('mode', $session->mode->value ?? '') == 'online' ? 'selected' : '' }}>{{ __('Online') }}</option>
                        <option value="hybride" {{ old('mode', $session->mode->value ?? '') == 'hybride' ? 'selected' : '' }}>{{ __('Hybride') }}</option>
                    </select>
                </div>

                <!-- City (only for in-person/hybrid) -->
                <div class="col-span-1">
                    <label for="city" class="block text-sm font-semibold text-gray-700 mb-2">{{ __('City (If Applicable)') }}</label>
                    <input type="text" name="city" id="city" value="{{ old('city', $session->city ?? '') }}" 
                        class="w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 py-3">
                </div>

                <!-- Online Link (only for online/hybrid) -->
                <div class="col-span-1">
                    <label for="meeting_link" class="block text-sm font-semibold text-gray-700 mb-2">{{ __('Meeting Link (If Online)') }}</label>
                    <input type="url" name="meeting_link" id="meeting_link" value="{{ old('meeting_link', $session->meeting_link ?? '') }}" 
                        class="w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 py-3">
                </div>

                <!-- Status -->
                <div class="col-span-1">
                    <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">{{ __('Session Status') }}</label>
                    <select name="status" id="status" class="w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 py-3" required>
                        <option value="upcoming" {{ old('status', $session->status->value ?? '') == 'upcoming' ? 'selected' : '' }}>{{ __('Upcoming') }}</option>
                        <option value="ongoing" {{ old('status', $session->status->value ?? '') == 'ongoing' ? 'selected' : '' }}>{{ __('Ongoing') }}</option>
                        <option value="finished" {{ old('status', $session->status->value ?? '') == 'finished' ? 'selected' : '' }}>{{ __('Finished') }}</option>
                    </select>
                </div>
            </div>

            <div class="mt-10 flex justify-end space-x-4 border-t pt-6">
                <a href="{{ route('admin.sessions.index') }}" class="px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-md hover:bg-gray-200 transition">
                    {{ __('Cancel') }}
                </a>
                <button type="submit" class="px-6 py-3 bg-indigo-600 text-white font-semibold rounded-md hover:bg-indigo-700 shadow-md transition">
                    {{ isset($session) ? __('Update Session') : __('Save Session') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
