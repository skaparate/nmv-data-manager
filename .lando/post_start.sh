#!/bin/bash
# Install script for WordPress and
# the required library files for running the tests.

echo 'Executing post start script'

if [ -z "$WP_VERSION" ]; then
    echo 'No environment provided; exitting'
    exit
fi

_WPDIR="$LANDO_WEBROOT"
_WPURL="${LANDO_APP_NAME}.${LANDO_DOMAIN}"

install_wordpress() {
    echo 'Setting up WordPress'
    if [ ! -f "$_WPDIR/wp-config.php" ]; then
        wp core download --version=$WP_VERSION --path="$_WPDIR" --force
        wp config create --dbname=$DB_NAME --dbuser=$DB_USER --dbpass="$DB_PASS" --dbhost="$DB_HOST" --path="$_WPDIR"
    fi

    if ! $(wp core is-installed); then
        echo 'WordPress not installed; installing'
        wp core install --path="$_WPDIR" --url=$_WPURL --title="Development Site" --admin_user="$WP_USER" --admin_password="$WP_USER_PASS" --admin_email="$WP_USER_EMAIL"
    fi
}

install_test_libs() {
    if [ -f "$WP_TEST_LIBS_DIR/wp-tests-config.php" ]; then
        echo 'Test libs configuration present -- skipping'
        return
    fi

    echo 'Installing libraries for integration tests'
    WPSVNURL=https://develop.svn.wordpress.org/tags/$WP_VERSION
    svn co --quiet $WPSVNURL/tests/phpunit/includes/ "${WP_TEST_LIBS_DIR}"/includes
    svn co --quiet $WPSVNURL/tests/phpunit/data/ "${WP_TEST_LIBS_DIR}"/data

    if [ ! -f "$WP_TEST_LIBS_DIR"/wp-tests-config.php ]; then
        curl -o "$WP_TEST_LIBS_DIR"/wp-tests-config.php $WPSVNURL/wp-tests-config-sample.php
        sed -i.bak "s:dirname( __FILE__ ) . '/src/':'$WP_TEST_INSTALL':" "$WP_TEST_LIBS_DIR"/wp-tests-config.php
        sed -i.bak "s/youremptytestdbnamehere/$DB_NAME/" "$WP_TEST_LIBS_DIR"/wp-tests-config.php
        sed -i.bak "s/yourusernamehere/$DB_USER/" "$WP_TEST_LIBS_DIR"/wp-tests-config.php
        sed -i.bak "s/yourpasswordhere/$DB_PASS/" "$WP_TEST_LIBS_DIR"/wp-tests-config.php
        sed -i.bak "s|localhost|${DB_HOST}|" "$WP_TEST_LIBS_DIR"/wp-tests-config.php
    fi
}

install_wordpress
install_test_libs
