<?php

use Exception;
use App\Models\Game;
use App\Services\GameService;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('creating a new game deactivates all other games', function () {
    $currentGame = Game::factory()->create([
        'is_active' => true,
    ]);
    $otherGame = Game::factory()->create([
        'is_active' => false,
    ]);

    (new GameService())->newGame();
    $game = Game::active()->first();

    $this->assertDatabaseHas('games', [
        'is_active' => true,
        'id' => $game->id,
    ]);
    $this->assertDatabaseHas('games', [
        'is_active' => false,
        'id' => $currentGame->id,
    ]);
});

it('can validate a number', function () {
    $gameService = new GameService();
    $gameService->newGame();
    $game = Game::active()->first();
    $game->current_number = 1;
    $game->save();
    $game->refresh();
    $number = $gameService->validateNumber(1);
    expect($number)->toBeTrue();
    $number = $gameService->validateNumber(2);
    expect($number)->toBeFalse();
});

it('test generating more than 100 numbers throws an exception', function () {
    $gameService = new GameService();
    $gameService->newGame();
    $game = Game::active()->first();
    $game->current_number = 1;
    $game->save();
    $game->refresh();
    for ($i = 0; $i < 100; $i++) {
        $gameService->advanceGame();
    }
    $this->expectException(Exception::class);
    $gameService->advanceGame();
});

it('test all generated numbers are unique', function () {
    $gameService = new GameService();
    $gameService->newGame();
    $uniqueNumbers = [];
    $game = Game::active()->first();
    $game->current_number = 1;
    $game->save();
    $game->refresh();
    for ($i = 0; $i < 100; $i++) {
        $number = $gameService->advanceGame();
        $uniqueNumbers[] = $number;
    }
    expect($uniqueNumbers)->toHaveCount(100);
    expect($uniqueNumbers)->toHaveCount(count(array_unique($uniqueNumbers)));
});
