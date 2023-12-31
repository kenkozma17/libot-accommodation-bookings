<?php

namespace App\Services;
use Illuminate\Support\Facades\Http;

class BotLogger
{
    public function logMessage(String $content)
    {
        $response = Http::accept('application/json')
            ->withBody(json_encode(['content' => $content]))
            ->withHeaders([
                'Authorization' => 'Bot ' . env("DISCORD_BOT_SECRET_KEY")
            ])->post('https://discord.com/api/channels/' . env("DISCORD_BOOKINGS_CHANNEL") . '/messages');
        return $response;
    }
}
