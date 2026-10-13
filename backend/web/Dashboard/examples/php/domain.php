<?php
 
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
 
 
/*
 * Example PHP implementation used for the join.html example
 */
Editor::inst( $db, 'domains','id' )
    ->field(
        Field::inst( 'domains.name' )->validator( 'Validate::notEmpty' )
		
 
        
    )
   // ->leftJoin( 'mst_subjectm', 'mst_subjectm.ms_id', '=', 'mst_subject.mcatid' )
    ->process($_POST)
    ->json();