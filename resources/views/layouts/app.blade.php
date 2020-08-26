<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<body class="bg-white h-screen antialiased leading-none">
    <div id="app">
        @guest
            <nav class="bg-blue-900 shadow mb-8 py-6">
                <div class="container mx-auto px-6 md:px-0">
                    <div class="flex items-center justify-center">
                        <div class="mr-6">
                            <a href="{{ url('/') }}" class="text-lg font-semibold text-gray-100 no-underline">
                                {{ config('app.name', 'Laravel') }}
                            </a>
                        </div>
                        <div class="flex-1 text-right">
                            <a class="no-underline hover:underline text-gray-300 text-sm p-3" href="{{ route('login') }}">{{ __('Login') }}</a>
                            @if (Route::has('register'))
                                <a class="no-underline hover:underline text-gray-300 text-sm p-3" href="{{ route('register') }}">{{ __('Register') }}</a>
                             @endif
                        </div>
                    </div>
                </div>
            </nav>
            @yield('content')
        @else
            <div class="flex">
                <aside id="sidebar" class="bg-gray-700 overflow-auto min-h-screen">
                    <div class="items-center text-center">
      
                            <a href="{{ url('/') }}" class="text-lg font-semibold text-gray-100 no-underline p-2 my-3 block">
                                {{ config('app.name', 'Elixirr') }}
                            </a>
                            <span class="text-gray-300 text-sm block">{{ Auth::user()->name }}</span>
                   
                    </div>
                    <ul class="list-none">
                        <li>
                            <router-link :to="{ name: 'compose' }">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="stroke-current inline-block"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg> 
                                Compose
                            </router-link>
                        </li>
                        <li>
                            <router-link :to="{ name: 'messages' }">
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="stroke-current inline-block"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path></svg>
                                Inbox
                            </router-link>
                        </li>
                        <li>
                            <router-link :to="{ name: 'messages/sent' }">
                                <svg xmlns="http://www.w3.org/2000/svg" height="15" viewBox="0 0 24 24" fill="none" width="15" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="stroke-current inline-block"><path fill="none" d="M38 2v8h-26.34l7.17-7.17-2.83-2.83-12 12 12 12 2.83-2.83-7.17-7.17h30.34v-12z"/></svg>
                                Sent
                            </router-link>
                        </li>
                        <li>
                            <router-link :to="{ name: 'messages/archived' }">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="stroke-current inline-block"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                Archived
                            </router-link>
                        </li>
                        <li>
                            <a href="{{ route('logout') }}" class="no-underline hover:underline text-gray-300 text-sm p-3" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="stroke-current inline-block"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                {{ __('Logout') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    </ul>
                </aside>
                <div class="items-center w-full">
                    @yield('content')
                </div>
            </div>
        @endguest
    </div>
</body>
</html>