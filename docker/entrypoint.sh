#!/usr/bin/env bash
# Start-up for the Leeroy Systems container:
#  1. point Apache at $PORT (Render sets it),
#  2. put WordPress in place and write wp-config.php,
#  3. install WordPress + activate the theme on first boot,
#  4. start Apache, while the theme builds pages, news and gallery in the background.
set -euo pipefail

WEBROOT=/var/www/html
PORT="${PORT:-10000}"
SITE_URL="${SITE_URL:-${RENDER_EXTERNAL_URL:-http://localhost:${PORT}}}"
SITE_URL="${SITE_URL%/}"
ADMIN_USER="${ADMIN_USER:-admin}"
ADMIN_EMAIL="${ADMIN_EMAIL:-info@leeroysystems.co.bw}"
wp() { command wp --allow-root --path="$WEBROOT" "$@"; }

# 1. Apache listens on $PORT.
sed -ri "s/^Listen [0-9]+/Listen ${PORT}/" /etc/apache2/ports.conf
sed -ri "s/<VirtualHost \*:[0-9]+>/<VirtualHost *:${PORT}>/" /etc/apache2/sites-available/000-default.conf
echo "ServerName localhost" > /etc/apache2/conf-available/servername.conf
a2enconf -q servername >/dev/null

# 2. WordPress files (the image keeps a pristine copy in /usr/src/wordpress).
if [ ! -f "$WEBROOT/wp-settings.php" ]; then
	echo "[leeroy] Copying WordPress into place…"
	cp -a /usr/src/wordpress/. "$WEBROOT/"
fi
# Always refresh the theme, SQLite drop-in and mu-plugins from the image.
rm -rf "$WEBROOT/wp-content/themes/leeroy-systems"
cp -a /usr/src/wordpress/wp-content/themes/leeroy-systems "$WEBROOT/wp-content/themes/"
cp -a /usr/src/wordpress/wp-content/plugins/sqlite-database-integration "$WEBROOT/wp-content/plugins/" 2>/dev/null || true
cp /usr/src/wordpress/wp-content/db.php "$WEBROOT/wp-content/db.php"
mkdir -p "$WEBROOT/wp-content/mu-plugins" "$WEBROOT/wp-content/database" "$WEBROOT/wp-content/uploads"
cp -a /usr/src/wordpress/wp-content/mu-plugins/. "$WEBROOT/wp-content/mu-plugins/"

if [ ! -f "$WEBROOT/wp-config.php" ]; then
	echo "[leeroy] Writing wp-config.php…"
	# DB_* values are unused with SQLite but WordPress expects the constants.
	wp config create --dbname=wordpress --dbuser=unused --dbpass=unused --dbhost=localhost --skip-check --quiet --extra-php <<'PHP'
// Site address comes from the environment (Render sets RENDER_EXTERNAL_URL).
$leeroy_url = rtrim( getenv( 'SITE_URL' ) ?: ( getenv( 'RENDER_EXTERNAL_URL' ) ?: '' ), '/' );
if ( $leeroy_url ) {
	define( 'WP_HOME', $leeroy_url );
	define( 'WP_SITEURL', $leeroy_url );
}
// Render terminates HTTPS at its proxy.
if ( isset( $_SERVER['HTTP_X_FORWARDED_PROTO'] ) && 'https' === $_SERVER['HTTP_X_FORWARDED_PROTO'] ) {
	$_SERVER['HTTPS'] = 'on';
}
define( 'DB_DIR', __DIR__ . '/wp-content/database/' );
define( 'DB_FILE', '.ht.sqlite' );
define( 'DISALLOW_FILE_EDIT', true );
define( 'WP_DEBUG', false );
// Render's proxy sits in front of Apache: use X-Forwarded-For for form rate limiting.
define( 'LEEROY_TRUST_PROXY', true );
// Optional: reCAPTCHA v2 and the Facebook importer token, from env vars.
foreach ( [ 'LEEROY_RECAPTCHA_SITEKEY', 'LEEROY_RECAPTCHA_SECRET', 'LEEROY_FB_ACCESS_TOKEN', 'LEEROY_FB_IMPORT_STATUS' ] as $leeroy_const ) {
	if ( getenv( $leeroy_const ) ) {
		define( $leeroy_const, getenv( $leeroy_const ) );
	}
}
PHP
fi

# Pretty permalinks.
cat > "$WEBROOT/.htaccess" <<'HTACCESS'
# BEGIN WordPress
<IfModule mod_rewrite.c>
RewriteEngine On
RewriteBase /
RewriteRule ^index\.php$ - [L]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule . /index.php [L]
</IfModule>
# END WordPress
HTACCESS

# 3. First boot: install WordPress and activate the theme.
if ! wp core is-installed --url="$SITE_URL" >/dev/null 2>&1; then
	echo "[leeroy] Installing WordPress at $SITE_URL…"
	GENERATED=""
	if [ -z "${ADMIN_PASSWORD:-}" ]; then
		ADMIN_PASSWORD="$(head -c 18 /dev/urandom | base64 | tr -d '/+=' | head -c 20)"
		GENERATED=1
	fi
	wp core install --url="$SITE_URL" --title="Leeroy Systems" --admin_user="$ADMIN_USER" \
		--admin_password="$ADMIN_PASSWORD" --admin_email="$ADMIN_EMAIL" --skip-email --quiet
	if [ -n "$GENERATED" ]; then
		echo "[leeroy] Generated admin password for '$ADMIN_USER': $ADMIN_PASSWORD (set ADMIN_PASSWORD to choose your own)"
	fi
	wp option update blogdescription "Futuristic Solutions for Smart Water" --quiet
	wp option update timezone_string "Africa/Gaborone" --quiet
	wp option update permalink_structure "/%postname%/" --quiet
	wp option update blog_public 0 --quiet   # temporary site: ask search engines not to index
	wp post delete 1 --force --quiet 2>/dev/null || true   # WordPress's "Hello world!" sample post
	wp post delete 2 --force --quiet 2>/dev/null || true   # WordPress's "Sample Page"
	wp theme activate leeroy-systems --quiet
fi

chown -R www-data:www-data "$WEBROOT/wp-content"

# 4. Let the theme build its pages, news stories and gallery albums. These run
#    as WordPress cron jobs; drive them from here so they finish promptly
#    without depending on visitor traffic.
(
	sleep 5
	for _ in $(seq 1 60); do
		su -s /bin/bash www-data -c "wp --path=$WEBROOT --url=$SITE_URL cron event run --due-now --quiet" >/dev/null 2>&1 || true
		DONE="$(su -s /bin/bash www-data -c "wp --path=$WEBROOT --url=$SITE_URL option get leeroy_gallery_seed_version" 2>/dev/null || true)"
		[ "$DONE" = "1" ] && { echo "[leeroy] Pages, news and gallery are ready."; break; }
		sleep 4
	done
) &

echo "[leeroy] Starting Apache on port $PORT ($SITE_URL)"
exec "$@"
