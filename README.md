# Dog Manager

A Laravel web application for managing dogs, including a BARF feeding plan and an automatically calculated order list.

![Feeding plan](docs/screenshot-feeding-plan.png)

## Features

- **Dog management (CRUD):** Create, edit and delete dogs. The overview shows each dog with a picture and basic details.
- **Images:** Dog pictures are stored in Laravel's storage; the database only holds the file path.
- **BARF feeding plan:** Clicking a dog's picture opens its weekly plan with meat, bones, offal, vegetables and fat for each day.
- **Order list:** The total amount of each ingredient for 4 weeks is calculated automatically from the weekly plan.
- **Ordering:** The Order button links directly to the supplier's website.

## Tech stack

- PHP / Laravel
- Blade templates
- Custom CSS
- Relational database: the feeding plan is stored in its own table, linked to the dog via the dog ID as a foreign key.

## Installation

```bash
git clone <REPO-URL>
cd <PROJECT-FOLDER>

composer install
cp .env.example .env
php artisan key:generate
```

Then enter your database connection in `.env` and run:

```bash
php artisan migrate
php artisan storage:link
php artisan serve
```

The application will be available at `http://localhost:8000`.

> **Note:** Database contents and uploaded images are not part of the repository. After installation, the application starts out empty.

## Status

Built for personal use. There is no user authentication, so the application is not intended for public deployment.

## Notes

Ingredient names (e.g. *Hühnerkarkasse*, *Lammknochenbrei*) are kept in German on purpose, as they match the product names used by the supplier.
