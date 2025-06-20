<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;
use App\Services\GameService;

class GameController extends Controller
{
    public function __construct(private GameService $gameService) {}

    public function leaderboard()
    {
        $leaderboard = $this->gameService->leaderboard();
        return response()->json($leaderboard);
    }

    public function newGame()
    {
        try {
            $game = $this->gameService->newGame();
            return response()->json([
                'message' => 'Game started successfully',
                'game' => $game,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function nextNumber()
    {
        try {
            $game = $this->gameService->nextNumber();

            return response()->json($game->current_number);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function win(Request $request)
    {
        try {
            $user = auth()->user();
            $currentGame = $this->gameService->win($user, $request->score);

            return response()->json([
                'message' => 'Game won successfully',
                'game' => $currentGame,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function validateNumber(Request $request)
    {
        $request->validate([
            'number' => 'required|integer|min:1|max:100',
        ]);

        try {
            $isCorrect = $this->gameService->validateNumber($request->number);

            return response()->json([
                'correct' => $isCorrect,
                'message' => $isCorrect ? 'Correct number!' : 'Wrong number!',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }
}
