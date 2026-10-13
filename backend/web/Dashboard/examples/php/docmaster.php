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
Editor::inst( $db, 'tbl_docmaster', 'td_id' )
	->fields(
	
		Field::inst( 'tbl_docmaster.td_docname' )->validator( 'Validate::notEmpty' ),
		
		//Field::inst( 'catid' ),
		Field::inst( 'tbl_docmaster.td_typeid' )
            ->options( Options::inst()
                ->table( 'customertype' )
                ->value( 'typeID' )
                ->label( 'typeName' )
            )
            ->validator( 'Validate::dbValues' ),
        Field::inst( 'customertype.typeName' ),
		
		
		
		 
                                          Field::inst( 'tbl_docmaster.active' )
                                        ->setFormatter( function ( $val, $data, $opts ) {
                return ! $val ? 0 : 1;
            } )
	)
	 ->leftJoin( 'customertype', 'customertype.typeID', '=', 'tbl_docmaster.td_typeid' )
	->process( $_POST )
	->json();
