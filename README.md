<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About CimaFlix


CimaFlix is a movie and series web application built with Laravel. It leverages Laravel's powerful features to provide a seamless and enjoyable experience for users. This README provides instructions for setting up and running the application locally using Docker and Laravel Sail.

Prerequisites

Before you begin, ensure you have the following installed:

    Docker
    Docker Compose


## Installation

### Clone the Repository
- **https://github.com/ayoubzerouali/cimaflix.git**
- **cd cimaflix**

### Install Laravel Sail
- **composer require laravel/sail --dev**
- **php artisan sail:install**
- **./vendor/bin/sail up**

## API TMDB INSTALLATION 
- **Go to this link <a href="https://www.themoviedb.org/">https://www.themoviedb.org/</a>**
- after login get the API KEY
- 

Obtain an API Read Access Token from TMDb and set it in your .env file:
- **TMDB_API_KEY=your_api_read_access_token_here**


## Running the Application

### Start Docker Containers

- **./vendor/bin/sail up**
- **./vendor/bin/sail artisan key:generate**
- **./vendor/bin/sail artisan migrate --seed**



## API Endpoints

### YOU CAN FIND THE DOCUMENTATION ON THIS LINK 

<a target='_blank' href="https://documenter.getpostman.com/view/37807536/2sA3sAhnyZ">https://documenter.getpostman.com/view/37807536/2sA3sAhnyZ</a>

Or directly here :) 

User Authentication and Management

    Get Authenticated User Information
        Endpoint: GET /v1/user
        Description: Retrieves information about the currently authenticated user.
        Authentication: Required (Sanctum Token)

    Register a New User
        Endpoint: POST /v1/register
        Description: Registers a new user with a username and password.
        Parameters:
            username (string) - The user's username.
            password (string) - The user's password.

    Log In an Existing User
        Endpoint: POST /v1/login
        Description: Authenticates an existing user and returns a token for session management.
        Parameters:
            username (string) - The user's username.
            password (string) - The user's password.

Movie and Series Management

    Search for Movies or TV Shows
        Endpoint: GET /v1/search
        Description: Searches for movies or TV shows based on query parameters.
        Parameters:
            query (string) - The search term (e.g., movie title, TV show name).
            perPage (integer) - Number of items per page (optional).
            page (integer) - Page number for pagination (optional).

    Movies Routes
        List of Movies
            Endpoint: GET /v1/movies/
            Description: Retrieves a paginated list of movies.
        Movie Details
            Endpoint: GET /v1/movies/show/{id}
            Description: Retrieves details of a specific movie by its ID.
            Parameters:
                id (integer) - The movie ID.
        Get Movie Trailer
            Endpoint: GET /v1/movies/trailer/{movieId}
            Description: Retrieves the trailer for a specific movie.
            Parameters:
                movieId (integer) - The movie ID.
        Top-Rated Movies
            Endpoint: GET /v1/movies/top
            Description: Retrieves a list of top-rated movies.

    Series Routes
        List of Series
            Endpoint: GET /v1/series/
            Description: Retrieves a paginated list of TV series.
        Series Details
            Endpoint: GET /v1/series/show/{id}
            Description: Retrieves details of a specific TV series by its ID.
            Parameters:
                id (integer) - The series ID.
        Get Series Trailer
            Endpoint: GET /v1/series/trailer/{serieId}
            Description: Retrieves the trailer for a specific TV series.
            Parameters:
                serieId (integer) - The series ID.
        Top-Rated Series
            Endpoint: GET /v1/series/top
            Description: Retrieves a list of top-rated TV series.

Favorites Management

    Get All Favorites
        Endpoint: GET /v1/favorites/
        Description: Retrieves a list of all favorite movies and TV shows for the authenticated user.
        Authentication: Required (Sanctum Token)

    Add a Movie to Favorites
        Endpoint: POST /v1/favorites/movie/{id}
        Description: Adds a movie to the authenticated user's favorites list.
        Parameters:
            id (integer) - The movie ID.
        Authentication: Required (Sanctum Token)

    Add a TV Show to Favorites
        Endpoint: POST /v1/favorites/tv/{id}
        Description: Adds a TV show to the authenticated user's favorites list.
        Parameters:
            id (integer) - The TV show ID.
        Authentication: Required (Sanctum Token)

    Remove from Favorites
        Endpoint: DELETE /v1/favorites/{id}
        Description: Removes a movie or TV show from the authenticated user's favorites list.
        Parameters:
            id (integer) - The ID of the movie or TV show to be removed.
        Authentication: Required (Sanctum Token)



