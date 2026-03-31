<!DOCTYPE html>
<html lang="{{ active_locale() }}" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - {{ config('app.name') }}</title>
    <meta name="description" content="@yield('meta_description', 'Plateforme de gestion de formations.')">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind & Alpine -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-white text-gray-900 antialiased">

    <!-- Navigation -->
    <nav x-data="{ mobileMenu: false }" class="border-b border-gray-100 py-4 sticky top-0 bg-white/95 backdrop-blur-sm z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center">
                <!-- Simple Logo -->
                <a href="{{ route(active_locale().'.home') }}" class="text-xl font-bold tracking-tight text-gray-900">
                    GESTION<span class="text-indigo-600">FORM</span>
                </a>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-8 text-sm font-medium">
                    <a href="{{ route(active_locale().'.home') }}" class="hover:text-indigo-600 transition">{{ __('Home') }}</a>
                    <a href="{{ route(active_locale().'.formations.index') }}" class="hover:text-indigo-600 transition">{{ __('Trainings') }}</a>
                    <a href="{{ route(active_locale().'.blog.index') }}" class="hover:text-indigo-600 transition">{{ __('Blog') }}</a>
                    <a href="{{ route(active_locale().'.contact.show') }}" class="hover:text-indigo-600 transition">{{ __('Contact') }}</a>
                    
                    <div class="h-4 w-px bg-gray-200"></div>

                    <!-- Language Switcher -->
                    @if(active_locale() == 'fr')
                        <a href="{{ url('/en') }}" class="text-xs uppercase hover:text-indigo-600">EN</a>
                    @else
                        <a href="{{ url('/fr') }}" class="text-xs uppercase hover:text-indigo-600">FR</a>
                    @endif

                    @auth
                        <a href="{{ route('admin.dashboard') }}" class="text-indigo-600 font-bold hover:underline">
                            {{ __('Dashboard') }}
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-900 transition">{{ __('Login') }}</a>
                        <a href="{{ route('register') }}" class="px-5 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                            {{ __('Sign Up') }}
                        </a>
                    @endauth
                </div>

                <!-- Mobile Toggle -->
                <div class="md:hidden flex items-center">
                    <button @click="mobileMenu = !mobileMenu" class="p-2 text-gray-600">
                        <svg x-show="!mobileMenu" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                        <svg x-show="mobileMenu" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div x-show="mobileMenu" class="md:hidden border-t border-gray-100 p-6 bg-white shadow-lg">
            <div class="flex flex-col space-y-4 font-semibold">
                <a @click="mobileMenu = false" href="{{ route(active_locale().'.home') }}">{{ __('Home') }}</a>
                <a @click="mobileMenu = false" href="{{ route(active_locale().'.formations.index') }}">{{ __('Trainings') }}</a>
                <a @click="mobileMenu = false" href="{{ route(active_locale().'.blog.index') }}">{{ __('Blog') }}</a>
                <a @click="mobileMenu = false" href="{{ route(active_locale().'.contact.show') }}">{{ __('Contact') }}</a>
                @auth
                    <a href="{{ route('admin.dashboard') }}" class="text-indigo-600">{{ __('Dashboard') }}</a>
                @else
                    <a href="{{ route('login') }}">{{ __('Login') }}</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Simple Footer -->
    <footer class="bg-gray-50 border-t border-gray-100 py-12 mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0 text-sm text-gray-500">
                <div class="flex items-center space-x-6">
                    <span class="font-bold text-gray-900 tracking-tight underline">{{ config('app.name') }}</span>
                    <a href="{{ route(active_locale().'.formations.index') }}" class="hover:text-indigo-600">{{ __('Trainings') }}</a>
                    <a href="{{ route(active_locale().'.blog.index') }}" class="hover:text-indigo-600">{{ __('Blog') }}</a>
                    <a href="{{ route(active_locale().'.contact.show') }}" class="hover:text-indigo-600">{{ __('Contact') }}</a>
                </div>
                <p>&copy; {{ date('Y') }} {{ config('app.name') }}. {{ __('All rights reserved.') }}</p>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
