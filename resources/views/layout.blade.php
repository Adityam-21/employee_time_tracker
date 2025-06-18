<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Time Tracker')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background-color: #0f172a;
            /* dark-slate-900 */
        }

        ::selection {
            background-color: #10b981;
            color: white;
        }
    </style>
</head>

<body class="font-sans text-white min-h-screen flex flex-col">

    <!-- Navbar -->
    <nav class="bg-gradient-to-r from-emerald-600 to-teal-700 shadow-md px-6 py-4 flex justify-between items-center">
        <h1 class="text-2xl font-bold text-white tracking-wide">🕒 Time Tracker</h1>
        @auth
            <div class="flex items-center space-x-4">
                <span class="font-medium text-white">Hi, {{ auth()->user()->name }}</span>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button
                        class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg shadow transition-all duration-200">
                        Logout
                    </button>
                </form>
            </div>
        @endauth
    </nav>

    <!-- Main Content -->
    <main class="flex-grow container mx-auto px-4 py-8">
        @yield('content')
    </main>

    <!-- Footer (optional for consistency) -->
    <footer class="text-center text-sm text-emerald-100 py-4 opacity-60">
        &copy; {{ date('Y') }} Time Tracker. All rights reserved.
    </footer>

</body>

</html>
