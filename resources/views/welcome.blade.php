<!DOCTYPE html>
<html lang="en" class="scroll-smooth" >
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>LockTech | Vehicle Key Lookup</title>

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#f9f9f9] text-[#1b1b18] dark:bg-[#121212] dark:text-[#EDEDEC] min-h-screen flex flex-col items-center py-8 px-4">

    {{-- Header with logo and auth nav --}}
    <header class="w-full lg:max-w-4xl max-w-[335px] mb-12 flex justify-between items-center text-sm">
        <a href="{{ url('/') }}" class="text-2xl font-extrabold tracking-tight select-none">
            <span class="text-indigo-600 dark:text-indigo-400">Lock</span><span class="text-gray-900 dark:text-gray-100">Tech</span>
        </a>

        @if (Route::has('login'))
            <nav class="flex items-center justify-end gap-4">
                @auth
                    <a
                        href="{{ url('/dashboard') }}"
                        class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal"
                    >
                        Dashboard
                    </a>
                @else
                    <a
                        href="{{ route('login') }}"
                        class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] text-[#1b1b18] border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A] rounded-sm text-sm leading-normal"
                    >
                        Log in
                    </a>

                    @if (Route::has('register'))
                        <a
                            href="{{ route('register') }}"
                            class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal"
                        >
                            Register
                        </a>
                    @endif
                @endauth
            </nav>
        @endif
    </header>

    {{-- Main content --}}
    <main class="w-full max-w-4xl text-center px-4">
        {{-- Hero --}}
        <h1 class="text-5xl md:text-6xl font-extrabold leading-tight max-w-3xl mx-auto mb-6">
            Unlock the Right Key,<br />
            Every Time.
        </h1>

        <p class="text-lg md:text-xl text-gray-700 dark:text-gray-300 max-w-xl mx-auto mb-16 leading-relaxed">
            Search by make, model, and year to find the exact locksmith info you need — fast, simple, and reliable.
        </p>

        {{-- Features Cards --}}
        <section class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-4xl mx-auto">
            {{-- Card 1 --}}
            <div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg p-6 flex flex-col items-center text-center hover:shadow-indigo-400/40 transition-shadow duration-300">
                <div class="text-indigo-600 mb-4 text-5xl">🔍</div>
                <h3 class="text-xl font-semibold mb-2">Lookup By Vehicle</h3>
                <p class="text-gray-600 dark:text-gray-400 max-w-xs leading-relaxed">
                    Use make, model, and year filters to narrow results quickly and accurately.
                </p>
            </div>

            {{-- Card 2 --}}
            <div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg p-6 flex flex-col items-center text-center hover:shadow-indigo-400/40 transition-shadow duration-300">
                <div class="text-indigo-600 mb-4 text-5xl">🧠</div>
                <h3 class="text-xl font-semibold mb-2">Smart Database</h3>
                <p class="text-gray-600 dark:text-gray-400 max-w-xs leading-relaxed">
                    Get the exact key code or lock type you need with just one click.
                </p>
            </div>

            {{-- Card 3 --}}
            <div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg p-6 flex flex-col items-center text-center hover:shadow-indigo-400/40 transition-shadow duration-300">
                <div class="text-indigo-600 mb-4 text-5xl">💳</div>
                <h3 class="text-xl font-semibold mb-2">Subscriptions</h3>
                <p class="text-gray-600 dark:text-gray-400 max-w-xs leading-relaxed">
                    Unlock full access by subscribing to a plan that fits your needs.
                </p>
            </div>
        </section>
    </main>

</body>
</html>
