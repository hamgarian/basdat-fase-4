# GitHub Copilot Instructions for Safety Management System

## Project Overview

This is a **Safety Management System (SMS)** for aviation operations, specifically designed for helicopter and aircraft fleet management. The application manages safety reports, hazard identification, incident tracking, investigations, audits, and compliance documentation for aviation operations.

**Primary Purpose**: Track and manage aviation safety events, hazard reports, incidents, investigations, audits, and maintain a library of safety manuals while managing flight operations, aircraft, pilots, and clients.

## Tech Stack

- **Framework**: Laravel 12.x (PHP 8.2+)
- **Frontend**: Blade Templates with Alpine.js and Tailwind CSS 3
- **Build Tool**: Vite 7
- **Database**: PostgreSQL (primary), with support for other databases
- **Authentication**: Laravel Breeze
- **Session/Queue/Cache**: Database-backed
- **Testing**: PHPUnit 11.5

## Project Structure

```
app/
├── Http/
│   ├── Controllers/     # Controller classes (Resource controllers pattern)
│   └── Requests/        # Form request validation classes
├── Models/              # Eloquent models (Aviation domain entities)
└── Providers/           # Service providers
database/
├── migrations/          # Database schema migrations
└── seeders/            # Database seeders (Note: Data loaded via SQL, not seeders)
resources/
├── views/              # Blade templates
└── js/                 # Frontend JavaScript (Alpine.js)
routes/
├── web.php            # Web routes (authenticated routes use middleware)
└── auth.php           # Authentication routes (Laravel Breeze)
tests/
├── Feature/           # Feature tests (HTTP/Controller tests)
└── Unit/              # Unit tests
```

## Domain Model

### Core Entities

- **Karyawan** (Employee) - Aviation staff/employees
- **HazardReport** - Safety hazard reports with categories (FOD, Maintenance, Wildlife, Ground Handling, Documentation)
- **Incident** - Aviation incidents requiring investigation
- **Investigation** - Investigation records linked to hazards/incidents
- **Audit** - Safety audits and compliance checks
- **Temuan** (Finding) - Audit findings
- **LibraryManual** - Safety manuals and documentation library
- **Pesawat** (Aircraft) - Generic aircraft
- **Helicopter** - Helicopter-specific records
- **PrivateJet** - Private jet-specific records
- **Pilot** - Pilot records
- **Penerbangan** (Flight) - Flight records
- **FlightMovement** - Flight movement tracking
- **Client** - Clients using aviation services
- **User** - System users (authentication)

### Key Relationships

- HazardReport belongs to Karyawan (employee reporter)
- Investigation belongs to HazardReport
- Temuan belongs to Audit
- Penerbangan (Flight) uses Pesawat (Aircraft) and Pilot
- Aircraft hierarchy: Pesawat → Helicopter/PrivateJet (specialization)

## Coding Conventions

### PHP/Laravel Standards

1. **PSR-12 Coding Style**: Follow PSR-12 coding standards
   - Use Laravel Pint for code formatting: `./vendor/bin/pint`

2. **Type Declarations**: Always use strict types and return type declarations
   ```php
   public function index(): View
   public function store(Request $request): RedirectResponse
   ```

3. **Validation**: Use array validation syntax with explicit rules
   ```php
   $validated = $request->validate([
       'field' => ['required', 'string', 'max:255'],
   ]);
   ```

4. **Model Conventions**:
   - Explicitly define `$table`, `$primaryKey` if non-standard
   - Set `public $timestamps = false` if table doesn't have timestamps
   - Use `$fillable` for mass assignment
   - Use `$casts` for type casting (dates, integers, etc.)
   - Define relationships with proper type hints

5. **Controller Patterns**:
   - Use resource controllers for CRUD operations
   - Return views using `view()` helper with `compact()`
   - Use named routes for redirects
   - Include success messages when redirecting after mutations

6. **Naming Conventions**:
   - Database/Model fields use Indonesian terms where appropriate (e.g., `nama_karyawan`, `tanggal_laporan`)
   - Keep database column names in snake_case
   - Use descriptive variable names that reflect domain concepts

### Frontend Standards

1. **Tailwind CSS**: Use Tailwind utility classes for styling
2. **Alpine.js**: Use Alpine.js for interactive components
3. **Blade Templates**: Use Blade directives and components

### Database Conventions

1. **PostgreSQL Primary**: Application is designed for PostgreSQL
2. **Custom Primary Keys**: Many tables use custom primary key names (e.g., `id_hazard`, `id_karyawan`)
3. **Enum Values**: Use specific enum values for categories and statuses:
   - HazardReport categories: FOD, Maintenance, Wildlife, Ground Handling, Documentation
   - Status values: Open, Investigated, Closed
4. **No Timestamps**: Many tables have `timestamps = false`

## Development Workflow

### Setup Commands

```bash
# Initial setup
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate

# Frontend setup
npm install
npm run build

# For development
composer run dev  # Starts server, queue, and Vite concurrently
```

### Build and Test Commands

```bash
# Code formatting
./vendor/bin/pint

# Run tests
composer test
# or
php artisan test

# Build assets
npm run build

# Development mode with hot reload
npm run dev
```

### Linting

- **PHP**: Use Laravel Pint (configured in project)
  ```bash
  ./vendor/bin/pint
  ```

## Deployment

- **Platform**: Coolify (documented in DEPLOYMENT.md)
- **Database**: PostgreSQL required in production
- **Environment**: See `.env.example` for required variables
- **Build Process**: Composer install, npm build, migrations, cache optimization
- **Important**: 
  - Set `APP_URL` to HTTPS in production
  - Use database-backed sessions, queues, and cache
  - Run migrations with `--force` flag in production

## Aviation/Safety Domain Context

When working with this codebase, understand these aviation safety management concepts:

- **FOD (Foreign Object Debris)**: Objects that can cause damage to aircraft
- **Hazard Report**: Proactive identification of potential safety risks
- **Incident**: An actual safety event that occurred
- **Investigation**: Formal investigation process following incidents
- **Audit**: Systematic compliance and safety checks
- **Temuan (Finding)**: Issues discovered during audits
- **SMS**: Safety Management System - systematic approach to managing safety risks

## Testing Guidelines

1. **Feature Tests**: Test HTTP requests/responses and user workflows
2. **Unit Tests**: Test individual classes and methods in isolation
3. **Authentication**: Most routes require authentication - use Laravel's test helpers
4. **Database**: Use database transactions in tests for cleanup

## Common Patterns

1. **CRUD Operations**: Most features follow standard create, read, update, delete patterns
2. **Dashboard-Centric**: Application uses a central dashboard with multiple CRUD interfaces
3. **Eager Loading**: Use `with()` for relationships to avoid N+1 queries
4. **Route Model Binding**: Controllers use implicit route model binding for lookups
5. **Pagination**: Use `paginate(10)` for list views
6. **Flash Messages**: Use session flash for success/error messages

## Important Files

- `composer.json`: PHP dependencies and custom scripts
- `package.json`: Frontend dependencies and build scripts
- `.env.example`: Environment variables template
- `DEPLOYMENT.md`: Comprehensive deployment guide for Coolify
- `phpunit.xml`: PHPUnit configuration
- `tailwind.config.js`: Tailwind CSS configuration
- `vite.config.js`: Vite build configuration

## What NOT to Do

1. Don't remove or modify unrelated tests
2. Don't change database schema without migrations
3. Don't add timestamps to models that explicitly disable them
4. Don't bypass validation in controllers
5. Don't use seeders for production data (use SQL scripts as per project pattern)
6. Don't change the PostgreSQL requirement (it's a core dependency)
7. Don't modify authentication flows without understanding Laravel Breeze architecture

## Additional Context

- **Language**: Mix of English (code) and Indonesian (domain terminology, UI labels)
- **Users**: Aviation safety officers, auditors, flight operations personnel
- **Compliance**: Application may need to meet aviation regulatory requirements
- **Data Sensitivity**: Handle flight and incident data with appropriate security measures
