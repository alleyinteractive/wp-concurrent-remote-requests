<?php
/**
 * plugin_name Test Bootstrap
 */

if ( ! file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
	echo 'You must run `composer install` from the tests directory to run the tests.';

	exit( 1 );
}

require_once __DIR__ . '/vendor/autoload.php';

/**
 * Visit {@see https://mantle.alley.co/testing/test-framework.html} to learn more.
 */
\Mantle\Testing\manager()
	->with_sqlite()
	->loaded( function () {
		if ( ! file_exists( __DIR__ . '/../vendor/autoload.php' ) ) {
			echo 'You must run `composer install` from the project root to run the tests.';

			exit( 1 );
		}

		require_once __DIR__ . '/../vendor/autoload.php';
	} )
	->install();
