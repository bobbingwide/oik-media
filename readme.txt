=== oik-media ===
Contributors: bobbingwide
Donate link: https://www.oik-plugins.com/oik/oik-donate/
Tags: shortcodes, smart, lazy
Requires at least: 4.5.2
Tested up to: 5.9.3
Stable tag: 0.1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

== Description ==

Implements media related field types for oik-fields.


= Field types supported =
* media     - stored as a post ID - e.g. noderef. Displayed as the image thumbnail or filename if not an image.


= Shortcodes =

Media fields are displayable using [bw_field], [bw_fields], [bw_new] and other shortcodes that support field display.

= Action and filter hooks =

Follow this code...


  add_action( "oik_pre_theme_field", "oik_media_pre_theme_field" );
  add_action( "oik_pre_form_field", "oik_media_pre_form_field" );
  add_filter( "bw_field_validation_date", "oik_media_field_validation_date", 10, 3 );
  add_filter( "oik_query_field_types", "oik_media_query_field_types" );
  add_filter( "oik_default_meta_value_date", "oik_media_default_meta_value_date", 10, 2 );
  add_action( "oik_loaded", "oik_media_oik_loaded" );


== Installation ==
1. Upload the contents of the oik-media plugin to the `/wp-content/plugins/oik-media' directory
1. Activate the oik-media plugin through the 'Plugins' menu in WordPress

== Frequently Asked Questions ==

= What are the dependencies? = 
oik-media is an extension to the oik-fields plugin.
It is dependent upon oik-fields and oik.
You can use it with oik-types.

= When would I need to use oik-media? = 
When you want to add an attachment of a particular type to a custom post type ( CPT ) 
and rather not do it just by using Add Media.

= What other plugins support media? = 

Here are some that provide a field type with a programming interface

- WebDevStudios/CMB2 - file, file_list
- elliotcondon/acf - image, media

Here are some that use attachments in their user interface:

- easydigitaldownloads/easy-digital-downloads - download
- WooCommerce - product images and product gallery?


These plugins are directly aimed at supporting media upload:

- [Multi Image Upload](https://wordpress.org/plugins/multi-image-upload/)
- [My Upload Images](https://wordpress.org/plugins/my-upload-images/)
- [Frontend Uploader](https://wordpress.org/plugins/frontend-uploader/)


= What does it need to make it work? = 

- The meta box needs a form which will support multipart upload using AJAX
- The meta box should also have selection box from which to choose an existing attachment
- The front end also needs a form which will support multipart upload


== Screenshots ==
1. oik-media in action

== Upgrade Notice ==
= 0.1.0 =
Update to avoid the Warning message from exit_read_data()

= 0.0.1 = 
Required for bigram.co.uk

= 0.0.0 =
New plugin, available from GitHub.

== Changelog == 
= 0.1.0 = 
* Fixed: Avoid warnings from exif_read_data #4
* Changed: Add support to set/change image orientation
* Tested: With WordPress 5.9.3 and WordPress Multi Site
* Tested: With Gutenberg 13.1.0
* Tested: With PHP 8.0

= 0.0.1 = 
* Added: Form and validation functions for media [github bobbingwide oik-media issue 1]
* Added: Develop oik_media_get_file_date() [github bobbingwide oik-media issue 2]
* Added: Create the attachment as part of the validation
* Changed: Move oik_media_upload_form to oik-media.php
* Changed: Write oik_media_lazy_upload_form() to support a single file

= 0.0.0 =
* Added: New plugin

== Further reading ==
If you want to read more about the oik plugins then please visit the
[oik plugin](https://www.oik-plugins.com/oik) 
**"the oik plugin - for often included key-information"**

