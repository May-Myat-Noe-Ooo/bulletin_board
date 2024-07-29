<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\VoiceRssService;

class VoiceRssController extends Controller
{
    protected $voiceRssService;

    public function __construct(VoiceRssService $voiceRssService)
    {
        $this->voiceRssService = $voiceRssService;
    }

    public function showForm()
    {
        return view('text_to_speech');
    }

    public function convertTextToSpeech(Request $request)
    {
        $request->validate([
            'text' => 'required|string',
        ]);

        $text = $request->input('text');
        $audioContent = $this->voiceRssService->textToSpeech($text);

        $filename = 'audio_' . time() . '.mp3';
        $filePath = public_path('audio/' . $filename);
        file_put_contents($filePath, $audioContent);

        return view('text_to_speech', [
            'audioFile' => url('audio/' . $filename),
        ]);
    }
}
