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
Editor::inst( $db, 'ws_channel', 'id' )
	->fields(
	
		Field::inst( 'ws_channel.CMV_CH_NAME' )->validator( 'Validate::notEmpty' ),
                Field::inst( 'ws_channel.CMV_CHANNEL_CODE' )->validator( 'Validate::notEmpty' ),
		Field::inst( 'ws_channel.CMV_CH_DES' )->validator( 'Validate::notEmpty' ),
		
		Field::inst( 'ws_channel.CMV_LANGUAGE' )
            ->options( Options::inst()
                ->table( 'language_master' )
                ->value( 'ID' )
                ->label( 'LANGUAGE_NAME' )
            )
            ->validator( 'Validate::dbValues' ),
                    Field::inst( 'language_master.LANGUAGE_NAME' ),
                
       Field::inst( 'ws_channel.cat_name' )
            ->options( Options::inst()
                ->table( 'category' )
                ->value( 'cat_id' )
                ->label( 'cat_name' )
            )
            ->validator( 'Validate::dbValues' ),
                    Field::inst( 'category.cat_name' ),
	
	Field::inst( 'ws_channel.CMV_CHANNEL_PREVIEW_IMAGE' )
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
                                        	Field::inst( 'ws_channel.CMV_CHANNEL_ICON' )
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
                                        Field::inst( 'ws_channel.CMV_EPGNO' )->validator( 'Validate::notEmpty' ),
		Field::inst( 'ws_channel.CMV_CHANNEL_DISPLAY_ORDER' )->validator( 'Validate::notEmpty' ),
		Field::inst( 'ws_channel.CMV_KEYWORD' )->validator( 'Validate::notEmpty' ),
                Field::inst( 'ws_channel.HTTP_3G' )->validator( 'Validate::notEmpty' ),
                Field::inst( 'ws_channel.CMV_CH_STATUS' )
	)

	 ->leftJoin( 'language_master', 'language_master.ID', '=', 'ws_channel.CMV_LANGUAGE' )

         ->leftJoin( 'category', 'category.cat_id', '=', 'ws_channel.cat_name' )

        ->process( $_POST )
	->json();
