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
Editor::inst( $db, 'tbl_notifications', 'td_id' )
	->fields(
	
		Field::inst( 'tbl_notifications.td_name' )->validator( 'Validate::notEmpty' ),
		
		
      
		
		
		
		Field::inst( 'tbl_notifications.td_link' )
			->setFormatter( 'Format::ifEmpty', null )
			->upload( Upload::inst( $_SERVER['DOCUMENT_ROOT'].'/Dashboard/upload/__NAME__' )
				->db( 'files', 'id', array(
					'filename'    => Upload::DB_FILE_NAME,
					'filesize'    => Upload::DB_FILE_SIZE,
					'web_path'    => Upload::DB_WEB_PATH,
					'system_path' => Upload::DB_SYSTEM_PATH
				) )
				->validator( function ( $file ) {
					return$file['size'] >= 50000000 ?
						"Files must be smaller than 500MB" :
						null;
				} )
				->allowedExtensions( array( 'zip', 'rar','pdf','doc','docx' ), "Please upload an Valid File" )
			),
                                        Field::inst( 'tbl_notifications.td_order' ),
                                                                 Field::inst( 'active' )
                                        ->setFormatter( function ( $val, $data, $opts ) {
                return ! $val ? 0 : 1;
            } )
	)
	
	->process( $_POST )
	->json();
