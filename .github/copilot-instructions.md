# Copilot Instructions for VoteAfrika Codebase

## Architecture Overview

**VoteAfrika** is a Laravel 12 voting and ticketing platform for events. The core architecture revolves around:

- **Events** (top-level entity managed by organizers) → **Categories** → **Contestants** → **Votes**
- **Parallel ticketing system**: Events have Tickets, purchased via TicketOrders
- **Multi-payment integration**: Paystack for both vote purchases and ticket sales
- **Fraud detection**: Built-in `FraudDetectionService` for vote validation
- **Audit logging**: All critical models use the `Auditable` trait to track changes

## Key Developer Commands

### Initial Setup
```bash
composer run setup  # Installs dependencies, runs migrations, seeds DB, builds assets
```

### Development Workflow
```bash
composer run dev  # Starts: Laravel server, queue listener, Pail logs, Vite watcher (concurrently)
npm run build     # Production build for frontend assets
```

### Testing
```bash
composer test     # Runs Pest test suite
```

### Code Quality
```bash
composer pint     # Format PHP code
php artisan tinker # REPL for debugging queries/models
```

## Project Structure & Key Patterns

### Data Models & Relationships
- **Vote**: Central model tracking payments + contestant votes. Uses `Auditable` trait. Has dual fields: `number_of_votes` (preferred) and `vote_count` (backward compat).
- **Event**: Has many Categories; organizer-owned. Auto-generates `slug` in `boot()`.
- **Contestant**: Tracks votes via `total_votes` counter; auto-slugged.
- **TicketOrder**: Handles ticket purchases with QR codes; auto-generates `order_number` and `payment_reference`.
- **AuditLog**: Polymorphic model storing old/new values for all `Auditable` entities.

### Critical Patterns

#### 1. **Auditable Trait** (`app/Traits/Auditable.php`)
All financial/critical models must use it:
```php
use App\Traits\Auditable;  // auto logs create/update/delete
```
**When adding models**: attach `Auditable` trait to track changes (especially Vote, Event, Contestant).

#### 2. **Fraud Detection** (`app/Services/FraudDetectionService.php`)
Core checks:
- Same phone/IP rate-limiting (>10 votes/24h, <1min rapid voting)
- Account farming detection (multiple phones from same IP)
- Duplicate voter detection (email/phone combos)

**Integration**: Call in `VotingController::initiate()` before accepting votes.

#### 3. **Payment Integration** (`app/Services/PaystackService.php`)
- Converts amounts to Kobo (×100)
- Stores gateway metadata as JSON in Vote/TicketOrder
- Metadata includes reference, transaction ID, payment method

**New features**: Always store gateway response metadata for debugging/reconciliation.

#### 4. **Authorization with Policies** (`app/Policies/`)
- `VotePolicy::view()`: Users see own votes OR organizers see event votes
- `VotePolicy::refund()`: Admins only
- Pattern: Check `user->isAdmin()` or `user->ownsEvent()`

**When adding endpoints**: Create corresponding Policy method, enforce with `$this->authorize()`.

#### 5. **Route Organization**
- `routes/web.php`: Public + organizer routes
- `routes/api.php`: Minimal API (mostly legacy)
- `routes/auth.php`: Breeze auth scaffolding
- `routes/organizer.php`: Organizer dashboard (nested)

**Admin routes**: Typically in `Admin/` controllers with middleware group.

## Frontend Stack

- **Vite + Tailwind CSS**: CSS assets in `resources/css/`, JS in `resources/js/`
- **Alpine.js**: Reactive components (in devDependencies)
- **Blade templating**: Views in `resources/views/`, controllers pass data
- **Build**: `npm run dev` watches, `npm run build` for production

**CSS patterns**: Use Tailwind utilities; custom styles in `resources/css/app.css`.

## Testing & Quality

- **Pest Framework**: Tests in `tests/Feature/` and `tests/Unit/`
- **Config**: `phpunit.xml` uses SQLite in-memory DB for fast test runs
- **Naming**: Feature tests for workflows, Unit tests for services/models

**When adding features**: Write Feature tests first (TDD), verify with `composer test`.

## Common Workflows

### Adding a Voteable Entity
1. Create Model with `Auditable` trait
2. Add relationships to Category/Event
3. Create Policy for authorization
4. Add Controller methods (CRUD)
5. Add routes in appropriate file
6. Create migration

### Processing Payments
1. Validate with fraud detection
2. Call `PaystackService->initializeTransaction()`
3. Redirect to Paystack; handle callback at `/voting/callback`
4. Update model `payment_status` and store gateway metadata
5. Log via Auditable trait automatically

### Debugging
- Use `php artisan tinker` to inspect models/relationships
- Check `storage/logs/laravel.log` for errors
- Paystack requests logged in `PaystackService` (see Log statements)
- Run `composer pail` with `npm run dev` for real-time logs

## Database & Migrations

- **Migrations**: `database/migrations/` ordered by timestamp
- **Recent changes**: Vote model expanded with `payment_method`, `number_of_votes` fields (see `2026_01_16_*.php`)
- **Seeding**: `database/seeders/DatabaseSeeder.php`

**New migrations**: Use `php artisan make:migration` then edit. Always include rollback (down) method.

## External Dependencies

- **Paystack API**: Config in `config/paystack.php`; requires `PAYSTACK_SECRET_KEY`, `PAYSTACK_PUBLIC_KEY` in `.env`
- **QR Codes**: `SimpleSoftwareIO\QrCode` for ticket QR generation
- **Image Processing**: `Intervention/image` for contestant photos
- **PDF Export**: `barryvdh/laravel-dompdf` for tickets/reports

## Important Notes for AI Agents

- **Schema stability**: Always check migrations first if unsure about field names (e.g., `number_of_votes` vs `vote_count`)
- **Backward compatibility**: Vote model maintains dual field names; prefer `number_of_votes` in new code
- **Queue jobs**: Use `queue:listen` in dev (part of `composer run dev`)
- **Admin detection**: Use `auth()->user()->isAdmin()` for role checks (defined in User model)
- **Throttling**: Voting routes use `throttle:5,1` middleware; adjust for load testing
