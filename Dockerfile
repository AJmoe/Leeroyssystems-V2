# Leeroy Systems website — WordPress + the leeroy-systems theme in one container.
#
# Uses SQLite (WordPress's official "SQLite Database Integration" plugin) so
# no separate MySQL server is needed — ideal for a temporary Render deploy.
# On first start the container installs WordPress, activates the theme and
# lets the theme build its pages, news stories and gallery automatically.

FROM wordpress:php8.2-apache

# WP-CLI for the automated install, plus unzip for the SQLite plugin.
RUN apt-get update \
	&& apt-get install -y --no-install-recommends unzip less \
	&& rm -rf /var/lib/apt/lists/* \
	&& curl -fsSL -o /usr/local/bin/wp https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar \
	&& chmod +x /usr/local/bin/wp

# SQLite database integration (official WordPress plugin) + its db.php drop-in.
RUN curl -fsSL -o /tmp/sqlite.zip https://downloads.wordpress.org/plugin/sqlite-database-integration.zip \
	&& unzip -q /tmp/sqlite.zip -d /usr/src/wordpress/wp-content/plugins/ \
	&& rm /tmp/sqlite.zip \
	&& sed -e 's#{SQLITE_IMPLEMENTATION_FOLDER_PATH}#/var/www/html/wp-content/plugins/sqlite-database-integration#' \
	       -e 's#{SQLITE_PLUGIN}#sqlite-database-integration/load.php#' \
	       /usr/src/wordpress/wp-content/plugins/sqlite-database-integration/db.copy \
	       > /usr/src/wordpress/wp-content/db.php

# PHP limits: CV uploads (5 MB) and photo processing.
COPY docker/php.ini /usr/local/etc/php/conf.d/leeroy.ini

# Optional SMTP for the contact/careers forms (configured by env vars).
COPY docker/mu-plugins/ /usr/src/wordpress/wp-content/mu-plugins/

# The theme.
COPY leeroy-systems/ /usr/src/wordpress/wp-content/themes/leeroy-systems/

COPY docker/entrypoint.sh /usr/local/bin/leeroy-entrypoint
RUN chmod +x /usr/local/bin/leeroy-entrypoint

# Render routes traffic to $PORT (10000 by default); Apache is set to it at start-up.
ENV PORT=10000
EXPOSE 10000

ENTRYPOINT ["leeroy-entrypoint"]
CMD ["apache2-foreground"]
