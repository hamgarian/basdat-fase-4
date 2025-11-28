#!/bin/sh
set -e

# Wait for database to be ready (optional, but recommended)
if [ -n "$DB_HOST" ]; then
    echo "Waiting for database to be ready at $DB_HOST:${DB_PORT:-5432}..."
    # Try to connect with a timeout (max 30 seconds)
    timeout=30
    elapsed=0
    while [ $elapsed -lt $timeout ]; do
        if pg_isready -h "$DB_HOST" -p "${DB_PORT:-5432}" -U "$DB_USERNAME" >/dev/null 2>&1; then
            echo "Database is ready!"
            break
        fi
        echo "Waiting for database... ($elapsed/$timeout seconds)"
        sleep 2
        elapsed=$((elapsed + 2))
    done
    
    if [ $elapsed -ge $timeout ]; then
        echo "Warning: Database connection timeout. Continuing anyway..."
        echo "Make sure DB_HOST is set to the correct database service name (not 127.0.0.1)"
    fi
fi

# Run schema.sql if it exists and database is configured
# Only run if tables don't exist yet
if [ -f /var/www/html/database/schema.sql ] && [ -n "$DB_HOST" ]; then
    echo "Checking if database tables already exist..."
    TABLE_EXISTS=$(PGPASSWORD="$DB_PASSWORD" psql -h "$DB_HOST" -p "${DB_PORT:-5432}" -U "$DB_USERNAME" -d "$DB_DATABASE" -tAc "SELECT EXISTS (SELECT FROM information_schema.tables WHERE table_schema = 'public' AND table_name = 'user');" 2>/dev/null || echo "false")
    
    if [ "$TABLE_EXISTS" = "t" ] || [ "$TABLE_EXISTS" = "true" ]; then
        echo "Database tables already exist. Skipping schema.sql execution."
    else
        echo "Database tables not found. Running schema.sql..."
        PGPASSWORD="$DB_PASSWORD" psql -h "$DB_HOST" -p "${DB_PORT:-5432}" -U "$DB_USERNAME" -d "$DB_DATABASE" -f /var/www/html/database/schema.sql
        echo "Schema.sql executed successfully!"
    fi
fi

# Run Laravel migrations (optional, if you want to use migrations too)
if [ -n "$DB_HOST" ]; then
    echo "Running Laravel migrations..."
    php artisan migrate --force || true
fi

# Start the application
exec "$@"

