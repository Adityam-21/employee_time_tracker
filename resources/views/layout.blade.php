<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Time Tracker')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 font-sans text-gray-900">

    <nav class="bg-white shadow p-4 flex justify-between items-center">
        <h1 class="text-xl font-bold text-blue-700">🕒 Time Tracker</h1>
        @auth
            <div>
                <span class="mr-4 font-medium">Hi, {{ auth()->user()->name }}</span>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button class="bg-red-500 text-white px-3 py-1 rounded">Logout</button>
                </form>
            </div>
        @endauth
    </nav>

    <main class="container mx-auto p-6">
        @yield('content')
    </main>

</body>

</html>
