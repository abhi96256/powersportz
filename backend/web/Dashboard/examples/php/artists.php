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
Editor::inst( $db, 'tbl_master_artist', 'tma_id' )
	->fields(
	
		
		
	
                
                	
		//Field::inst( 'catid' ),
		
               
                
              
                
                  Field::inst( 'tbl_master_artist.tma_name' )->validator( 'Validate::notEmpty' ),
                  Field::inst( 'tbl_master_artist.tma_about' )->validator( 'Validate::notEmpty' ),
               
                
                
          
                
            
                
         
               
                
                	Field::inst( 'tbl_master_artist.tma_pic' )
		->setFormatter( 'Format::ifEmpty', null )
		
			->upload( Upload::inst( $_SERVER['DOCUMENT_ROOT'].'/musicscorer/img/__NAME__' )
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
                                        
                                        
                	Field::inst( 'tbl_master_artist.tma_big_pic' )
		->setFormatter( 'Format::ifEmpty', null )
		
			->upload( Upload::inst( $_SERVER['DOCUMENT_ROOT'].'/musicscorer/img/__NAME__' )
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
                
		//  Field::inst( 'tbl_master_artist.tm_songid' )->validator( 'Validate::notEmpty' ),
		
		
		 
                                          Field::inst( 'tbl_master_artist.active' )
                                        ->setFormatter( function ( $val, $data, $opts ) {
                return ! $val ? 0 : 1;
            } ),
                     Field::inst( 'tbl_master_artist.tma_order' )->validator( 'Validate::numeric' )
	)
                   
    ->on( 'preRemove', function ( $editor, $id, $values ) {
        // On remove, the sequence needs to be updated to decrement all rows
        // beyond the deleted row. Get the current reading order by id (don't
        // use the submitted value in case of a multi-row delete).
        $order = $editor->db()
            ->select( 'tbl_master_artist', 'tbl_master_artist.tma_order', array('tma_id' => $id) )
            ->fetch();
 
        $editor->db()
            ->query( 'update', 'tbl_master_artist' )
            ->set( 'tbl_master_artist.tma_order', 'tbl_master_artist.tma_order-1', false )
            ->where( 'tbl_master_artist.tma_order', $order['tbl_master_artist.tma_order'], '>' )
            ->exec();
    } )
	// ->leftJoin( 'tbl_master_music_cat', 'tbl_master_music_cat.tmmc_id', '=', 'tbl_master_artist.tb_generid' )
         //    ->leftJoin( 'tbl_master_tracks', 'tbl_master_tracks.tmt_id', '=', 'tbl_master_artist.tm_songid' )
          //   ->leftJoin( 'tbl_master_artist', 'tbl_master_artist.tma_id', '=', 'tbl_master_artist.tb_artistid' )
	->process( $_POST )
	->json();
