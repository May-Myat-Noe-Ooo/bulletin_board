<?php

namespace App\Services;

use GuzzleHttp\Client;

class VoiceRssService
{
    protected $client;
    protected $apiKey;

    public function __construct()
    {
        $this->client = new Client([
            'verify' => false,
        ]);
        $this->apiKey = config('services.voicerss.key');
        $this->apiUrl = config('services.voicerss.url');
        // Debugging line
        //dd($this->apiKey);
    }

    public function textToSpeech($text, $language = 'en-us')
    {
        $response = $this->client->request('GET', 'https://api.voicerss.org/', [
            'query' => [
                'key' => $this->apiKey,
                'hl' => $language,
                'src' => $text,
                'c' => 'MP3',
                'r' => '0',
                'f' => '8khz_8bit_mono',
            ],
        ]);
        //dd($response->getBody()->getContents());
        return $response->getBody()->getContents();
    }
}
