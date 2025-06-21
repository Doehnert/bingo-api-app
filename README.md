# Tech Test: B I N G O

> "a game in which players mark off numbers on cards as the numbers are drawn randomly by a caller, the winner being the first person to mark off all their numbers."

## Overview

This is the backend part of the application.

#### Number Caller (est. 15 mins)

1. Add a "Call next number" button
2. Clicking the button will invoke an API call that generates a random number between 1 and 100.
3. The generated number will be displayed to the user on the frontend.
4. The same number cannot be called twice in a single game of Bingo

### Backend Features Implemented

- ✅ **Number Generation**: Generate unique random numbers (1-100) for Bingo calls
- ✅ **Number Validation**: Validate called numbers against current game
- ✅ **Scoring System**: Calculate scores based on number of calls
- ✅ **Winner Management**: Record winners and their scores
- ✅ **Leaderboard**: Display winners in descending order by score
- ✅ **API Endpoints**: RESTful API for frontend integration

### API Endpoints

- `POST /api/games` - Create a new game
- `GET /api/games/active` - Get current active game
- `POST /api/games/next-number` - Call next number
- `POST /api/games/validate` - Validate a number
- `POST /api/games/win` - Record a winner
- `GET /api/leaderboard` - Get leaderboard

## Installation & Setup

### Prerequisites

- PHP 8.2 or higher
- Composer
- MySQL/PostgreSQL/SQLite

### Backend Setup

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd bingo-api-app
   ```

2. **Install dependencies**
   ```bash
   composer install
   ```

3. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Configure database**
   Edit `.env` file and set your database credentials:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=bingo_game
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

5. **Run migrations**
   ```bash
   php artisan migrate
   ```

6. **Start the server**
   ```bash
   php artisan serve
   ```

   The API will be available at `http://localhost:8000`

### Testing

Run the test suite:
```bash
./vendor/bin/pest
```

Or run specific test files:
```bash
./vendor/bin/pest tests/Feature/GameServiceTest.php
```

## Development

### Key Components

- **GameService**: Core business logic for game management
- **Game Model**: Eloquent model for game data
- **GameController**: API endpoints for game operations
- **Database Migrations**: Game table structure
- **Factories**: Test data generation

### Architecture

The application follows Laravel best practices with:
- Service layer for business logic
- Eloquent models for data access
- RESTful API controllers
- Comprehensive test coverage with Pest

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
