<?php
/**
Plugin Name: oik-media
Depends: oik base plugin, oik fields
Plugin URI: http://www.oik-plugins.com/oik-plugins/oik-media
Description: Implements date based field types for oik-fields 
Version: 0.1.0
Author: bobbingwide
Author URI: http://www.bobbingwide.com
License: GPL2

    Copyright 2016-2022 Bobbing Wide (email : herb@bobbingwide.com )

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License version 2,
    as published by the Free Software Foundation.

    You may NOT assume that you can use any other version of the GPL.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    The license for this software can likely be found here:
    http://www.gnu.org/licenses/gpl-2.0.html

*/

oik_media_plugin_loaded(); 

/**
 * Perform initialisation when plugin file loaded 
 *
 * 
 */
function oik_media_plugin_loaded() {
	add_action( "oik_pre_theme_field", "oik_media_pre_theme_field" );
	add_action( "oik_pre_form_field", "oik_media_pre_form_field" );
	add_filter( "oik_query_field_types", "oik_media_query_field_types" );
	add_action( "oik_loaded", "oik_media_oik_loaded" );
	add_filter( "bw_form_functions", "oik_media_bw_form_functions" );
	add_filter( "bw_validate_functions", "oik_media_bw_validate_functions" );
}

/**
 * Implements action "oik_pre_theme_field"
 *
 * The media field is only required when we intend to actually display the field
 *
 */
function oik_media_pre_theme_field() {
	oik_require( "includes/oik-media.inc", "oik-media" );
} 

/**
 * Implements action "oik_pre_form_field"
 *
 * The media field is only required when we intend to actually to set a new value for the field
 *
 */
function oik_media_pre_form_field() {
	oik_require( "includes/oik-media.inc", "oik-media" );
} 

/**
 * Implement "oik_query_field_types" for oik-media
 *
 * Type   | Meaning																			 | Note
 * ------ | -------------------------------------------- | ------ 
 * media  | the generic term to represent any attachment | 
 * file   | subset of attachments which are not images   | future use
 * image  | subset of attachments which are images       | future use
 * 
 */
function oik_media_query_field_types( $field_types ) {
	$field_types['media'] = __( "Media", 'oik-media' ); 
	//$field_types['file'] = __( "File", 'oik-media' ); 
	//$field_types['image'] = __( "Image", 'oik-media' ); 
	return( $field_types );
}

/**
 * Implement "oik_loaded" action for oik-media
 *
 */
function oik_media_oik_loaded() {
}

/**
 * Implement "bw_form_functions" for oik-media
 * 
 * @param array $fields
 * @return array with our form functions
 */  
function oik_media_bw_form_functions( $fields ) {	
	$fields['I'] = "oik_media_upload_form";
	$fields['F'] = "oik_media_upload_form";
	return( $fields );
}

/**
 * Implement "bw_validate_functions" for oik-media
 *
 * @param array $fields 
 * @return array with our validation functions
 */
function oik_media_bw_validate_functions( $fields ) {
	$fields['I'] = "oik_media_validate_media";
	$fields['F'] = "oik_media_validate_media";
	return( $fields );
}

/**
 * Display a form to upload a media file
 * 
 * We need this for the front end!
 *
 * @param string $abbrev - the media type
 * @param array $fields -  
 */
function oik_media_upload_form( $abbrev, $fields ) {
	oik_require( "includes/oik-media-upload-form.php", "oik-media" );
	oik_media_lazy_upload_form( $abbrev, $fields );
}

/** 
 * Validate media file(s)
 *
 * At the end of processing the attachment should have been created
 * and the value of the attachment's post ID is stored in $_POST['_thumbnail_id'].
 * Currently we rely on other routines to implement the logic to insert the attachment.
 * 
 *
 * @param string $format 'I' or 'F'
 * @param array $fields - field names
 * @param array $validated - validation status for fields
 */
function oik_media_validate_media( $format, $fields, &$validated ) {
	//bw_trace2();
	bw_backtrace();
	bw_trace2( $_FILES, "_FILES", true, BW_TRACE_DEBUG );
	if ( !empty( $_FILES ) ) {
		oik_require( "includes/oik-media-validate-media.php", "oik-media" );
		oik_media_lazy_validate_media( $format, $fields, $validated );
	}
}

