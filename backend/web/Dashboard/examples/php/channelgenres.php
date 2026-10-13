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
Editor::inst( $db, 'category', 'cat_id' )
	->fields(
                
	
		Field::inst( 'category.cat_name' )->validator( 'Validate::notEmpty' ),
		Field::inst( 'category.display_order' )->validator( 'Validate::notEmpty' )
	
		
		//Field::inst( 'catid' ),
		
		
	)
	
	->process( $_POST )
	->json();
