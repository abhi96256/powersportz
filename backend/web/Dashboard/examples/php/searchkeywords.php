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
Editor::inst( $db, 'search_keywords', 'id' )
	->fields(
                
	
		Field::inst( 'search_keywords.k_name' )->validator( 'Validate::notEmpty' )
		
	
		
		//Field::inst( 'catid' ),
		
		
	)
	
	->process( $_POST )
	->json();
