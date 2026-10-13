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
Editor::inst( $db, 'home_category', 'tc_id' )
	->fields(
                
	
		Field::inst( 'home_category.tc_name' )->validator( 'Validate::notEmpty' ),
		Field::inst( 'home_category.tc_order' )->validator( 'Validate::notEmpty' ),
	
		
		//Field::inst( 'catid' ),
		
		Field::inst( 'home_category.tc_hover_icon' )
		->setFormatter( 'Format::ifEmpty', null )
		
			->upload( Upload::inst( $_SERVER['DOCUMENT_ROOT'].'/MOBTV/demo/admin/upload/__NAME__' )
				->db( 'files', 'id', array(
					'filename'    => Upload::DB_FILE_NAME,
                                    'filesize'    => Upload::DB_FILE_SIZE,
							'web_path'    => Upload::DB_WEB_PATH,
							'system_path' => Upload::DB_SYSTEM_PATH
					
				) )
				->validator( function ( $file ) {
					return$file['size'] >= 121000000 ?
						"Files must be smaller than 500K" :
						null;
				} )
				->allowedExtensions( array( 'wmv','png', 'jpg', 'gif' ), "Please upload an image" )
			),
			Field::inst( 'home_category.tc_status' )
	)
	
	->process( $_POST )
	->json();
