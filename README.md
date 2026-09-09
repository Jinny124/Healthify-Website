# Healthify

A health discussion forum where people ask everyday health questions and get
answers from the community — including verified doctors. Built with Laravel 11.

Members post threads, reply with nested comments, and up/down-vote both threads
and comments. Any post can be machine-translated in place, and the whole UI is
available in English, Indonesian, and Japanese.

> Started as a university web-programming project and is being cleaned up into a
> portfolio piece. See [Roadmap](#roadmap) for what is still in progress.

## Screenshots

| Thread list | Thread detail |
| --- | --- |
| _add `docs/threads.png`_ | _add `docs/thread-detail.png`_ |

## Features

- **Threads** — create, browse (latest / popular), full-text search, delete your own
- **Comments** — threaded replies (one level of nesting), per-user
- **Voting** — up/down vote on threads and comments; the "popular" feed ranks by score
- **Roles** — register as a normal member or as a *doctor* (with a certificate
  upload). Doctor applications are **reviewed by an admin**; the "Doctor" badge
  only appears once approved
- **Admin panel** — `/admin/doctor-verifications`: approve or reject pending
  doctor applications
- **Profiles** — avatar, join date, list of the user's threads and comments
- **In-place translation** — "Translate" toggles any thread or comment through the
  Azure Translator API and back to the original
- **Localization** — English, Indonesian (`id`), Japanese (`jp`); switch from the navbar
- **Auth** — Laravel Breeze (login, registration, password reset, profile management)

## Tech stack

| Area | Choice |
| --- | --- |
| Framework | Laravel 11, PHP 8.2 |
| Views | Blade |
| Styling | Bootstrap 5.3, Bootstrap Icons |
| Build | Vite 5 |
| Auth scaffolding | Laravel Breeze |
| Database | MySQL in production, SQLite for local development |
| File storage | Azure Blob Storage (image uploads) — optional locally |
| Translation | Azure Translator |
| Tests | Pest |

## Getting started

### Prerequisites

- PHP 8.2+ with `pdo_sqlite` (and `pdo_mysql` if you use MySQL)
- Composer 2
- Node.js 18+ and npm

### Install

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
```

### Database — SQLite (default, zero config)

```bash
# create the database file, then migrate + seed demo data
# Windows PowerShell: New-Item -ItemType File database/database.sqlite
touch database/database.sqlite
php artisan migrate --seed
```

### Database — MySQL (alternative)

Create a database, then set these in `.env`:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=healthify
DB_USERNAME=root
DB_PASSWORD=
```

```bash
php artisan migrate --seed
```

### Run

```bash
npm run build          # or: npm run dev  (for hot reload)
php artisan serve
```

Open http://127.0.0.1:8000.

## Demo accounts

`php artisan migrate --seed` creates ~17 users, 10 threads, ~55 comments, and votes.
Every account uses the password **`password`**.

| Email | Role |
| --- | --- |
| `alice@example.com` | member |
| `citra@example.com` | member |
| `budi@example.com` | verified doctor |
| `dewi@example.com` | doctor — pending approval |
| `admin@example.com` | admin (doctor-verification panel) |

## Localization

UI strings live in `lang/{en,id,jp}/messages.php`. The active locale is stored in
the session and applied by `App\Http\Middleware\LocalizationMiddleware`.

## Deployment

The repo ships a production `Dockerfile` and `docker-entrypoint.sh`. The image
builds PHP + Node, compiles assets, and on start runs `migrate --force`, caches
config/routes/views, and serves on `$PORT` (default `8000`).

### Locally with Docker Compose

`docker-compose.yml` brings up the app plus a MySQL 8 container:

```bash
echo "APP_KEY=$(php artisan key:generate --show)" > .env.docker
docker compose --env-file .env.docker up --build
```

### On a PaaS (Railway / Render / Fly.io)

Point the platform at the `Dockerfile` and set these environment variables
(do **not** commit them):

| Variable | Value |
| --- | --- |
| `APP_KEY` | `base64:...` from `php artisan key:generate --show` |
| `APP_ENV` | `production` |
| `APP_DEBUG` | `false` |
| `APP_URL` | your public URL |
| `DB_CONNECTION` | `mysql` |
| `DB_HOST` / `DB_PORT` / `DB_DATABASE` / `DB_USERNAME` / `DB_PASSWORD` | from the managed database |
| `SESSION_DRIVER` / `CACHE_STORE` / `QUEUE_CONNECTION` | `database` |

Vercel is **not** supported — it has no persistent PHP runtime or filesystem.

## Optional integrations

Image uploads and translation are disabled cleanly when their credentials are
blank. To enable them, fill in the `AZURE_STORAGE_*` and `AZURE_TRANSLATOR_*`
values in `.env`.

## Roadmap

- [x] Admin review step for doctor applications (`admin` role + verification panel)
- [x] Feature tests for threads, comments, votes, and the verification flow
- [x] Auth guard on write routes (create/delete threads, comment, vote)
- [ ] Broader moderation: hide/lock threads, ban users, report queue
- [ ] Thread and profile image uploads are still hard-wired to Azure — only the
      doctor certificate falls back to the local `public` disk
- [ ] The Azure Translator key is currently exposed to the browser — move
      translation behind a server-side endpoint
- [ ] Rate limiting on posting and voting
- [ ] Retire the vendored `public/bootstrap-icons-1.11.3/` copy in favour of the npm package
- [ ] Consolidate on Bootstrap (the Breeze `dashboard` view still uses Tailwind)

## License

MIT.
