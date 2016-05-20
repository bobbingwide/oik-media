<?php // (C) Copyright Bobbing Wide 2016

/**
 * Display the file upload
 *
 * Note: when the form includes file upload the form tag needs enctype="multipart/form-data"
 *
 * '<input type="file" value="" name=files[] id=$name multiple="multiple"';
 */

function oik_media_lazy_upload_form( $name, $value ) {

	$args = array( "#type" => "file" );

	bw_textfield( $name, null, null, $value, null, null, $args );	
	
}


/* 
 * Captured from frontend-uploader 
 

<form action="http://qw/bigram/wp-admin/admin-ajax.php" method="post" id="ugc-media-form" class="validate fu-upload-form" 
enctype="multipart/form-data" novalidate="novalidate">


<div class="ugc-inner-wrapper">

<h2>Submit bigram</h2>

<p><input type="hidden" value="1932" name="post_ID" id="ugc-input-post_id">
</p><div class="ugc-input-wrapper"><label for="ug_post_title">Title</label><input type="text" value="" name="post_title" id="ug_post_title" class="required" aria-required="true"></div>
<div class="ugc-input-wrapper"><label for="ug_content">Post content or file description</label><textarea name="post_content" id="ug_content" class="required" aria-required="true"></textarea></div>
<div class="ugc-input-wrapper"><label for="ug_photo">Your Media Files</label><input type="file" value="" name="files[]" id="ug_photo" multiple="multiple"></div>
<div class="ugc-input-wrapper"><label for="ug_submit_button"></label><input type="submit" value="Submit" name="" id="ug_submit_button" class="btn"></div>
<p><input type="hidden" value="upload_ugc" name="action" id="ugc-input-action"><input type="hidden" value="image" name="form_layout" id="ugc-input-form_layout">		<input type="hidden" id="fu_nonce" name="fu_nonce" value="468d6ea3c6"><input type="hidden" name="_wp_http_referer" value="/bigram/submit-bigram/">		<input type="hidden" name="ff" value="92b6cbfa6120e13ff1654e28cef2a271">
		<input type="hidden" name="form_post_id" value="1932"></p>
<div class="clear"></div>
<p></p></div>
<p></p></form>

*/
