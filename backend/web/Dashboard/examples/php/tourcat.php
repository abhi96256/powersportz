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
Editor::inst( $db, 'sk_tour_categories', 'stc_id' )
	->fields(
	
		Field::inst( 'sk_tour_categories.stc_title' )->validator( 'Validate::notEmpty' ),
		Field::inst( 'sk_tour_categories.stc_desc' )->validator( 'Validate::notEmpty' ),
		Field::inst( 'sk_tour_categories.stc_order' )->validator( 'Validate::notEmpty' ),
		Field::inst( 'sk_tour_categories.stc_tags' )->validator( 'Validate::notEmpty' ),
	
		
		//Field::inst( 'catid' ),
		
		Field::inst( 'sk_tour_categories.stc_file_id' )
		->setFormatter( 'Format::ifEmpty', null )
		
			->upload( Upload::inst( $_SERVER['DOCUMENT_ROOT'].'/senkay/img/__NAME__' )
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
			),
			
		Field::inst( 'sk_tour_categories.stc_file_id_big' )
		->setFormatter( 'Format::ifEmpty', null )
		
			->upload( Upload::inst( $_SERVER['DOCUMENT_ROOT'].'/senkay/img/__NAME__' )
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
			),
			Field::inst( 'sk_tour_categories.stc_status' )
	)
	
	->process( $_POST )
	->json();
