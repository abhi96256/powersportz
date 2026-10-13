<?php

/*
 * Example PHP implementation used for the index.html example
 */

// DataTables PHP library
include( "../../php/DataTables.php" );

// Alias Editor classes so they are easy to use
use
	DataTables\Editor,
	DataTables\Editor\Field,
	DataTables\Editor\Format,
	DataTables\Editor\Mjoin,
	DataTables\Editor\Options,
	DataTables\Editor\Upload,
	DataTables\Editor\Validate;


// Build our Editor instance and process the data coming from _POST
Editor::inst( $db, 'mst_related', 'sub_id' )
	->fields(
	
		Field::inst( 'mst_related.sub_name' )->validator( 'Validate::notEmpty' ),
		Field::inst( 'mst_related.sub_text' )->validator( 'Validate::notEmpty' ),
		Field::inst( 'mst_related.sub_youtube' ),
		
		//Field::inst( 'catid' ),
		
		Field::inst( 'mst_related.sub_img' )
		
			->upload( Upload::inst( $_SERVER['DOCUMENT_ROOT'].'/img/__ID__.__EXTN__' )
				->db( 'files', 'id', array(
					'filename'    => Upload::DB_FILE_NAME,
					'filesize'    => Upload::DB_FILE_SIZE,
					'web_path'    => Upload::DB_WEB_PATH,
					'system_path' => Upload::DB_SYSTEM_PATH
				) )
				->validator( function ( $file ) {
					return$file['size'] >= 500000 ?
						"Files must be smaller than 500K" :
						null;
				} )
				->allowedExtensions( array( 'png', 'jpg', 'gif' ), "Please upload an image" )
			)
	)
	
	->process( $_POST )
	->json();
