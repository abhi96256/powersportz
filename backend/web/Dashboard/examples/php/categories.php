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
Editor::inst( $db, 'mst_subject','sub_id' )
    ->field(
        Field::inst( 'mst_subject.sub_name' )->validator( 'Validate::notEmpty' ),
 
        Field::inst( 'mst_subject.mcatid' )
            ->options( Options::inst()
                ->table( 'mst_subjectm' )
                ->value( 'ms_id' )
                ->label( 'ms_name' )
            )
            ->validator( 'Validate::dbValues' ),
        Field::inst( 'mst_subjectm.ms_name' )
    )
    ->leftJoin( 'mst_subjectm', 'mst_subjectm.ms_id', '=', 'mst_subject.mcatid' )
    ->process($_POST)
    ->json();