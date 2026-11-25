#!/bin/sh
set -e
cd /var/www/html
SRC=/usr/src/wordpress
DATA=/var/lib/wordpress
# The address people open: read by wp-config.php on every request and by the first-start install.
export WORDPRESS_URL="${WORDPRESS_URL:-http://localhost:8080}"

# An empty wp-content volume gets the bundled themes and plugins. Existing files are never overwritten.
if [ ! -e wp-content/index.php ]; then
  cp -Rn "$SRC/wp-content/." wp-content/
  echo "wordpress: copied the bundled themes and plugins into wp-content"
fi

if [ -z "${WORDPRESS_DB_HOST:-}" ]; then
  # Embedded SQLite (the default): WordPress.org's SQLite Database Integration drop-in, its code kept in the image.
  if [ -e wp-content/db.php ] && ! grep -q SQLITE_DB_DROPIN_VERSION wp-content/db.php; then
    echo "wordpress: wp-content/db.php is another plugin's database drop-in, but the default SQLite database needs the SQLite drop-in there. Remove that file, or set WORDPRESS_DB_HOST to use MySQL or MariaDB." >&2
    exit 1
  fi
  cmp -s "$SRC/db.php" wp-content/db.php || cp "$SRC/db.php" wp-content/db.php
  mkdir -p wp-content/mu-plugins
  cmp -s "$SRC/readystack-sqlite-health.php" wp-content/mu-plugins/readystack-sqlite-health.php \
    || cp "$SRC/readystack-sqlite-health.php" wp-content/mu-plugins/readystack-sqlite-health.php
else
  if [ -z "${WORDPRESS_DB_PASSWORD:-}" ]; then
    echo "wordpress: WORDPRESS_DB_HOST is set, so WORDPRESS_DB_PASSWORD is required" >&2
    exit 1
  fi
  # MySQL/MariaDB: take out the SQLite drop-in an earlier SQLite start put here (another plugin's drop-in stays).
  if [ -e wp-content/db.php ] && grep -q SQLITE_DB_DROPIN_VERSION wp-content/db.php; then
    rm -f wp-content/db.php wp-content/mu-plugins/readystack-sqlite-health.php
  fi
fi

# Keys and salts, then the non-interactive install when the database holds no WordPress yet. A MySQL/MariaDB
# server may still be starting, so that case is retried for about a minute; SQLite fails at once.
i=0
until php /usr/local/lib/readystack/wp-first-start.php; do
  i=$((i+1))
  if [ -z "${WORDPRESS_DB_HOST:-}" ] || [ "$i" -ge 30 ]; then
    echo "wordpress: first-start setup failed; not starting Apache" >&2
    exit 1
  fi
  echo "wordpress: database not ready, retrying in 2s ($i/30)"
  sleep 2
done
exec apache2-foreground
