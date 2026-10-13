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
 
 

Editor::inst( $db, 'mst_know','sub_id' )
    ->field(
        Field::inst( 'sub_name' )
  )
    ->process($_POST)
    ->json();