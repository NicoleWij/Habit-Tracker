# Habit Tracker API

A simple Habit Tracker API built with PHP and SQLite. This project lets you track daily habits via a RESTful API.

This project was given to me during Netlight Tech Avenue as a practice project to work on at home.

## Current Features (WORK IN PROGRESS)

- **GET /habits**: Retrieve all habits.
- **GET /habits/{id}**: Retrieve a specific habit by its ID.
- **POST /habits**: Create a new habit.

## Setup Instructions

1. Clone the repository:

   ```bash
   git clone https://github.com/yourusername/habit-tracker.git  
   cd habit-tracker
   ```

2. Set up the database:

   ```bash
   php setup.php
   ```

3. Start the PHP server:

   ```bash
   php -S localhost:8000
   ```

## Project Structure

- **setup.php**: Script to create the SQLite database and table.
- **db.php**: Contains the database connection and functions.
- **index.php**: Main API routing file.
