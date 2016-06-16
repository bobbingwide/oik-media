<?php // (C) Copyright Bobbing Wide 2016

/**
 * Syntax: oikwp oik-media-orientation.php 
 * from oik-media/includes
 * 
 * 
 * Attempt to address Issue #3 - Auto-correct the orientation of certain images
 *
 * 
 * Step 1. Understand the current problem.
 * 
 * Image         | Orientation | Width | Height | We see in WordPress | Correct by? 
 * ------------- | ----------- | ----- | ------ | --------------------| ----------   
 * Several books | 6           | 3264 | 2448    | 90 anticlockwise 		| rotate 90 clockwise 
 * See battle    | 6           | 3264 | 2448    | 90 anticlockwise    | rotate 90 clockwise 
 *
 * Images are:
 * bigram | File name |  
 * Several books - http://www.bigram.co.uk/wp-content/uploads/2013/06/Several-books.jpg 
 * Sea battle - 
 
 * 
 * Step 2. Develop solution to perform the correction for a single file
 * Step 3. Extend to support 'all' attached images
 * 
 
 
 */
 
 /**
  * Determine the rotation to correct the orientation 
	* 
	* {@link http://stackoverflow.com/questions/7489742/php-read-exif-data-and-adjust-orientation}
	* {@link http://www.impulseadventure.com/photo/exif-orientation.html}
	
	* - The idea is to reset the orientation to 1
	* - ImageMagick's ( imagick )  rotateImage method rotates clockwise
	* - GD's imagerotate works anti-clockwise
	* - We return the rotation for ImageMagick - because it seems to make more sense
	* - * means it's flipped - horizontally or vertically
	
	* 
	* 
	* orientation | flipped | row 0 is | column 0 is | PHP constant								 | How to fix?
	* ----------- | ------- | -------- | ----------- | -----------								 | ----------------------------------
	*     0       |         | ?        | ?           | ORIENTATION_UNDEFINED			 | ?
	*     1       |         | top      | left        | ORIENTATION_TOPLEFT				 | Normal. Do nothing
	*     2*      | Yes     | top      | right       | ORIENTATION_TOPRIGHT				 | Horizontal flip
	*     3       |         | bottom   | right       | ORIENTATION_BOTTOMRIGHT		 | Rotate 180 
	* 		4*			| Yes     | bottom   | left        | ORIENTATION_BOTTOMLEFT			 | Vertical flip
	*			5*			| Yes     | left		 | top         | ORIENTATION_LEFTTOP				 | Vertical flip and rotate 90 clockwise
	* 		6       |         | right    | top         | ORIENTATION_RIGHTTOP				 | Rotate 270 anti-clockwise
	*     7*      | Yes     | right    | bottom      | ORIENTATION_RIGHTBOTTOM		 | Horizontal flip and rotate 90 clockwise
	*     8       |         | left     | bottom      | ORIENTATION_LEFTBOTTOM			 | Rotate 90 anti-clockwise 
	* 
	* Note: We don't cater for flipped images. They're quite hard to make.
 	*/
function oik_media_determine_GD_rotation( $orientation ) {
	$rotations = array( 3 => 180, 6 => 270, 8 => 90 );
	$rotate = bw_array_get( $rotations, $orientation, null ); 	
	return( $rotate );
}	

function oik_media_determine_rotation( $file ) {
	$data = exif_read_data( $file );
	$orientation = bw_array_get( $data, 'Orientation', null );
	$rotate = oik_media_determine_GD_rotation( $orientation );
	return( $rotate );
}

/**
 * Set the orientation for an image
 * 
 * 
 */
function oik_media_set_orientation( $file, $orientation ) {
	$image = new Imagick( $file );	
	var_dump( $image );
	$image->setImageOrientation( $orientation );
	$image->writeImage( $file );
}
					
 
 
if ( PHP_SAPI == "cli" )  { 

	//echo imagick::ORIENTATION_UNDEFINED . PHP_EOL;
	
	
	function report( $file, $expected ) {
		$data = exif_read_data( $file );
		//print_r( $data );
		$width = bw_array_get( $data['COMPUTED'], 'Width', null );
		$height = bw_array_get( $data['COMPUTED'], 'Height', null );
		$orientation = bw_array_get( $data, 'Orientation', null );
		$rotate = oik_media_determine_GD_rotation( $orientation );
		echo "$file $orientation $width $height $rotate" . PHP_EOL;
		if ( $orientation != $expected ) {
			echo "Error: Expected $expected" . PHP_EOL; 
		}
	}	
	
	function test_rotation( $file ) {
		$rotate = oik_media_determine_rotation( $file ); 
		if ( $rotate ) {
			$source = imagecreatefromjpeg( $file );
			$target = imagerotate( $source, $rotate, 0);
			imagejpeg( $target, "test-$rotate.jpg" );
		}
	}
	
	function test1() {
	
		report( "C:/apache/htdocs/bigram/wp-content/uploads/2013/06/Several-books.jpg", 6 );	
		report( "C:/apache/htdocs/bigram/wp-content/uploads/2013/06/Sea-battle.jpg", 6 );	
	
		report( "C:/apache/htdocs/wordpress/wp-content/plugins/oik-media/includes/orientation 1 2592x1936.jpg", 1 );
	
		report( "C:/apache/htdocs/wordpress/wp-content/plugins/oik-media/includes/orientation 3 960x960.jpg", 3 );
		//report( "C:/apache/htdocs/wordpress/wp-content/plugins/oik-media/includes/IMG_0121.jpg", 4 );		No it was 1.
		//report( "C:/apache/htdocs/wordpress/wp-content/plugins/oik-media/includes/IMG_0125.jpg", 8 );	  No it was 1.
		//report( "C:/apache/htdocs/wordpress/wp-content/plugins/oik-media/includes/IMG_0126.jpg", 8 );	 No it was still 1.
		report( "C:/apache/htdocs/wordpress/wp-content/plugins/oik-media/includes/IMG_0128.jpg", 6 );	 
		report( "C:/apache/htdocs/wordpress/wp-content/plugins/oik-media/includes/IMG_0129.jpg", 3 );	 
		report( "C:/apache/htdocs/wordpress/wp-content/plugins/oik-media/includes/orientation 8 1936x2592.jpg", 8 );	 
	
		test_rotation( "C:/apache/htdocs/bigram/wp-content/uploads/2013/06/Several-books.jpg" );	
		report( "test-270.jpg", 0 ); 
	 																			 
		test_rotation( "C:/apache/htdocs/bigram/wp-content/uploads/2013/06/Sea-battle.jpg" );	
		report( "test-270.jpg", null );	
																				 
		test_rotation( "C:/apache/htdocs/wordpress/wp-content/plugins/oik-media/includes/orientation 1 2592x1936.jpg" );
		//report( "test-270.jpg", null );
		
		test_rotation( "C:/apache/htdocs/wordpress/wp-content/plugins/oik-media/includes/orientation 3 960x960.jpg" );
		report( "test-180.jpg", null );	
	
		test_rotation( "C:/apache/htdocs/wordpress/wp-content/plugins/oik-media/includes/orientation 8 1936x2592.jpg" );
		report( "test-90.jpg", null );	
	}
	
	/**
	 * Set the orientation of the images
	 */
	function test2() {
		oik_media_set_orientation( "this-way-up-orientation-2-640x480.jpg", \Imagick::ORIENTATION_TOPRIGHT );
		oik_media_set_orientation( "this-way-up-orientation-3-640x480.jpg", \Imagick::ORIENTATION_BOTTOMRIGHT );
		oik_media_set_orientation( "this-way-up-orientation-4-640x480.jpg", \Imagick::ORIENTATION_BOTTOMLEFT );
		oik_media_set_orientation( "this-way-up-orientation-5-480x640.jpg", \Imagick::ORIENTATION_LEFTTOP );
		oik_media_set_orientation( "this-way-up-orientation-6-480x640.jpg", \Imagick::ORIENTATION_RIGHTTOP );
		oik_media_set_orientation( "this-way-up-orientation-7-480x640.jpg", \Imagick::ORIENTATION_RIGHTBOTTOM);
		oik_media_set_orientation( "this-way-up-orientation-8-480x640.jpg", \Imagick::ORIENTATION_LEFTBOTTOM );
	}
	
	/**
	 * Check the orientation of the images
	 */
	function test3() {
		report( "this-way-up-orientation-1-640x480.jpg", 1 );
		report( "this-way-up-orientation-2-640x480.jpg", 2 );
		report( "this-way-up-orientation-3-640x480.jpg", 3 );
		report( "this-way-up-orientation-4-640x480.jpg", 4 );
		report( "this-way-up-orientation-5-480x640.jpg", 5 );
		report( "this-way-up-orientation-6-480x640.jpg", 6 );
		report( "this-way-up-orientation-7-480x640.jpg", 7 );
		report( "this-way-up-orientation-8-480x640.jpg", 8 );
	}
	
	
	
	test3();
	test2();
	test3();
	
}

 

 
 
