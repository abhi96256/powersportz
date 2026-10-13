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
Editor::inst( $db, 'language_master', 'ID' )
	->fields(
                
	
		Field::inst( 'language_master.LANGUAGE_NAME' )->validator( 'Validate::notEmpty' ),
		Field::inst( 'language_master.LANG_ORDER' )->validator( 'Validate::notEmpty' ),
	
		
		//Field::inst( 'catid' ),
		
		
			Field::inst( 'language_master.LANGUAGE_STATUS' )
	)
	
	->process( $_POST )
	->json();
