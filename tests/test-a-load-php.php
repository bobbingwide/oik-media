<?php

/**
 * @package oik-media
 * @copyright (C) Copyright Bobbing Wide 2023
 *
 * Unit tests to load all the files for PHP 8.2, except batch ones
 */

class Tests_load_libs extends BW_UnitTestCase
{

	/**
	 * set up logic
	 *
	 * - ensure any database updates are rolled back
	 * - we need oik-googlemap to load the functions we're testing
	 */
	function setUp(): void
	{
		parent::setUp();

	}

	function test_load_includes() {
		oik_require( 'includes/oik-media.inc', 'oik-media');
		$exclusions = [ 'includes/oik-media-orientation.php' ];
		$this->load_dir_files( 'includes', $exclusions );
		$this->assertTrue( true );
	}

	function load_dir_files( $dir, $excludes=[] ) {
		$files = glob( "$dir/*.php");
		//print_r( $files );

		foreach ( $files as $file ) {
			if ( !in_array( $file, $excludes ) ) {
				//echo "Loading $file";
				oik_require( $file, 'oik-media');
			}
		}
	}

	/**
	 * Test that the plugin is loaded
	 */
	function test_load_plugin() {
		oik_require( 'oik-media.php', 'oik-media');
		$this->assertTrue( true );
	}

}