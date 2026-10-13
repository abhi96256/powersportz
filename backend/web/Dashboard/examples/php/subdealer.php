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
Editor::inst( $db, 'tbl_subdealer', 'tsb_id' )
	->fields(
                
	
		Field::inst( 'tbl_subdealer.tsb_applicantname' )->validator( 'Validate::notEmpty' ),
		Field::inst( 'tbl_subdealer.tsb_companyname' )->validator( 'Validate::notEmpty' ),
                Field::inst( 'tbl_subdealer.tsb_address' )->validator( 'Validate::notEmpty' ),
	
		
		//Field::inst( 'catid' ),
		
		
                                     
		
                                         Field::inst( 'active' )
                                        ->setFormatter( function ( $val, $data, $opts ) {
                return ! $val ? 0 : 1;
            } )
	)
	
	->process( $_POST )
	->json();
