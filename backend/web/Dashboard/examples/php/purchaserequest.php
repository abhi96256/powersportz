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
Editor::inst( $db, 'tbl_sub_counters', 'tsc_id' )
	->fields(
	
		Field::inst( 'tbl_subdealer.tsb_userid' )->validator( 'Validate::notEmpty' ),
                	Field::inst( 'tbl_subdealer.tsb_applicantname' )->validator( 'Validate::notEmpty' ),
                
		
		//Field::inst( 'catid' ),
		Field::inst( 'tbl_sub_counters.tsc_countertype' )
            ->options( Options::inst()
                ->table( 'customertype' )
                ->value( 'typeID' )
                ->label( 'typeName' )
            )
            ->validator( 'Validate::dbValues' ),
        Field::inst( 'customertype.typeName' ),
		
		
	
			
			
                                        Field::inst( 'tbl_sub_counters.tsc_rate' ),
                  Field::inst( 'customertype.duration' ),
                  Field::inst( 'tbl_sub_counters.tsc_counterqty' ),
                                          Field::inst( 'tbl_sub_counters.active' )
                                        ->setFormatter( function ( $val, $data, $opts ) {
                return ! $val ? 0 : 1;
            } )
	)
	 ->leftJoin( 'customertype', 'customertype.typeID', '=', 'tbl_sub_counters.tsc_countertype' )
         ->leftJoin( 'tbl_subdealer', 'tbl_subdealer.tsb_id', '=', 'tbl_sub_counters.tsc_subdealerid' )
	->process( $_POST )
	->json();
