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
Editor::inst( $db, 'csrproject', 'id' )
	->fields(
	
                 Field::inst( 'csrproject.pname' )->validator( 'Validate::notEmpty' ),
            
                
                        Field::inst( 'csrproject.functions' )
            ->options( Options::inst()
                ->table( 'domains' )
                ->value( 'id' )
                ->label( 'name' )
            )
             ->validator( 'Validate::dbValues' ),
        Field::inst( 'domains.name' ),
                
                        Field::inst( 'csrproject.state' )
            ->options( Options::inst()
                ->table( 'states' )
                ->value( 'id' )
                ->label( 'name' )
            )
             ->validator( 'Validate::dbValues' ),
        Field::inst( 'states.name' ),
                  Field::inst( 'csrproject.city' )
            ->options( Options::inst()
                ->table( 'cities' )
                ->value( 'id' )
                ->label( 'name' )
            )
             ->validator( 'Validate::dbValues' ),
        Field::inst( 'cities.name' ),
               //  Field::inst( 'csrproject.ad_link' ),
                 Field::inst( 'csrproject.pdetail' )->validator( 'Validate::notEmpty' ),
         
                                 
                
		//  Field::inst( 'csrproject.tm_songid' )->validator( 'Validate::notEmpty' ),
		
		              Field::inst( 'csrproject.budget' )
            ->options( Options::inst()
                ->table( 'budget' )
                ->value( 'id' )
                ->label( 'bfrom' )
            )
             ->validator( 'Validate::dbValues' ),
        Field::inst( 'budget.bfrom' ),

                Field::inst( 'csrproject.startdate' )->validator( 'Validate::notEmpty' ),
		Field::inst( 'csrproject.enddate' )->validator( 'Validate::notEmpty' ),
                                      
                                         Field::inst( 'csrproject.ngoyears' )->validator( 'Validate::notEmpty' ),
                                        
                                          Field::inst( 'csrproject.camp_status' )
                                        ->setFormatter( function ( $val, $data, $opts ) {
                return ! $val ? 0 : 1;
            } ),
                       Field::inst( 'csrproject.ngo' )->validator( 'Validate::notEmpty' ),
                      
                       Field::inst( 'csrproject.legal' )->validator( 'Validate::notEmpty' ),
                       Field::inst( 'csrproject.benificiaries' )->validator( 'Validate::notEmpty' ),
                       Field::inst( 'csrproject.searchtags' )->validator( 'Validate::notEmpty' ),
                     Field::inst( 'csrproject.camp_order' )->validator( 'Validate::numeric' )
                   
	)
                 
                    
    ->on( 'preRemove', function ( $editor, $id, $values ) {
        // On remove, the sequence needs to be updated to decrement all rows
        // beyond the deleted row. Get the current reading order by id (don't
        // use the submitted value in case of a multi-row delete).
        $order = $editor->db()
            ->select( 'csrproject', 'csrproject.camp_order', array('id' => $id) )
            ->fetch();
 
        $editor->db()
            ->query( 'update', 'csrproject' )
            ->set( 'csrproject.camp_order', 'csrproject.camp_order-1', false )
            ->where( 'csrproject.camp_order', $order['csrproject.camp_order'], '>' )
            ->exec();
    } )
	// ->leftJoin( 'tbl_master_music_cat', 'tbl_master_music_cat.tmmc_id', '=', 'csrproject.tb_generid' )
       //      ->leftJoin( 'tbl_master_tracks', 'tbl_master_tracks.tmt_id', '=', 'csrproject.tm_songid' )
          //   ->leftJoin( 'tbl_master_artist', 'tbl_master_artist.tma_id', '=', 'csrproject.tb_artistid' )
     ->leftJoin( 'states', 'states.id', '=', 'csrproject.state'    )
             ->leftJoin( 'domains', 'domains.id', '=', 'csrproject.functions'    )
               ->leftJoin( 'budget', 'budget.id', '=', 'csrproject.budget'    )
            //  ->where( 'f_ads.ad_status', '1' )
              ->leftJoin( 'cities', 'cities.id', '=', 'csrproject.city'  )
           //   ->where( 'f_audience.aud_status', '1' )
	->process( $_POST )
	->json();
  