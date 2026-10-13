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
Editor::inst( $db, 'ad_pop', 'ap_id' )
	->fields(
                
	
		Field::inst( 'ad_pop.ap_name' )->validator( 'Validate::notEmpty' ),
            
	    Field::inst( 'ad_pop.ap_admin_id' )
            ->options( Options::inst()
                ->table( 'admin_users' )
                ->value( 'user_id' )
                ->label( 'user_name' )
            )
             ->validator( 'Validate::dbValues' ),
        Field::inst( 'admin_users.user_name' ),
		
		//Field::inst( 'catid' ),
		
		Field::inst( 'ad_pop.ap_pic_id' )
		->setFormatter( 'Format::ifEmpty', null )
		
			->upload( Upload::inst( $_SERVER['DOCUMENT_ROOT'].'/backend/web/images/__NAME__' )
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
				->allowedExtensions( array( 'jpeg','png', 'jpg', 'gif' ), "Please upload an image" )
			),
                                     
			
                                         Field::inst( 'ad_pop.ap_status' )
                                        ->setFormatter( function ( $val, $data, $opts ) {
                return ! $val ? 0 : 1;
            } )
	)
            
               ->leftJoin( 'admin_users', 'admin_users.user_id', '=', 'ad_pop.ap_admin_id'    )
	
	->process( $_POST )
	->json();
