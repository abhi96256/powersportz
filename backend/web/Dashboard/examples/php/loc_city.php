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
Editor::inst( $db, 'cities', 'id' )
	->fields(
	
		Field::inst( 'cities.name' )->validator( 'Validate::notEmpty' ),
		
		//Field::inst( 'catid' ),
		Field::inst( 'cities.state_id' )
            ->options( Options::inst()
                ->table( 'states' )
                ->value( 'id' )
                ->label( 'name' )
            )
            ->validator( 'Validate::dbValues' ),
        Field::inst( 'states.name' )
		
		
		
               
	)
	 ->leftJoin( 'states', 'states.id', '=', 'cities.state_id' )
	->process( $_POST )
	->json();
