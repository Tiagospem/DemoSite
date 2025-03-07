<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShortLink;
use Illuminate\Support\Str;

class ShortLinkController extends Controller
{
    /**
     * Exibe a página inicial
     */
    public function index()
    {
        $shortLinks = ShortLink::latest()->get();
        return view('shortlinks.index', compact('shortLinks'));
    }

    /**
     * Gera um novo link encurtado
     */
    public function store(Request $request)
    {
        $request->validate([
            'original_url' => 'required|url'
        ]);

        // Gera um código único aleatório
        $shortCode = Str::random(6);
        
        // Verifica se o código já existe
        while (ShortLink::where('short_code', $shortCode)->exists()) {
            $shortCode = Str::random(6);
        }

        // Cria o link encurtado
        ShortLink::create([
            'original_url' => $request->original_url,
            'short_code' => $shortCode,
            'clicks' => 0
        ]);

        return back()->with('success', 'Link encurtado criado com sucesso!');
    }

    /**
     * Redireciona para a URL original
     */
    public function redirect($shortCode)
    {
        $shortLink = ShortLink::where('short_code', $shortCode)->firstOrFail();
        
        // Incrementa o contador de cliques
        $shortLink->increment('clicks');
        
        return redirect($shortLink->original_url);
    }

    /**
     * Remove um link encurtado
     */
    public function destroy($id)
    {
        ShortLink::findOrFail($id)->delete();
        
        return back()->with('success', 'Link encurtado removido com sucesso!');
    }
}
