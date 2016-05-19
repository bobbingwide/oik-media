<?php // (C) Copyright Bobbing Wide 2016

/** 
 * Implement bw_form_field_ hook for "media"
 *
 * Here we can do a variety of things:
 * 
 * 1. Accept a post ID
 * 2. Display a select list of media attachments - for the post ID
 * 3. Display a select2 list - for the post ID
 * 4. Display the Add Image button which provides the Select Image dialog (a la ACF)
 * 5. Display the form provided by frontend-uploader's [input type="file"]
 * 6. Something else 
 *
 */
if ( !function_exists( "bw_form_field_media" ) ) { 
function bw_form_field_media( $name, $type, $title, $value, $args ) {
	bw_trace2();
	bw_backtrace();
  $args['#length'] = bw_array_get( $args, '#length', 10 );
  //bw_jquery( "#${name}", "datepicker", bw_jkv( "dateFormat : 'yy-mm-dd', changeMonth: true, changeYear: true" ) );
  bw_form_field_( $name, $type, $title, $value, $args ); 
	
	stag( "tr" );
	stag( "td" );
	
	if ( $value ) {
		$data = array( "#field_type" => $type
							   , "#label" => $title
								 , "#args" => $args 
								 ); 
		//bw_theme_field_media( $name, $value, $data );
		bw_theme_field( $name, $value, $data );
		//gob();
	} else {
	}
	oik_media_upload_form( $name, $value );
	oik_media_select_form( $name, $value );
	etag( "td" );
	etag( "tr" );
}
}

/**
 * Theme a field of type 'media'
 *
 * @TODO Should we be using table data in the front end? 
 * 
 * 
 * @param string $key - the field name
 * @param string $value - the field value - expected to be in ccyy-mm-dd  rather than a unix timestamp
 * @param string $field - optional
 */
if ( !function_exists( "bw_theme_field_media" ) ) {
function bw_theme_field_media( $key, $value, $field=null ) {
  $media = bw_array_get( $value, 0, $value );
  if ( $media ) {
		e( "Media" );
		etag( "td" );
		stag( "td" );
		//e( "$media" );
		$thumbnail = bw_thumbnail( $media, null, true );
		if ( $thumbnail ) {
			bw_link_thumbnail( $thumbnail, $media );
		} else {
			e( "No thumbnail for $media" );
		}
  } else {
		e( "No media selected" );
	} 
}
}

/**
 * Display a form to upload a media file
 * 
 * We need this for the front end!
  
 */
function oik_media_upload_form( $name, $value=null ) {
	e( "oik-media upload form for $name" );
}

/**
 * Display a select list to choose the media item
 *
 * 
 */
function oik_media_select_form( $name, $value=null ) {
	$args = array( "#type" => array( "attachment", "dummy" )
							 , "#optional" => true
							 , "post_status" => "inherit"
							 , "numberposts" => -1
							 , "exclude" => -1
							 );

	bw_form_field_noderef( $name, "media", "Select media", $value, $args ); 

}


