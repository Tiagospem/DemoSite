@extends('layouts.app')

@section('content')
    <div class="py-8">
        <div class="max-w-3xl mx-auto">
            <!-- Title -->
            <div class="text-center mb-10">
                <h1 class="text-3xl font-semibold text-dark mb-3">URL Shortener</h1>
                <p class="text-gray-600 max-w-lg mx-auto">
                    Create short links and share easily.
                </p>
            </div>

            <!-- Alert messages -->
            @if(session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 text-green-700 p-4 rounded-md shadow-soft" role="alert">
                    <p class="text-sm">{{ session('success') }}</p>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 bg-red-50 border border-red-200 text-red-700 p-4 rounded-md shadow-soft" role="alert">
                    <ul class="text-sm">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Main card -->
            <div class="bg-white rounded-lg shadow-medium mb-12 overflow-hidden">
                <div class="p-6 md:p-8">
                    <form action="{{ route('shorten.store') }}" method="POST">
                        @csrf
                        <div class="flex flex-col items-center">
                            <label for="original_url" class="block text-sm text-gray-600 mb-3 text-center w-full">
                                Enter the URL you want to shorten
                            </label>
                            <div class="flex w-full max-w-xl mx-auto">
                                <input type="url" name="original_url" id="original_url"
                                    placeholder="https://example.com/long-url-to-shorten" required
                                    class="flex-grow px-4 py-3 rounded-l-md border border-gray-200 focus:ring-1 focus:ring-primary focus:border-primary">
                                <button type="submit"
                                    class="bg-primary text-white py-3 px-6 rounded-r-md font-medium transition-colors duration-200 hover:bg-gray-800">
                                    Shorten
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Links list -->
            @if(count($shortLinks) > 0)
                <div class="bg-white rounded-lg shadow-medium overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100">
                        <h2 class="text-base font-medium text-dark">Your temporary links</h2>
                        <p class="text-xs text-gray-500 mt-1">Links visible only in this session</p>
                    </div>
                    <div class="divide-y divide-gray-100">
                        @foreach($shortLinks as $link)
                            <div class="p-5 md:flex md:items-center md:justify-between">
                                <div class="mb-3 md:mb-0">
                                    <div class="flex items-center">
                                        <div class="ml-0">
                                            <a href="{{ route('shorten.redirect', $link->short_code) }}" target="_blank"
                                                class="text-sm font-medium text-primary hover:underline">
                                                {{ url('/') }}/{{ $link->short_code }}
                                            </a>
                                            <div class="mt-1 text-xs text-gray-500 truncate max-w-md"
                                                title="{{ $link->original_url }}">
                                                {{ $link->original_url }}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex items-center">
                                    <div class="mr-4 text-center">
                                        <span class="block text-lg font-medium text-dark">{{ $link->clicks }}</span>
                                        <span class="text-xs text-gray-400">clicks</span>
                                    </div>

                                    <div class="flex space-x-2">
                                        <button onclick="copyToClipboard('{{ url('/') }}/{{ $link->short_code }}')"
                                            class="bg-gray-50 hover:bg-gray-100 text-gray-600 p-2 rounded-md transition-colors duration-200 border border-gray-100"
                                            title="Copy link">
                                            <i class="fas fa-copy text-xs"></i>
                                        </button>

                                        <form action="{{ route('shorten.destroy', $link->id) }}" method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this link?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="bg-gray-50 hover:bg-gray-100 text-red-500 p-2 rounded-md transition-colors duration-200 border border-gray-100"
                                                title="Delete link">
                                                <i class="fas fa-trash text-xs"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(() => {
                alert('Link copied to clipboard!');
            }).catch(err => {
                console.error('Error copying text: ', err);
            });
        }
    </script>
@endsection