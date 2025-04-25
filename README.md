# Movies JSON API

[![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=flat&logo=laravel)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.1+-777BB4?style=flat&logo=php)](https://php.net)
[![License](https://img.shields.io/badge/license-MIT-blue.svg)](LICENSE.md)

A robust JSON API for managing movies, actors, and users with polymorphic relationships for favorites, follows, and media attachments.

## Features

- **Movie Management**: CRUD operations for movies
- **Actor System**: Manage actors with many-to-many movie relationships
- **User Interactions**:
  - Favorite movies
  - Follow other users
- **Polymorphic Relationships**:
  - Attachments (images for both movies and actors)
  - Favorites/Follows system
- **JWT Authentication**: Secure API endpoints

## Database Schema

![Database Schema](docs/schema.png) *(Consider adding a diagram here)*

Key polymorphic relationships:
- `favorites`: Users can favorite movies
- `follows`: Users can follow other users
- `attachments`: Movies and actors can have images

## Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/ahmedturbe/Movies_API.git
   cd movies-api
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan jwt:secret
php artisan serve

API Endpoints:
Method	Endpoint	Description
POST	/api/auth/register	Register new user
POST	/api/auth/login	User login
GET	/api/movies	List all movies
POST	/api/movies	Create new movie
GET	/api/movies/{id}	Get movie details
PUT	/api/movies/{id}	Update movie
DELETE	/api/movies/{id}	Delete movie
POST	/api/favorites	Add movie to favorites
DELETE	/api/favorites/{id}	Remove from favorites
POST	/api/follows	Follow another user
DELETE	/api/follows/{id}	Unfollow user

Testing
Run tests with:
php artisan test

Technologies Used
Laravel 12
PHP 8.1+
JWT Authentication
PostgreSQL/MySQL
Polymorphic Eloquent Relationships

Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

License
This project is open-source and available under the MIT License.

