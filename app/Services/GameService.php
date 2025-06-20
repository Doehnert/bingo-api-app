<?php

namespace App\Services;

use App\Models\Game;
use App\Models\User;

class GameService
{
    public function leaderboard()
    {
        $games = Game::query()
            ->with('winnerUser')
            ->inactive()
            ->whereNotNull('winner')
            ->orderBy('winner_score', 'desc')
            ->get();

        $leaderboard = [];
        foreach ($games as $game) {
            $leaderboard[] = [
                'winner' => $game->winnerUser->name,
                'winner_score' => $game->winner_score,
                'game_id' => $game->id,
            ];
        }
        return $leaderboard;
    }

    public function newGame()
    {
        // Deactivate all other games
        Game::where('is_active', true)->update(['is_active' => false]);

        $game = Game::create([
            'is_active' => true,
            'called_numbers' => [],
        ]);
    }

    public function nextNumber()
    {
        $game = Game::active()->first();
        if (!$game) {
            $game = Game::create([
                'is_active' => true,
                'called_numbers' => [],
            ]);
        }

        $number = $this->generateRandomNumber($game);

        // Add the number to called_numbers array
        $calledNumbers = $game->called_numbers ?? [];
        $calledNumbers[] = $number;

        $game->current_number = $number;
        $game->called_numbers = $calledNumbers;
        $game->save();

        return $game;
    }

    public function validateNumber(int $number)
    {
        $game = $this->currentGame();

        if (!$game) {
            throw new \Exception('No active game found');
        }

        if ($number === $game->current_number) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Generate a random number that is not in the called numbers array
     * @param Game $game
     * @return int
     */
    private function generateRandomNumber(Game $game)
    {
        $calledNumbers = $game->called_numbers ?? [];

        if (count($calledNumbers) >= 100) {
            throw new \Exception('All numbers have been called!');
        }

        do {
            $number = rand(1, 100);
        } while (in_array($number, $calledNumbers));

        return $number;
    }

    public function win(User $user, int $score)
    {
        $game = $this->currentGame();
        if (!$game) {
            throw new \Exception('No active game found');
        }

        $game->winner = $user->id;
        $game->winner_score = $score;
        $game->is_active = false;
        $game->save();
        return $game;
    }

    private function currentGame()
    {
        return Game::active()->latest()->first();
    }
}
