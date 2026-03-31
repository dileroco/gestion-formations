@extends('layouts.admin')

@section('title', isset($inscription) ? __('Modify Inscription') : __('New Inscription'))

@section('content')
<div class="max-w-4xl mx-auto py-6">
    <div class="bg-white shadow rounded-lg overflow-hidden border border-gray-100">
        <form action="{{ isset($inscription) ? route('admin.inscriptions.update', $inscription) : route('admin.inscriptions.store') }}" 
              method="POST" 
              class="p-8">
            @csrf
            @if(isset($inscription))
                @method('PATCH')
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-6">
                <!-- User (Participant) -->
                <div class="col-span-1">
                    <label for="user_id" class="block text-sm font-semibold text-gray-700 mb-2">{{ __('Participant') }}</label>
                    <select name="user_id" id="user_id" class="w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 py-3" 
                        {{ isset($inscription) ? 'disabled' : 'required' }}>
                        <option value="">{{ __('Select Participant') }}</option>
                        @foreach($users ?? [] as $user)
                            <option value="{{ $user->id }}" {{ old('user_id', $inscription->user_id ?? '') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }} ({{ $user->email }})
                            </option>
                        @endforeach
                    </select>
                    @if(isset($inscription))
                        <input type="hidden" name="user_id" value="{{ $inscription->user_id }}">
                    @endif
                </div>

                <!-- Session -->
                <div class="col-span-1">
                    <label for="training_session_id" class="block text-sm font-semibold text-gray-700 mb-2">{{ __('Training Session') }}</label>
                    <select name="training_session_id" id="training_session_id" class="w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 py-3" 
                        {{ isset($inscription) ? 'disabled' : 'required' }}>
                        <option value="">{{ __('Select Session') }}</option>
                        @foreach($sessions ?? [] as $session)
                            <option value="{{ $session->id }}" {{ old('training_session_id', $inscription->session_id ?? '') == $session->id ? 'selected' : '' }}>
                                #{{ $session->id }} - {{ localized_field($session->formation, 'title') }} ({{ $session->start_date?->format('d/m/Y') }})
                            </option>
                        @endforeach
                    </select>
                    @if(isset($inscription))
                        <input type="hidden" name="training_session_id" value="{{ $inscription->session_id }}">
                    @endif
                </div>

                <!-- Reference (Read Only if Edit) -->
                @if(isset($inscription))
                <div class="col-span-1">
                    <label for="reference" class="block text-sm font-semibold text-gray-700 mb-2">{{ __('Reference') }}</label>
                    <input type="text" value="{{ $inscription->reference }}" class="w-full rounded-md border-gray-200 bg-gray-50 py-3 font-mono font-bold text-indigo-600" readonly>
                </div>
                @endif

                <!-- Status -->
                <div class="col-span-1">
                    <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">{{ __('Status') }}</label>
                    <select name="status" id="status" class="w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 py-3" required>
                        <option value="pending" {{ old('status', $inscription->status->value ?? '') == 'pending' ? 'selected' : '' }}>{{ __('Pending') }}</option>
                        <option value="confirmed" {{ old('status', $inscription->status->value ?? '') == 'confirmed' ? 'selected' : '' }}>{{ __('Confirmed') }}</option>
                        <option value="cancelled" {{ old('status', $inscription->status->value ?? '') == 'cancelled' ? 'selected' : '' }}>{{ __('Cancelled') }}</option>
                    </select>
                </div>

                <!-- Grade / Note -->
                <div class="col-span-1">
                    <label for="grade" class="block text-sm font-semibold text-gray-700 mb-2">{{ __('Grade (Optional)') }}</label>
                    <input type="text" name="grade" id="grade" value="{{ old('grade', $inscription->grade ?? '') }}" 
                        class="w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 py-3">
                </div>

                <div class="col-span-2">
                    <label for="note" class="block text-sm font-semibold text-gray-700 mb-2">{{ __('Internal Notes') }}</label>
                    <textarea name="note" id="note" rows="3" 
                        class="w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 py-3">{{ old('note', $inscription->note ?? '') }}</textarea>
                </div>
            </div>

            <div class="mt-10 flex justify-end space-x-4 border-t pt-6">
                <a href="{{ route('admin.inscriptions.index') }}" class="px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-md hover:bg-gray-200 transition">
                    {{ __('Cancel') }}
                </a>
                <button type="submit" class="px-6 py-3 bg-indigo-600 text-white font-semibold rounded-md hover:bg-indigo-700 shadow-md transition font-bold uppercase tracking-wider">
                    {{ isset($inscription) ? __('Update Inscription') : __('Register Participant') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
