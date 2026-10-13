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
Editor::inst( $db, 'f_audience', 'id' )
	->fields(
	
              
                 Field::inst( 'f_audience.aud_name' )->validator( 'Validate::notEmpty' ),
               
                
               //  Field::inst( 'f_audience.ad_link' ),
                 Field::inst( 'f_audience.aud_gender' )->validator( 'Validate::notEmpty' ),
                 Field::inst( 'f_audience.aud_platform' )->validator( 'Validate::notEmpty' ),
              //  Field::inst( 'f_audience.aud_todo' ),
                 Field::inst( 'f_audience.aud_language' )->validator( 'Validate::notEmpty' ),
                 Field::inst( 'f_audience.aud_age_range' )->validator( 'Validate::notEmpty' ),
                 Field::inst( 'f_audience.aud_geo_point' )
            ->options( Options::inst()
                ->table( 'f_customers' )
                ->value( 'fc_id' )
                ->label( 'fc_area' )
            )
             ->validator( 'Validate::dbValues' ),
        Field::inst( 'f_customers.fc_area' ),
                  Field::inst( 'f_audience.aud_intrests' )
            ->options( Options::inst()
                ->table( 'f_ads_interest' )
                ->value( 'fai_id' )
                ->label( 'fai_name' )
            )
             ->validator( 'Validate::dbValues' ),
        Field::inst( 'f_ads_interest.fai_name' ),
                  Field::inst( 'f_audience.aud_range' ),
                                       
		//  Field::inst( 'f_audience.tm_songid' )->validator( 'Validate::notEmpty' ),
		
		
		 
                                          Field::inst( 'f_audience.aud_status' )
                                        ->setFormatter( function ( $val, $data, $opts ) {
                return ! $val ? 0 : 1;
            } ),
                     Field::inst( 'f_audience.aud_order' )->validator( 'Validate::numeric' ),
                     Field::inst( 'f_audience.aud_client_id' )
	)
                            ->where( 'aud_client_id', $_SESSION['UserID'] )    
                     
                    ->on( 'preCreate', function ( $editor, $values ) {
        $editor
            ->field( 'f_audience.aud_client_id' )
            ->setValue($_SESSION['UserID']);
    } )
                    
    ->on( 'preRemove', function ( $editor, $id, $values ) {
        // On remove, the sequence needs to be updated to decrement all rows
        // beyond the deleted row. Get the current reading order by id (don't
        // use the submitted value in case of a multi-row delete).
        $order = $editor->db()
            ->select( 'f_audience', 'f_audience.aud_order', array('id' => $id) )
            ->fetch();
 
        $editor->db()
            ->query( 'update', 'f_audience' )
            ->set( 'f_audience.aud_order', 'f_audience.aud_order-1', false )
            ->where( 'f_audience.aud_order', $order['f_audience.aud_order'], '>' )
            ->exec();
    } )
	// ->leftJoin( 'tbl_master_music_cat', 'tbl_master_music_cat.tmmc_id', '=', 'f_audience.tb_generid' )
       //      ->leftJoin( 'tbl_master_tracks', 'tbl_master_tracks.tmt_id', '=', 'f_audience.tm_songid' )
             ->leftJoin( 'f_customers', 'f_customers.fc_id', '=', 'f_audience.aud_geo_point' )
             ->leftJoin( 'f_ads_interest', 'f_ads_interest.fai_id', '=', 'f_audience.aud_intrests' )
	->process( $_POST )
	->json();
