#!/bin/sh
set -e

# Wait for database to be ready (optional, but recommended)
if [ -n "$DB_HOST" ]; then
    echo "Waiting for database to be ready..."
    until pg_isready -h "$DB_HOST" -p "${DB_PORT:-5432}" -U "$DB_USERNAME"; do
        sleep 1
    done
    echo "Database is ready!"
fi

# Run schema.sql if it exists and database is configured
if [ -f /var/www/html/database/schema.sql ] && [ -n "$DB_HOST" ]; then
    echo "Running schema.sql..."
    PGPASSWORD="$DB_PASSWORD" psql -h "$DB_HOST" -p "${DB_PORT:-5432}" -U "$DB_USERNAME" -d "$DB_DATABASE" -f /var/www/html/database/schema.sql
    echo "Schema.sql executed successfully!"
fi

# Run Laravel migrations (optional, if you want to use migrations too)
if [ -n "$DB_HOST" ]; then
    echo "Running Laravel migrations..."
    php artisan migrate --force || true
fi

# Start the application
exec "$@"

