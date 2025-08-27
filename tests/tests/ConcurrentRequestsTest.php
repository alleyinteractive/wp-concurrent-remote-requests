<?php
namespace Alley\WP\Concurrent_Remote_Requests\Tests;

use Mantle\Testkit\TestCase;

/**
 * Extracted tests from WP_HTTP_UnitTestCase.
 */
class ConcurrentRequestsTest extends TestCase {
	public $redirection_script = 'http://api.wordpress.org/core/tests/1.0/redirection.php';

	/**
	 * Allows tests to be skipped if the HTTP request times out.
	 *
	 * @param array|WP_Error $response HTTP response.
	 */
	public function skipTestOnTimeout( $response ): void {
		if ( ! is_wp_error( $response ) ) {
			return;
		}
		if ( 'connect() timed out!' === $response->get_error_message() ) {
			$this->markTestSkipped( 'HTTP timeout' );
		}

		if ( false !== strpos( $response->get_error_message(), 'timed out after' ) ) {
			$this->markTestSkipped( 'HTTP timeout' );
		}

		if ( 0 === strpos( $response->get_error_message(), 'stream_socket_client(): unable to connect to tcp://s.w.org:80' ) ) {
			$this->markTestSkipped( 'HTTP timeout' );
		}
	}

	/**
	 * Test parallel requests.
	 *
	 * @ticket 33055
	 * @covers ::wp_remote_request
	 */
	public function test_parallel_request() {
		$responses = \Alley\WP\Concurrent_Remote_Requests\wp_remote_request(
			array(
				'https://wordpress.org/',
				array(
					$this->redirection_script . '?code=301&rt=' . 5,
					array(
						'method'      => 'POST',
						'redirection' => 0,
					),
				),
			)
		);

		list( $request_wp, $request_redirect ) = $responses;

		$this->skipTestOnTimeout( $request_wp );
		$this->skipTestOnTimeout( $request_redirect );

		$this->assertNotWPError( $request_wp );
		$this->assertNotWPError( $request_redirect );

		$this->assertSame( 200, wp_remote_retrieve_response_code( $request_wp ) );
		$this->assertSame( 301, wp_remote_retrieve_response_code( $request_redirect ) );
	}

	/**
	 * Test parallel requests with short circuiting.
	 *
	 * @ticket 33055
	 * @covers ::wp_remote_request
	 */
	public function test_parallel_request_short_circuit() {
		add_filter(
			'pre_http_request',
			function ( $pre, $args, $url ) {
				if ( 'https://login.wordpress.org/wp-login.php' === $url ) {
					return array(
						'response' => array(
							'code' => 418,
						),
					);
				}

				return $pre;
			},
			10,
			3
		);

		$responses = \Alley\WP\Concurrent_Remote_Requests\wp_remote_request(
			array(
				'https://wordpress.org/',
				'https://login.wordpress.org/wp-login.php',
			)
		);

		list( $request_wp, $request_login ) = $responses;

		$this->skipTestOnTimeout( $request_wp );
		$this->skipTestOnTimeout( $request_login );

		$this->assertNotWPError( $request_wp );
		$this->assertNotWPError( $request_login );

		$this->assertSame( 200, wp_remote_retrieve_response_code( $request_wp ) );
		$this->assertSame( 418, wp_remote_retrieve_response_code( $request_login ) );
	}
}
