@extends('layouts.admin')

@section('title', isset($user) ? __('Edit User') : __('Add User'))

@section('content')
<div class="max-w-4xl mx-auto py-6">
    <div class="bg-white shadow rounded-lg overflow-hidden border border-gray-100">
        <form action="{{ isset($user) ? route('admin.users.update', $user) : route('admin.users.store') }}" method="POST" class="p-8">
            @csrf
            @if(isset($user))
                @method('PATCH')
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Name -->
                <div class="col-span-1">
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">{{ __('Name') }}</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name ?? '') }}" 
                        class="w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 py-3" required>
                </div>

                <!-- Email -->
                <div class="col-span-1">
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">{{ __('Email Address') }}</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email ?? '') }}" 
                        class="w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 py-3" required>
                </div>

                <!-- Phone -->
                <div class="col-span-1">
                    <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">{{ __('Phone Number') }}</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone', $user->phone ?? '') }}" 
                        class="w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 py-3">
                </div>

                <!-- Role -->
                <div class="col-span-1">
                    <label for="role" class="block text-sm font-semibold text-gray-700 mb-2">{{ __('Role') }}</label>
                    <select name="role" id="role" class="w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 py-3" required>
                        <option value="">{{ __('Select a Role') }}</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->name }}" {{ old('role', isset($user) && $user->hasRole($role->name) ? $role->name : '') == $role->name ? 'selected' : '' }}>
                                {{ $role->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Language -->
                <div class="col-span-1">
                    <label for="language" class="block text-sm font-semibold text-gray-700 mb-2">{{ __('Preferred Language') }}</label>
                    <select name="language" id="language" class="w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 py-3" required>
                        <option value="fr" {{ old('language', $user->language ?? 'fr') == 'fr' ? 'selected' : '' }}>Français</option>
                        <option value="en" {{ old('language', $user->language ?? 'fr') == 'en' ? 'selected' : '' }}>English</option>
                    </select>
                </div>

                <!-- Is Active Toggle -->
                <div class="col-span-1 flex items-center pt-8">
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" class="sr-only peer" {{ old('is_active', $user->is_active ?? 1) ? 'checked' : '' }}>
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                        <span class="ml-3 text-sm font-semibold text-gray-700">{{ __('Account Active') }}</span>
                    </label>
                </div>

                <!-- Password -->
                <div class="col-span-1">
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                        {{ __('Password') }} {{ isset($user) ? '(' . __('Leave empty to keep current') . ')' : '' }}
                    </label>
                    <input type="password" name="password" id="password" 
                        class="w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 py-3" 
                        {{ isset($user) ? '' : 'required' }}>
                </div>

                <!-- Password Confirmation -->
                <div class="col-span-1">
                    <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">{{ __('Confirm Password') }}</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" 
                        class="w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 py-3" 
                        {{ isset($user) ? '' : 'required' }}>
                </div>
            </div>

            <div class="mt-10 flex justify-end space-x-4 border-t pt-6">
                <a href="{{ route('admin.users.index') }}" class="px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-md hover:bg-gray-200 transition">
                    {{ __('Cancel') }}
                </a>
                <button type="submit" class="px-6 py-3 bg-indigo-600 text-white font-semibold rounded-md hover:bg-indigo-700 shadow-md transition">
                    {{ isset($user) ? __('Update User') : __('Save User') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
