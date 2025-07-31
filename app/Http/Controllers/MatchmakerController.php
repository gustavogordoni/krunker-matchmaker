<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\DomCrawler\Crawler;

class MatchmakerController extends Controller
{
    public function index(Request $request)
    {
        return view('games.index');
    }

    public function fetchGames(Request $request)
    {
        $response = Http::get("https://matchmaker.krunker.io/game-list?hostname=krunker.io");

        if (!$response->successful()) {
            return response()->json(['error' => 'Failed to fetch game list'], 500);
        }

        $games = $response->json()['games'] ?? [];

        $regions = $request->get('regions', [
            'MBI',
            'NY',
            'FRA',
            'SIN',
            'DAL',
            'SYD',
            'MIA',
            'BHN',
            'TOK',
            'BRZ',
            'AFR',
            'LON',
            'CHI',
            'SV',
            'STL',
            'MX'
        ]);
        $gamemodes = $request->get('gamemodes', [
            'Free for All',
            'Team Deathmatch',
            'Hardpoint',
            'Capture the Flag',
            'Parkour',
            'Hide & Seek',
            'Infected',
            'Race',
            'Last Man Standing',
            'Simon Says',
            'Gun Game',
            'Prop Hunt',
            'Boss Hunt',
            'Classic FFA',
            'Deposit',
            'Stalker',
            'King of the Hill',
            'One in the Chamber',
            'Trade',
            'Kill Confirmed',
            'Defuse',
            'Sharp Shooter',
            'Traitor',
            'Raid',
            'Blitz',
            'Domination',
            'Squad Deathmatch',
            'Kranked FFA',
            'Team Defender',
            'Deposit FFA',
            'Chaos Snipers',
            'Bighead FFA',
        ]);
        $minPlayers = (int) $request->get('minPlayers', 1);
        $maxPlayers = (int) $request->get('maxPlayers', 8);
        $minTime = (int) $request->get('minRemainingTime', 30);
        $includeCustom = $request->boolean('includeCustom', false);

        $filtered = array_filter($games, function ($game) use ($regions, $gamemodes, $minPlayers, $maxPlayers, $minTime) {
            [$gameID, $regionCode, $playerCount, $playerLimit, $gameInfo, $remainingTime] = $game;
            $gamemodeName = self::mapGamemode($gameInfo['g']);

            return $gameInfo['cm'] == 0
                && in_array(strtoupper(substr($gameID, 0, 3)), $regions)
                && in_array($gamemodeName, $gamemodes)
                && $playerCount >= $minPlayers
                && $playerCount < $maxPlayers
                && $remainingTime <= $minTime;
        });
        
        $enhanced = array_map(function ($game) {
            $game[4]['gamemodeName'] = self::mapGamemode($game[4]['g']);
            return $game;
        }, array_values($filtered));

        return response()->json($enhanced);
    }

    private static function mapGamemode($id)
    {
        $gamemodes = [
            0 => 'Free for All',
            1 => 'Team Deathmatch',
            2 => 'Hardpoint',
            3 => 'Capture the Flag',
            4 => 'Parkour',
            5 => 'Hide & Seek',
            6 => 'Infected',
            7 => 'Race',
            8 => 'Last Man Standing',
            9 => 'Simon Says',
            10 => 'Gun Game',
            11 => 'Prop Hunt',
            12 => 'Boss Hunt',
            13 => 'Classic FFA',
            14 => 'Deposit',
            15 => 'Stalker',
            16 => 'King of the Hill',
            17 => 'One in the Chamber',
            18 => 'Trade',
            19 => 'Kill Confirmed',
            20 => 'Defuse',
            21 => 'Sharp Shooter',
            22 => 'Traitor',
            23 => 'Raid',
            24 => 'Blitz',
            25 => 'Domination',
            26 => 'Squad Deathmatch',
            27 => 'Kranked FFA',
            28 => 'Team Defender',
            29 => 'Deposit FFA',
            30 => 'Chaos Snipers',
            31 => 'Bighead FFA'
        ];

        return $gamemodes[$id] ?? 'Unknown Gamemode';
    }
}
