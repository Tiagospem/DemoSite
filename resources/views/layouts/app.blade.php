<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>URL Shortener - Encurtador de URLs</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
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
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
</head>

<body class="bg-light font-sans antialiased h-full flex flex-col text-dark">
    <nav class="bg-white border-b border-gray-100 shadow-soft">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0 flex items-center">
                        <i class="fas fa-link text-primary text-lg mr-2"></i>
                        <span class="text-lg font-medium text-primary">URLify</span>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <main class="py-10 flex-grow">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            @yield('content')
        </div>
    </main>

    <footer class="bg-white border-t border-gray-100 mt-auto">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="py-6 flex items-center justify-center">
                <p class="text-gray-500 text-sm">
                    &copy; {{ date('Y') }} URLify. Todos os direitos reservados.
                </p>
            </div>
        </div>
    </footer>
</body>

</html>