
## Installation

```bash
git clone https://github.com/tuanmoccs/test_laravel.git
cd test_laravel
composer install
cp .env.example .env
php artisan key:generate
```

### Configure `.env`

Database (MySQL):

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=test_laravel
DB_USERNAME=root
DB_PASSWORD=
```

Create the database first: `CREATE DATABASE test_laravel CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;`

Or use SQLite: set `DB_CONNECTION=sqlite`, remove the other `DB_*` lines and create an empty `database/database.sqlite` file.

Mail (needed for "Forgot password"):

```dotenv
APP_URL=http://localhost:8000
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your-username
MAIL_PASSWORD=your-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="no-reply@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```

For local testing without SMTP set `MAIL_MAILER=log` — the reset link is written to `storage/logs/laravel.log`.
`APP_URL` must match the URL you open the app with, otherwise the link in the email will be wrong.

### Database & storage

```bash
php artisan migrate --seed
php artisan storage:link
php artisan serve
```

Open http://localhost:8000 and log in with:

- Email: `admin@example.com`
- Password: `password`

The seeder imports locations from `database/data/locations.csv`.

## Daily reset of locations

`php artisan locations:reset` wipes the `locations` table (including soft-deleted rows) and re-imports the CSV.
It is scheduled to run every day at 00:00 (`app/Console/Kernel.php`). To activate the scheduler add this cron entry on the server:

```cron
* * * * * cd /path/to/test_laravel && php artisan schedule:run >> /dev/null 2>&1
```

On Windows use Task Scheduler to run `php artisan schedule:run` every minute, or run `php artisan schedule:work` while developing.

## Routes

| Method | URL | Name | Auth |
|---|---|---|---|
| GET | `/` | index | user |
| GET/POST | `/login` | login | guest |
| POST | `/logout` | logout | user |
| GET/POST | `/forgot-password` | password.request / password.email | guest |
| GET | `/reset-password/{token}` | password.reset | guest |
| POST | `/reset-password` | password.update | guest |
| GET | `/profile/edit` | profile.edit | user |
| PUT | `/profile` | profile.update | user |
| GET | `/locations` | locations.index | user |
| GET | `/api/locations` | api.locations.index (DataTables JSON) | user |
| GET | `/locations/create` | locations.create | user |
| POST | `/locations` | locations.store | user |
| GET | `/locations/{location}/edit` | locations.edit | user |
| PUT | `/locations/{location}` | locations.update | user |
| DELETE | `/locations/{location}` | locations.destroy (soft delete) | user |

## Tests

```bash
php artisan test
```

## Notes

- Laravel 10 is past end of life and Composer flags security advisories for `laravel/framework` 10.x. `composer.json` sets `audit.block-insecure=false` only so that the required Laravel 10 version can be installed.
- Template assets copied to `public/assets` are a subset of the Limitless kit (fonts, Phosphor icons, Bootstrap, jQuery, DataTables, theme CSS/JS).
