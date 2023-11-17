<?php
/**
 * @package oik-media
 * @copyright (C) Copyright Bobbing Wide 2023
 *
 * Unit tests to load all the files for PHP 8.2, except batch ones
 */

class Tests_oik_media_orientation extends BW_UnitTestCase {

	/**
	 * set up logic
	 *
	 * - ensure any database updates are rolled back
	 * - we need oik-googlemap to load the functions we're testing
	 */
	function setUp(): void {
		parent::setUp();

	}

	function test_oik_media_orientation() {

		// There's no need for any tests as the file isn't used in oik-media
		$this->assertTrue( true );
	}

}

