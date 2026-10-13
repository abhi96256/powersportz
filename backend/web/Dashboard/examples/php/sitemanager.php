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
Editor::inst( $db, 'tbl_sitemanager', 'ts_id' )
	->fields(
	
		Field::inst( 'tbl_sitemanager.ts_about' )->validator( 'Validate::notEmpty' ),
                Field::inst( 'tbl_sitemanager.ts_picid' )
		->setFormatter( 'Format::ifEmpty', null )
		
			->upload( Upload::inst( $_SERVER['DOCUMENT_ROOT'].'/Dashboard/upload/__NAME__' )
				->db( 'files', 'id', array(
					'filename'    => Upload::DB_FILE_NAME,
					'filesize'    => Upload::DB_FILE_SIZE,
					'web_path'    => Upload::DB_WEB_PATH,
					'system_path' => Upload::DB_SYSTEM_PATH
				) )
				->validator( function ( $file ) {
					return$file['size'] >= 1000000 ?
						"Files must be smaller than 500K" :
						null;
				} )
				->allowedExtensions( array('png', 'jpg', 'gif' ), "Please upload an image" )
			),
                                         Field::inst( 'tbl_sitemanager.ts_payment' ),
		Field::inst( 'tbl_sitemanager.ts_refund' )->validator( 'Validate::notEmpty' ),
	
		
		//Field::inst( 'catid' ),
		
		
                                       
			Field::inst( 'tbl_sitemanager.ts_terms' )
	)
	
	->process( $_POST )
	->json();
