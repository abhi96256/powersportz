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
Editor::inst( $db, 'ads', 'ad_id' )
	->fields(
	
                 Field::inst( 'ads.ad_name' )->validator( 'Validate::notEmpty' ),
            
                
                        Field::inst( 'ads.ad_admin' )
            ->options( Options::inst()
                ->table( 'admin_users' )
                ->value( 'user_id' )
                ->label( 'user_name' )
            )
             ->validator( 'Validate::dbValues' ),
        Field::inst( 'admin_users.user_name' ),
               
          
      Field::inst( 'ads.ad_duration' )->validator( 'Validate::notEmpty' ),

        
                                        
                                          Field::inst( 'ads.ad_isactive' )
                                        ->setFormatter( function ( $val, $data, $opts ) {
                return ! $val ? 0 : 1;
            } )
                   
                    
	)
                      
   
	// ->leftJoin( 'tbl_master_music_cat', 'tbl_master_music_cat.tmmc_id', '=', 'ads.tb_generid' )
       //      ->leftJoin( 'tbl_master_tracks', 'tbl_master_tracks.tmt_id', '=', 'ads.tm_songid' )
          //   ->leftJoin( 'tbl_master_artist', 'tbl_master_artist.tma_id', '=', 'ads.tb_artistid' )
     ->leftJoin( 'admin_users', 'admin_users.user_id', '=', 'ads.ad_admin'    )
       
	->process( $_POST )
	->json();
  