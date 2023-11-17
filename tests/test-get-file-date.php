<?php
/**
 * @package oik-media
 * @copyright (C) Copyright Bobbing Wide 2023
 *
 * Unit tests to load all the files for PHP 8.2, except batch ones
 */

class Tests_get_file_date extends BW_UnitTestCase {

	/**
	 * set up logic
	 *
	 * - ensure any database updates are rolled back
	 * - we need oik-googlemap to load the functions we're testing
	 */
	function setUp(): void {
		parent::setUp();

	}

	function test_get_file_date() {
		$date = oik_media_get_file_date( "C:/apache/htdocs/wordpress/wp-content/plugins/oik-media/assets/oik-media-banner-772x250.jpg" );
		$this->assertEquals( '2022-05-12 19:36:44', $date );
	}

}

