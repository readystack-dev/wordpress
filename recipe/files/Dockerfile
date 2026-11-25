# GENERATED L-009 hermetic PHP build on Ubuntu's own packages (--network=none, SBOM+SLSA-attestation-producing).
# Pinned ubuntu:24.04; vendored app source + the deb closure (Ubuntu's PHP 8.3, its extensions, Apache, runtime debs).
FROM ubuntu:24.04@sha256:9c7f200c07e3d4a03e7249d2c16bf66a51120fb876aa2242cf31451412543289
ENV DEBIAN_FRONTEND=noninteractive APACHE_RUN_USER=www-data APACHE_RUN_GROUP=www-data
RUN --mount=type=bind,source=vendored/debs,target=/tmp/debs \
    set --; for f in /tmp/debs/*.deb; do [ -e "$f" ] && set -- "$@" "$f"; done; \
    for pass in 1 2 3 4 5; do [ $# -eq 0 ] || dpkg -i --skip-same-version "$@" >/dev/null 2>&1 && break; done; \
    dpkg --configure -a && bad= && for d in "$@"; do p=$(dpkg-deb -f "$d" Package) v=$(dpkg-deb -f "$d" Version); \
      case "$(dpkg-query -W -f='${Version} ${db:Status-Abbrev}' "$p" 2>/dev/null)" in "$v ii"*) ;; *) bad="$bad $p=$v" ;; esac; done && \
    { [ -z "$bad" ] || { echo "vendored debs not installed at their vendored version:$bad" >&2; false; }; } && \
    rm -rf /var/lib/apt/lists/* \
           /var/log/dpkg.log /var/log/alternatives.log /var/log/apt /var/cache/ldconfig/aux-cache /var/cache/fontconfig
# Apache + PHP set up as the official php:apache image sets them up (the image this product's Debian releases
# ran on), so the product's scaffold, post_copy_run and entrypoint behave as they did there.
COPY readystack-php.ini /etc/php/8.3/apache2/php.ini
COPY readystack-php.ini /etc/php/8.3/cli/php.ini
COPY readystack-mod-php.conf /etc/apache2/mods-available/php8.3.conf
COPY readystack-php.conf /etc/apache2/conf-available/readystack-php.conf
COPY apache2-foreground /usr/local/bin/apache2-foreground
RUN chmod 0755 /usr/local/bin/apache2-foreground && \
    sed -ri 's/^export ([^=]+)=(.*)$/: ${\1:=\2}\nexport \1/' /etc/apache2/envvars && \
    a2dismod -q mpm_event && a2enmod -q mpm_prefork && a2enconf -q readystack-php && \
    rm -rf /var/www/html && mkdir -p /var/www/html && chown www-data:www-data /var/www/html && chmod 1777 /var/www/html && \
    for d in /var/lock/apache2 /var/run/apache2 /var/log/apache2 /var/run/apache2/socks; do \
      rm -rf "$d" && mkdir -p "$d" && chown www-data:www-data "$d" && chmod 1777 "$d"; \
    done && \
    ln -sfT /dev/stderr /var/log/apache2/error.log && \
    ln -sfT /dev/stdout /var/log/apache2/access.log && \
    ln -sfT /dev/stdout /var/log/apache2/other_vhosts_access.log && \
    chown -R --no-dereference www-data:www-data /var/log/apache2
# Every module the product needs is loaded by the Apache AND the CLI configuration (the CLI binary reads
# each SAPI's php.ini + conf.d), or the build stops here instead of the product failing at start.
RUN for sapi in apache2 cli; do \
      PHP_INI_SCAN_DIR=/etc/php/8.3/$sapi/conf.d php -c /etc/php/8.3/$sapi/php.ini -r '$m = array_map("strtolower", array_merge(get_loaded_extensions(), get_loaded_extensions(true))); $x = array_diff(array_slice($argv, 1), $m); if ($x) { fwrite(STDERR, "missing PHP extensions: " . implode(", ", $x) . "\n"); exit(1); }' "gd" "intl" "zip" "exif" "bcmath" "mysqli" "zend opcache" "pdo_sqlite" "curl" "dom" "mbstring" "xml" "fileinfo" "sodium" || { echo "for the $sapi configuration"; exit 1; }; \
    done
ARG SOURCE_DATE_EPOCH=1795587761
RUN (getent passwd www-data >/dev/null 2>&1 || (groupadd -r www-data && useradd -r -g www-data -d /var/www/html www-data)) && \
    mkdir -p /var/www/html/wp-content /var/lib/wordpress /var/run/apache2 /var/lock/apache2 /var/log/apache2 && \
    : "${SOURCE_DATE_EPOCH:?SOURCE_DATE_EPOCH must be set for a reproducible build}" && \
    sed -ri "s/^([^:]*:[^:]*):[0-9]*:/\1:$((SOURCE_DATE_EPOCH/86400)):/" /etc/shadow && \
    rm -f /etc/passwd- /etc/shadow- /etc/group- /etc/gshadow-
COPY vendored/wordpress-src/wp-admin /var/www/html/wp-admin
COPY vendored/wordpress-src/wp-includes /var/www/html/wp-includes
COPY vendored/wordpress-src/index.php /var/www/html/index.php
COPY vendored/wordpress-src/license.txt /var/www/html/license.txt
COPY vendored/wordpress-src/readme.html /var/www/html/readme.html
COPY vendored/wordpress-src/wp-activate.php /var/www/html/wp-activate.php
COPY vendored/wordpress-src/wp-blog-header.php /var/www/html/wp-blog-header.php
COPY vendored/wordpress-src/wp-comments-post.php /var/www/html/wp-comments-post.php
COPY vendored/wordpress-src/wp-cron.php /var/www/html/wp-cron.php
COPY vendored/wordpress-src/wp-links-opml.php /var/www/html/wp-links-opml.php
COPY vendored/wordpress-src/wp-load.php /var/www/html/wp-load.php
COPY vendored/wordpress-src/wp-login.php /var/www/html/wp-login.php
COPY vendored/wordpress-src/wp-mail.php /var/www/html/wp-mail.php
COPY vendored/wordpress-src/wp-settings.php /var/www/html/wp-settings.php
COPY vendored/wordpress-src/wp-signup.php /var/www/html/wp-signup.php
COPY vendored/wordpress-src/wp-trackback.php /var/www/html/wp-trackback.php
COPY vendored/wordpress-src/xmlrpc.php /var/www/html/xmlrpc.php
COPY vendored/wordpress-src/wp-content /usr/src/wordpress/wp-content
COPY vendored/wordpress-src/readystack-vendor/sqlite-database-integration /usr/src/wordpress/sqlite-database-integration
COPY wordpress-vhost.conf /etc/apache2/sites-available/000-default.conf
COPY wordpress.htaccess /var/www/html/.htaccess
COPY wordpress.ini /etc/php/8.3/mods-available/wordpress.ini
COPY wp-config.php /var/www/html/wp-config.php
COPY wp-cli-env.php /usr/local/lib/readystack/wp-cli-env.php
COPY wp-first-start.php /usr/local/lib/readystack/wp-first-start.php
COPY wp-reset-password.php /usr/local/lib/readystack/wp-reset-password.php
COPY readystack-sqlite-health.php /usr/src/wordpress/readystack-sqlite-health.php
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod 0755 /usr/local/bin/docker-entrypoint.sh
RUN phpenmod wordpress && sed -ri 's/^Listen 80$/Listen 8080/' /etc/apache2/ports.conf && sed -ri 's/^ServerTokens .*/ServerTokens Prod/; s/^ServerSignature .*/ServerSignature Off/' /etc/apache2/conf-available/security.conf && a2enmod rewrite && printf 'ServerName localhost\n' > /etc/apache2/conf-available/servername.conf && a2enconf servername && sed -e 's#{SQLITE_IMPLEMENTATION_FOLDER_PATH}#/usr/src/wordpress/sqlite-database-integration#' -e 's#{SQLITE_PLUGIN}#sqlite-database-integration/load.php#' /usr/src/wordpress/sqlite-database-integration/db.copy > /usr/src/wordpress/db.php && grep -q SQLITE_DB_DROPIN_VERSION /usr/src/wordpress/db.php && ! grep -q '{SQLITE_' /usr/src/wordpress/db.php && chown root:root /var/www/html && chmod 0755 /var/www/html && for m in gd intl zip exif bcmath mysqli pdo_sqlite; do php -m | grep -qx "$m" || { echo "missing PHP extension $m"; exit 1; }; done && test -z "$(php -r 'exit(0);' 2>&1)"
RUN chown -R www-data:www-data /var/www/html/wp-content /var/lib/wordpress /var/run/apache2 /var/lock/apache2 /var/log/apache2
LABEL org.opencontainers.image.title="WordPress"
LABEL org.opencontainers.image.source="https://github.com/WordPress/WordPress"
LABEL org.opencontainers.image.licenses="GPL-2.0-or-later"
LABEL org.opencontainers.image.version="7.1.5-CE-ubuntu24.04-r5"
LABEL org.opencontainers.image.description="WordPress, the open-source publishing platform (GPL-2.0-or-later, PHP/Apache), with an embedded SQLite database by default."
LABEL org.opencontainers.image.vendor="ReadyStack.dev"
LABEL readystack.product="wordpress"
LABEL readystack.edition="CE"
LABEL readystack.build_method="source-rebuild-php"
LABEL readystack.license.notice="GPL-2.0-or-later: WordPress core, bundled themes, Hello Dolly and WordPress.org's SQLite Database Integration; Twenty Twenty-Five fonts OFL-1.1"
LABEL org.opencontainers.image.revision="7be93a9688cfcac7ea1c3ff00ad970ed8a47849b"
HEALTHCHECK --interval=10s --timeout=120s --start-period=60s \
  CMD curl -fsS 'http://127.0.0.1:8080/?rest_route=/&_fields=name,url' | grep -q '"url"' || exit 1
USER www-data
EXPOSE 8080
WORKDIR /var/www/html
STOPSIGNAL SIGWINCH
ENTRYPOINT ["/usr/local/bin/docker-entrypoint.sh"]
