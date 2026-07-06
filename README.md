# DavetKart API (Backend)

Laravel 12 REST API for the DavetKart invitation-management SPA (`../Frontend`).
Token-based auth via **Laravel Sanctum** (`Authorization: Bearer <token>`), business
logic in a dedicated **Service layer**, camelCase wire format via **API Resources**.

## Requirements

- PHP **8.2+** (with `sqlite3` / `pdo_sqlite` extension for the default DB)
- Composer 2

## Setup

```bash
cd Backend
composer install
cp .env.example .env          # Windows: copy .env.example .env
php artisan key:generate
php artisan migrate           # creates database/database.sqlite tables
php artisan storage:link      # exposes uploads at /storage/...
php artisan serve             # http://localhost:8000
```

The default database is **SQLite** (zero config). Switch to MySQL/PostgreSQL by
editing the `DB_*` block in `.env` — the JSON columns work on both.

### Connecting the frontend

Either set `VITE_API_BASE_URL=http://localhost:8000/api` in the frontend `.env`,
or proxy `/api` to `http://localhost:8000` in `vite.config.ts`. Then swap the
mock adapters in `Frontend/src/services/{auth,persistence,media}.ts` for HTTP
adapters that call this API through the shared axios client.

## Endpoints

| Method | Path | Auth | Description |
| --- | --- | --- | --- |
| POST | `/api/auth/register` | – | `{ fullName, email, password }` → `{ user, token }` (201) |
| POST | `/api/auth/login` | – | `{ email, password }` → `{ user, token }` |
| POST | `/api/auth/logout` | ✔ | Revokes the current token |
| GET | `/api/invitations` | ✔ | The user's invitation object, or `null` |
| POST/PUT | `/api/invitations` | ✔ | Upserts the full invitation object |
| GET | `/api/rsvps` | ✔ | Guest responses, newest first |
| POST | `/api/rsvps` | ✔ | Creates a response from an `RsvpDraft` (201) |
| DELETE | `/api/rsvps/{id}` | ✔ | Deletes one of the user's responses (204) |
| POST | `/api/media/upload` | ✔ | multipart `file` → `{ url }` (201) |
| POST | `/api/ai/generate` | ✔ | `{ prompt }` → `{ text }` — Google GenAI proxy |

Errors are always JSON: `401` invalid/expired token (frontend auto-logout),
`422` validation, `404` missing/foreign resource, `501` AI proxy not configured.

## Architecture

```
app/
├── Enums/            RsvpStatus (backed enum, Turkish wire values)
├── Http/
│   ├── Controllers/  Thin: request → service → resource
│   ├── Requests/     FormRequest validation (camelCase fields, as sent by SPA)
│   └── Resources/    DB (snake_case) → wire (camelCase) mapping
├── Models/           User, Invitation, Rsvp (fillable + casts, JSON columns)
└── Services/         AuthService, InvitationService, RsvpService,
                      MediaService, AiService — all business logic lives here
```

- **One invitation per user** (`invitations.user_id` unique) — matches the
  frontend persistence boundary, which loads/saves a single object.
- List data (`timelineEvents`, `galleryImages`, `giftOptions`) is stored in
  JSON columns and cast to arrays on the model.
- RSVPs are scoped through the owner relation (`$user->rsvps()`), so deleting
  another account's record is structurally impossible.
- `POST /api/ai/generate` proxies Google GenAI server-side; set
  `GOOGLE_GENAI_API_KEY` in `.env` to enable it (returns 501 otherwise).
