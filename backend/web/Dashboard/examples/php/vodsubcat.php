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
Editor::inst( $db, 'ws_subcategory', 'VSM_SUBCAT_ID' )
	->fields(
	
		Field::inst( 'ws_subcategory.VSM_SUBCAT_NAME' )->validator( 'Validate::notEmpty' ),
		
		//Field::inst( 'catid' ),
		Field::inst( 'ws_subcategory.VSM_CATEGORY_ID' )
            ->options( Options::inst()
                ->table( 'ws_category' )
                ->value( 'VCM_GENRE_ID' )
                ->label( 'VCM_GENRE_NAME' )
            )
            ->validator( 'Validate::dbValues' ),
        Field::inst( 'ws_category.VCM_GENRE_NAME' ),
		
		
		
		Field::inst( 'ws_subcategory.VSM_ICON_ID' )
			->setFormatter( 'Format::ifEmpty', null )
			->upload( Upload::inst( $_SERVER['DOCUMENT_ROOT'].'/MOBTV/demo/admin/upload/__NAME__' )
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
	 ->leftJoin( 'ws_category', 'ws_category.VCM_GENRE_ID', '=', 'ws_subcategory.VSM_CATEGORY_ID' )
	->process( $_POST )
	->json();
