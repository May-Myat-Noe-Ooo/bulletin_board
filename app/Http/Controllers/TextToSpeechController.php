<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\VoiceRssService;

class TextToSpeechController extends Controller
{
    protected $voiceRssService;

    public function __construct(VoiceRssService $voiceRssService)
    {
        $this->voiceRssService = $voiceRssService;
    }

    public function convertToSpeech(Request $request)
    {
        $request->validate([
            'text' => 'required|string',
        ]);

        $text = $request->input('text');
        try {
            $audioContent = $this->voiceRssService->textToSpeech($text);
            $filename = 'audio_' . time() . '.mp3';
            $filePath = public_path('audio/' . $filename);
            file_put_contents($filePath, $audioContent);

            $audioFileUrl = asset('audio/' . $filename);
            return back()->with('audioFileUrl', $audioFileUrl);
        } catch (\Exception $e) {
            return back()->withErrors('Failed to convert text to speech.');
        }
    }
}
