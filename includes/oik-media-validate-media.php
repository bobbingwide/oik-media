<?php // (C) Copyright Bobbing Wide 2016

/**
 * Validate the uploaded media files 
 *
 * Notes: 
 * - Currently we only expect there to be one file.
 * - We don't care about the name
 * - But we do require a file to have been uploaded in order to create the attachment
 * 
 * @param string $format
 * @param array $fields
 * @param array $validated
 */
function oik_media_lazy_validate_media( $format, $fields, &$validated ) {
	$files = $_FILES;
	foreach ( $_FILES as $key => $file ) {
		bw_trace2( $file );
		$error = bw_array_get( $file, "error", 0 );
		if ( !$error ) {
			oik_media_create_attachment( $key, $file, $fields, $validated );
			// $validated['files'][$id ] = $file;
		}
	}
}

/**
 * Create an attachment
 * 
 * Remember, this is part of the [bw_new] shortcode which is going to insert a post of a particular type.
 * If we're creating an attachment then we won't need to perform this insertion twice.
 * For other post types, then we probably need to attach the attachment to the post, possibly setting it as the featured image.
 *
 * @param string $key - the field name for this file (probably 'file' )
 * @param array $file
 * @param array $fields
 * @param array $validated
 */
function oik_media_create_attachment( $key, $file, $fields, &$validated ) {
	do_action_ref_array( "oik-media-create-attachment", array( $key, $file, $fields, &$validated ) );
	bw_trace2( $validated, "validated", true );
} 

/**
 * 
 
 * The $_FILES array may contain a multiple structure if the field is named as an array e.g. 'files[]' 
 
      [files] => Array
        (
            [name] => Array
                (
                    [0] => IMG_0004.JPG
                    [1] => IMG_0007.JPG
                    [2] => IMG_0008.JPG
                )

            [type] => Array
                (
                    [0] => image/jpeg
                    [1] => image/jpeg
                    [2] => image/jpeg
                )

            [tmp_name] => Array
                (
                    [0] => C:\Windows\Temp\php650E.tmp
                    [1] => C:\Windows\Temp\php653E.tmp
                    [2] => C:\Windows\Temp\php658D.tmp
                )

            [error] => Array
                (
                    [0] => 0
                    [1] => 0
                    [2] => 0
                )

            [size] => Array
                (
                    [0] => 918813
                    [1] => 868899
                    [2] => 796444
                )

        )
 *
 * 
 * For routines to transform a multiple array to the accepted format
 * {@see http://php.net/manual/en/reserved.variables.files.php}
 * 
 * 
 * else it will be a simple associative array keyed by the field name(s) 
 * 
 * [files] 
 * 
 */

