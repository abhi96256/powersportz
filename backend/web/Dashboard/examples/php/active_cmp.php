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
Editor::inst( $db, 'f_campaign', 'id' )
	->fields(
	
                 Field::inst( 'f_campaign.camp_name' )->validator( 'Validate::notEmpty' ),
            
                
                        Field::inst( 'f_campaign.camp_ads_id' )
            ->options( Options::inst()
                ->table( 'f_ads' )
                ->value( 'id' )
                ->label( 'ad_name' )
            )
             ->validator( 'Validate::dbValues' ),
        Field::inst( 'f_ads.ad_name' ),
                  Field::inst( 'f_campaign.camp_aud_id' )
            ->options( Options::inst()
                ->table( 'f_audience' )
                ->value( 'id' )
                ->label( 'aud_name' )
            )
             ->validator( 'Validate::dbValues' ),
        Field::inst( 'f_audience.aud_name' ),
               //  Field::inst( 'f_campaign.ad_link' ),
                 Field::inst( 'f_campaign.camp_landingurl' )->validator( 'Validate::notEmpty' ),
                 Field::inst( 'f_campaign.camp_objective' )->validator( 'Validate::notEmpty' ),
                
                 Field::inst( 'f_campaign.camp_logo' )
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
                                 
                
		//  Field::inst( 'f_campaign.tm_songid' )->validator( 'Validate::notEmpty' ),
		
		     Field::inst( 'f_campaign.camp_targetnumber' )->validator( 'Validate::notEmpty' ),

                Field::inst( 'f_campaign.camp_date_start' )->validator( 'Validate::notEmpty' ),
		Field::inst( 'f_campaign.camp_date_stop' )->validator( 'Validate::notEmpty' ),
                                        Field::inst( 'f_campaign.camp_active_hours' )->validator( 'Validate::notEmpty' ),
		 Field::inst( 'f_campaign.camp_cpc' )->validator( 'Validate::notEmpty' ),
                                         Field::inst( 'f_campaign.camp_dailybudget' )->validator( 'Validate::notEmpty' ),
                                        
                                          Field::inst( 'f_campaign.camp_status' )
                                        ->setFormatter( function ( $val, $data, $opts ) {
                return ! $val ? 0 : 1;
            } ),
                     Field::inst( 'f_campaign.camp_order' )->validator( 'Validate::numeric' ),
                     Field::inst( 'f_campaign.camp_client_id' )
	)
                            ->where( 'camp_client_id', $_SESSION['UserID'] )    
                     
                    ->on( 'preCreate', function ( $editor, $values ) {
        $editor
            ->field( 'f_campaign.camp_client_id' )
            ->setValue($_SESSION['UserID']);
    } )
                    
    ->on( 'preRemove', function ( $editor, $id, $values ) {
        // On remove, the sequence needs to be updated to decrement all rows
        // beyond the deleted row. Get the current reading order by id (don't
        // use the submitted value in case of a multi-row delete).
        $order = $editor->db()
            ->select( 'f_campaign', 'f_campaign.camp_order', array('id' => $id) )
            ->fetch();
 
        $editor->db()
            ->query( 'update', 'f_campaign' )
            ->set( 'f_campaign.camp_order', 'f_campaign.camp_order-1', false )
            ->where( 'f_campaign.camp_order', $order['f_campaign.camp_order'], '>' )
            ->exec();
    } )
	// ->leftJoin( 'tbl_master_music_cat', 'tbl_master_music_cat.tmmc_id', '=', 'f_campaign.tb_generid' )
       //      ->leftJoin( 'tbl_master_tracks', 'tbl_master_tracks.tmt_id', '=', 'f_campaign.tm_songid' )
          //   ->leftJoin( 'tbl_master_artist', 'tbl_master_artist.tma_id', '=', 'f_campaign.tb_artistid' )
     ->leftJoin( 'f_ads', 'f_ads.id', '=', 'f_campaign.camp_ads_id'    )
            //  ->where( 'f_ads.ad_status', '1' )
              ->leftJoin( 'f_audience', 'f_audience.id', '=', 'f_campaign.camp_aud_id'  )
           //   ->where( 'f_audience.aud_status', '1' )
	->process( $_POST )
	->json();
  