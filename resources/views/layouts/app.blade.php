<!DOCTYPE html>
<html lang="en" class="h-full" x-data="{ darkMode: localStorage.getItem('darkMode') || (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light') }" x-init="$watch('darkMode', val => localStorage.setItem('darkMode', val))" :class="{ 'dark': darkMode === 'dark' }">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>URL Shortener</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: '#000000',
                        secondary: '#333333',
                        accent: '#FFFFFF',
                        light: '#F7F7F7',
                        dark: '#0F0F0F',
                    },
                    boxShadow: {
                        'soft': '0 2px 10px rgba(0, 0, 0, 0.05)',
                        'medium': '0 4px 20px rgba(0, 0, 0, 0.08)',
                    }
                },
                fontFamily: {
                    sans: ['Inter', 'sans-serif'],
                }
            }
        }
    </script>
    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
</head>

<body class="bg-light dark:bg-gray-900 font-sans antialiased h-full flex flex-col text-dark dark:text-gray-100">
    <nav class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700 shadow-soft">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0 flex items-center">
                        <i class="fas fa-link text-primary dark:text-gray-200 text-lg mr-2"></i>
                        <span class="text-lg font-medium text-primary dark:text-white">URLify</span>
                    </div>
                </div>
                <div class="flex items-center">
                    <button @click="darkMode = darkMode === 'dark' ? 'light' : 'dark'" class="p-2 rounded-full text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none">
                        <i x-show="darkMode === 'light'" class="fas fa-moon"></i>
                        <i x-show="darkMode === 'dark'" class="fas fa-sun"></i>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <main class="py-10 flex-grow">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            @yield('content')
        </div>
    </main>

    <footer class="bg-white dark:bg-gray-800 border-t border-gray-100 dark:border-gray-700 mt-auto">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="py-6 flex items-center justify-center">
                <p class="text-gray-500 dark:text-gray-400 text-sm">
                    &copy; {{ date('Y') }} URLify. All rights reserved.
                </p>
            </div>
        </div>
    </footer>
</body>

</html>