@extends('layouts.app')

@section('content')
    <div class="py-6">
        <div class="max-w-4xl mx-auto">
            <!-- Título -->
            <div class="text-center mb-12">
                <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-3">Encurtador de URLs</h1>
                <p class="text-gray-600 max-w-2xl mx-auto">
                    Crie links curtos e fáceis de compartilhar com nossa ferramenta gratuita.
                </p>
            </div>

            <!-- Mensagens de alerta -->
            @if(session('success'))
                <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-md" role="alert">
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-md" role="alert">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Card principal -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden mb-12">
                <div class="p-6 md:p-8">
                    <form action="{{ route('shorten.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div class="flex flex-col items-center">
                            <label for="original_url"
                                class="block text-sm font-medium text-gray-700 mb-2 text-center w-full">
                                Digite a URL que deseja encurtar
                            </label>
                            <div class="flex w-full max-w-2xl mx-auto">
                                <input type="url" name="original_url" id="original_url"
                                    placeholder="https://exemplo.com/url-muito-longa-para-encurtar" required
                                    class="flex-grow px-4 py-3 rounded-l-lg border border-gray-300 focus:ring-primary focus:border-primary">
                                <button type="submit"
                                    class="bg-primary hover:bg-blue-600 text-white py-3 px-6 rounded-r-lg font-medium transition-colors duration-200">
                                    Encurtar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Lista de links -->
            @if(count($shortLinks) > 0)
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-800">Seus links encurtados</h2>
                    </div>
                    <div class="divide-y divide-gray-200">
                        @foreach($shortLinks as $link)
                            <div class="p-6 md:flex md:items-center md:justify-between">
                                <div class="mb-4 md:mb-0">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 text-primary">
                                            <i class="fas fa-link"></i>
                                        </div>
                                        <div class="ml-3">
                                            <a href="{{ route('shorten.redirect', $link->short_code) }}" target="_blank"
                                                class="text-base font-medium text-primary hover:underline">
                                                {{ url('/') }}/{{ $link->short_code }}
                                            </a>
                                            <div class="mt-1 text-sm text-gray-500 truncate max-w-md"
                                                title="{{ $link->original_url }}">
                                                {{ $link->original_url }}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex items-center">
                                    <div class="mr-6 text-center">
                                        <span class="block text-2xl font-bold text-gray-900">{{ $link->clicks }}</span>
                                        <span class="text-xs text-gray-500">cliques</span>
                                    </div>

                                    <div class="flex space-x-2">
                                        <button onclick="copyToClipboard('{{ url('/' . '/' . $link->short_code) }}')"
                                            class="bg-gray-100 hover:bg-gray-200 text-gray-700 p-2 rounded-md transition-colors duration-200"
                                            title="Copiar link">
                                            <i class="fas fa-copy"></i>
                                        </button>

                                        <form action="{{ route('shorten.destroy', $link->id) }}" method="POST"
                                            onsubmit="return confirm('Tem certeza que deseja excluir este link?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="bg-red-100 hover:bg-red-200 text-red-600 p-2 rounded-md transition-colors duration-200"
                                                title="Excluir link">
                                                <i class="fas fa-trash"></i>
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
                alert('Link copiado para a área de transferência!');
            }).catch(err => {
                console.error('Erro ao copiar texto: ', err);
            });
        }
    </script>
@endsection