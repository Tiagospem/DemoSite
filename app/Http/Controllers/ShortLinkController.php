<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShortLink;
use Illuminate\Support\Str;

class ShortLinkController extends Controller
{
    /**
     * Generates a unique session key for the user
     */
    private function getSessionKey()
    {
        if (!session()->has('user_session_key')) {
            // Combines IP, user agent and something random to create a unique key
            $sessionKey = md5(request()->ip() . request()->userAgent() . Str::random(10));
            session(['user_session_key' => $sessionKey]);
        }
        
        return session('user_session_key');
    }
    
    /**
     * Display the home page
     */
    public function index()
    {
        $sessionKey = $this->getSessionKey();
        $shortLinks = ShortLink::where('session_id', $sessionKey)
                              ->latest()
                              ->get();
        
        return view('shortlinks.index', compact('shortLinks'));
    }

    /**
     * Generate a new shortened link
     */
    public function store(Request $request)
    {
        $request->validate([
            'original_url' => 'required|url'
        ]);

        // Generate a random unique code
        $shortCode = Str::random(6);
        
        // Check if code already exists
        while (ShortLink::where('short_code', $shortCode)->exists()) {
            $shortCode = Str::random(6);
        }

        // Create the shortened link
        ShortLink::create([
            'original_url' => $request->original_url,
            'short_code' => $shortCode,
            'clicks' => 0,
            'session_id' => $this->getSessionKey()
        ]);

        return back()->with('success', 'Shortened link created successfully!');
    }

    /**
     * Redirect to the original URL
     */
    public function redirect($shortCode)
    {
        $shortLink = ShortLink::where('short_code', $shortCode)->firstOrFail();
        
        // Increment click counter
        $shortLink->increment('clicks');
        
        return redirect($shortLink->original_url);
    }

    /**
     * Remove a shortened link
     */
    public function destroy($id)
    {
        $sessionKey = $this->getSessionKey();
        
        // Ensure only the creator can delete the link
        ShortLink::where('id', $id)
                ->where('session_id', $sessionKey)
                ->firstOrFail()
                ->delete();
        
        return back()->with('success', 'Shortened link deleted successfully!');
    }
}
