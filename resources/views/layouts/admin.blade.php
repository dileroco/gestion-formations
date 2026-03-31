<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - Admin {{ config('app.name') }}</title>

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
<body class="bg-gray-50 text-gray-900 antialiased overflow-hidden">
    <div class="flex h-screen overflow-hidden" x-data="{ sidebarOpen: true }">
        <!-- Sidebar -->
        <div :class="sidebarOpen ? 'w-64' : 'w-0'" class="bg-white border-r border-gray-200 transition-all duration-300 overflow-y-auto">
            <div class="p-6">
                <a href="{{ route('admin.dashboard') }}" class="text-xl font-bold tracking-tight text-gray-900">
                    GESTION<span class="text-indigo-600">FORM</span>
                </a>
            </div>

            <nav class="mt-6 px-4 space-y-1">
                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2.5 text-sm font-medium rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    {{ __('Dashboard') }}
                </a>
                
                @can('manage users')
                <a href="{{ route('admin.users.index') }}" class="block px-4 py-2.5 text-sm font-medium rounded-lg {{ request()->routeIs('admin.users.*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    {{ __('Users') }}
                </a>
                @endcan

                @can('manage categories')
                <a href="{{ route('admin.categories.index') }}" class="block px-4 py-2.5 text-sm font-medium rounded-lg {{ request()->routeIs('admin.categories.*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    {{ __('Categories') }}
                </a>
                @endcan

                <a href="{{ route('admin.formations.index') }}" class="block px-4 py-2.5 text-sm font-medium rounded-lg {{ request()->routeIs('admin.formations.*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    {{ __('Trainings') }}
                </a>

                <a href="{{ route('admin.sessions.index') }}" class="block px-4 py-2.5 text-sm font-medium rounded-lg {{ request()->routeIs('admin.sessions.*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    {{ __('Sessions') }}
                </a>

                <a href="{{ route('admin.inscriptions.index') }}" class="block px-4 py-2.5 text-sm font-medium rounded-lg {{ request()->routeIs('admin.inscriptions.*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    {{ __('Registrations') }}
                </a>

                @can('manage blog')
                <a href="{{ route('admin.posts.index') }}" class="block px-4 py-2.5 text-sm font-medium rounded-lg {{ request()->routeIs('admin.posts.*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    {{ __('Blog Posts') }}
                </a>
                @endcan

                <div class="pt-10">
                    <a href="{{ route(active_locale().'.home') }}" class="block px-4 py-2.5 text-sm font-medium text-gray-400 hover:text-gray-900 transition">
                        &larr; {{ __('Back to Public Site') }}
                    </a>
                </div>
            </nav>
        </div>

        <!-- Content Area -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
            <!-- Topbar -->
            <header class="bg-white border-b border-gray-200">
                <div class="h-16 flex items-center justify-between px-8">
                    <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 hover:text-gray-900 transition">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>

                    <div class="flex items-center space-x-6">
                        <div class="text-sm font-medium text-gray-600">
                            {{ auth()->user()->name }}
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-sm font-bold text-red-600 hover:underline">
                                {{ __('Logout') }}
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            <!-- Main Content -->
            <main class="flex-1 overflow-y-auto p-8 bg-gray-50/50">
                <div class="max-w-7xl mx-auto">
                    <div class="mb-8 flex justify-between items-center">
                        <h1 class="text-2xl font-bold text-gray-900">@yield('title')</h1>
                        <div>@yield('actions')</div>
                    </div>

                    @if(session('status'))
                        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-100 text-emerald-800 rounded-lg text-sm font-medium">
                            {{ session('status') }}
                        </div>
                    @endif

                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
