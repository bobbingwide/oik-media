<?php
/**
 * @package oik-media
 * @copyright (C) Copyright Bobbing Wide 2016, 2022, 2023
 */

/**
 * Obtains the date from the file 
 *
 * @param string $file fully qualified file name
 * @return string file date in the required format for wp_insert_post
 */
function oik_media_get_file_date( $file ) {
    // Avoid Warnings when the file extension is not for an image.
	$data = @exif_read_data( $file );
	$filedatetime = oik_media_extract_field( $data, "DateTime" );
	if ( $filedatetime ) {
		$filedatetimeoriginal = oik_media_extract_field( $data, "DateTimeOriginal" );
		if ( $filedatetimeoriginal && $filedatetimeoriginal < $filedatetime ) { 
			$filedatetime = $filedatetimeoriginal;
		}
		$file_date = bw_format_date(  $filedatetime, "Y-m-d H:i:s" );
	} else {
		$filedatetime = oik_media_extract_field( $data, "FileDateTime" );
		$file_date = bw_format_date( $filedatetime, "Y-m-d H:i:s" );
	}
	return( $file_date );
}

/**
 * Extracts a particular field
 *
 * 
 * Field        | Contains
 * ------------ | --------------
 * FileDateTime | The file modified / last accessed time 
 * DateTime | 2015:02:04 11:46:16 - more likely to be the file last modified time
 * 
 
 Array
(
    [FileName] => oik-media-icon-256x256.jpg
    [FileDateTime] => 1464625801
    [FileSize] => 21787
    [FileType] => 2
    [MimeType] => image/jpeg
    [SectionsFound] => COMMENT
    [COMPUTED] => Array
        (
            [html] => width="256" height="256"
            [Height] => 256
            [Width] => 256
            [IsColor] => 1
        )

    [COMMENT] => Array
        (
            [0] => (C) Copyright Bobbing Wide 2010-2016
        )
 */
function oik_media_extract_field( $exif_data, $field ) {
	$value = bw_array_get( $exif_data, $field, null );
	return( $value );
}

/**
 * The output from the fuzzy duck image contains:
 *
 * This includes other date time fields:
 * 
 * - [DateTime] => 2015:02:04 11:45:59
 * - [DateTimeOriginal] => 2015:02:04 11:45:59
 * - [DateTimeDigitized] => 2015:02:04 11:45:59
 * 
 * `
Array
(
    [FileName] => IMG_0004.JPG
    [FileDateTime] => 1423050360
    [FileSize] => 918813
    [FileType] => 2
    [MimeType] => image/jpeg
    [SectionsFound] => ANY_TAG, IFD0, THUMBNAIL, EXIF, GPS
    [COMPUTED] => Array
        (
            [html] => width="2592" height="1936"
            [Height] => 1936
            [Width] => 2592
            [IsColor] => 1
            [ByteOrderMotorola] => 1
            [ApertureFNumber] => f/2.4
            [Thumbnail.FileType] => 2
            [Thumbnail.MimeType] => image/jpeg
        )

    [Make] => Apple
    [Model] => iPad Air
    [Orientation] => 1
    [XResolution] => 72/1
    [YResolution] => 72/1
    [ResolutionUnit] => 2
    [Software] => 8.1.3
    [DateTime] => 2015:02:04 11:45:59
    [YCbCrPositioning] => 1
    [Exif_IFD_Pointer] => 204
    [GPS_IFD_Pointer] => 1014
    [THUMBNAIL] => Array
        (
            [Compression] => 6
            [XResolution] => 72/1
            [YResolution] => 72/1
            [ResolutionUnit] => 2
            [JPEGInterchangeFormat] => 1398
            [JPEGInterchangeFormatLength] => 6364
        )

    [ExposureTime] => 1/24
    [FNumber] => 12/5
    [ExposureProgram] => 2
    [ISOSpeedRatings] => 40
    [ExifVersion] => 0221
    [DateTimeOriginal] => 2015:02:04 11:45:59
    [DateTimeDigitized] => 2015:02:04 11:45:59
    [ComponentsConfiguration] => binary  SOH STX ETX NUL
    [ShutterSpeedValue] => 3237/706
    [ApertureValue] => 4845/1918
    [BrightnessValue] => 3865/916
    [ExposureBiasValue] => 0/1
    [MeteringMode] => 3
    [Flash] => 32
    [FocalLength] => 33/10
    [SubjectLocation] => Array
        (
            [0] => 1312
            [1] => 1113
            [2] => 484
            [3] => 484
        )

    [MakerNote] => Apple iOS  - then some binary stuff
    [SubSecTimeOriginal] => 950
    [SubSecTimeDigitized] => 950
    [FlashPixVersion] => 0100
    [ColorSpace] => 1
    [ExifImageWidth] => 2592
    [ExifImageLength] => 1936
    [SensingMethod] => 2
    [SceneType] => binary SOH
    [ExposureMode] => 0
    [WhiteBalance] => 0
    [FocalLengthIn35mmFilm] => 32
    [SceneCaptureType] => 0
    [UndefinedTag:0xA432] => Array
        (
            [0] => 33/10
            [1] => 33/10
            [2] => 12/5
            [3] => 12/5
        )

    [UndefinedTag:0xA433] => Apple
    [UndefinedTag:0xA434] => iPad Air back camera 3.3mm f/2.4
    [GPSLatitudeRef] => N
    [GPSLatitude] => Array
        (
            [0] => 50/1
            [1] => 53/1
            [2] => 1657/100
        )

    [GPSLongitudeRef] => W
    [GPSLongitude] => Array
        (
            [0] => 0/1
            [1] => 57/1
            [2] => 5497/100
        )

    [GPSAltitudeRef] =>  binary NUL
    [GPSAltitude] => 26997/709
    [GPSTimeStamp] => Array
        (
            [0] => 11/1
            [1] => 43/1
            [2] => 3189/100
        )

    [GPSSpeedRef] => K
    [GPSSpeed] => 0/1
    [GPSImgDirectionRef] => T
    [GPSImgDirection] => 6307/172
    [GPSDestBearingRef] => T
    [GPSDestBearing] => 37267/172
    [GPSDateStamp] => 2015:02:04
)
 `
 
2015-02-04 11:46:00 C:/vinyl/My Pictures/iPad/2016-05-17/IMG_0004.JPG

 */
 

