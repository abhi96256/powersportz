<?php
session_start();
//echo "-------".$_SESSION['UserID']; die;
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
Editor::inst( $db, 'f_ads', 'id' )
	->fields(
	
                 Field::inst( 'f_ads.ad_title' )->validator( 'Validate::notEmpty' ),
                 Field::inst( 'f_ads.ad_name' )->validator( 'Validate::notEmpty' ),
                 Field::inst( 'f_ads.ad_descr' )->validator( 'Validate::notEmpty' ),
                
               //  Field::inst( 'f_ads.ad_link' ),
                 Field::inst( 'f_ads.ad_type' )->validator( 'Validate::notEmpty' ),
                
                 Field::inst( 'f_ads.ad_img' )
		//->setFormatter( 'Format::ifEmpty', null )
		
			->upload( Upload::inst( $_SERVER['DOCUMENT_ROOT'].'/FOCO/img/__ID_____NAME__' )
				->db( 'files', 'id', array(
					'filename'    => Upload::DB_FILE_NAME,
                                    'filesize'    => Upload::DB_FILE_SIZE,
							'web_path'    => Upload::DB_WEB_PATH,
							'system_path' => Upload::DB_SYSTEM_PATH
					
				) )
				->validator( function ( $file ) {
					return$file['size'] >= 121000000 ?
						"Files must be smaller than 100K" :
						null;
				} )
				->allowedExtensions( array( 'png', 'jpeg', 'jpg', 'gif' ), "Please upload an image" )
			),
                                        
                                           Field::inst( 'f_ads.ad_video' )
		//->setFormatter( 'Format::ifEmpty', null )
		
			->upload( Upload::inst( $_SERVER['DOCUMENT_ROOT'].'/FOCO/img/__ID_____NAME__' )
				->db( 'files', 'id', array(
					'filename'    => Upload::DB_FILE_NAME,
                                    'filesize'    => Upload::DB_FILE_SIZE,
							'web_path'    => Upload::DB_WEB_PATH,
							'system_path' => Upload::DB_SYSTEM_PATH
					
				) )
				->validator( function ( $file ) {
					return$file['size'] >= 121000000 ?
						"Files must be smaller than 2500K" :
						null;
				} )
				->allowedExtensions( array( 'mp4' ), "Please upload an Video" )
			),
                
		//  Field::inst( 'f_ads.tm_songid' )->validator( 'Validate::notEmpty' ),
		
		
		 
                                          Field::inst( 'f_ads.ad_status' )
                                        ->setFormatter( function ( $val, $data, $opts ) {
                return ! $val ? 0 : 1;
            } ),
                     Field::inst( 'f_ads.ad_order' )->validator( 'Validate::numeric' ),
                     Field::inst( 'f_ads.ad_client_id' )
	)
                            ->where( 'ad_client_id', $_SESSION['UserID'] )    
                     
                    ->on( 'preCreate', function ( $editor, $values ) {
        $editor
            ->field( 'f_ads.ad_client_id' )
            ->setValue($_SESSION['UserID']);
    } )
                    
    ->on( 'preRemove', function ( $editor, $id, $values ) {
        // On remove, the sequence needs to be updated to decrement all rows
        // beyond the deleted row. Get the current reading order by id (don't
        // use the submitted value in case of a multi-row delete).
        $order = $editor->db()
            ->select( 'f_ads', 'f_ads.ad_order', array('id' => $id) )
            ->fetch();
 
        $editor->db()
            ->query( 'update', 'f_ads' )
            ->set( 'f_ads.ad_order', 'f_ads.ad_order-1', false )
            ->where( 'f_ads.ad_order', $order['f_ads.ad_order'], '>' )
            ->exec();
    } )
	// ->leftJoin( 'tbl_master_music_cat', 'tbl_master_music_cat.tmmc_id', '=', 'f_ads.tb_generid' )
       //      ->leftJoin( 'tbl_master_tracks', 'tbl_master_tracks.tmt_id', '=', 'f_ads.tm_songid' )
          //   ->leftJoin( 'tbl_master_artist', 'tbl_master_artist.tma_id', '=', 'f_ads.tb_artistid' )
	->process( $_POST )
	->json();
