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
Editor::inst( $db, 'tbl_package_master_view', 'PMV_ID' )
	->fields(
                
	
		Field::inst( 'tbl_package_master_view.PMV_NAME' )->validator( 'Validate::notEmpty' ),
                Field::inst( 'tbl_package_master_view.PMV_BDD_CODE' )->validator( 'Validate::notEmpty' ),
		Field::inst( 'tbl_package_master_view.PMV_PRICE' )->validator( 'Validate::notEmpty' ),
	Field::inst( 'tbl_package_master_view.PMV_VAL' )->validator( 'Validate::notEmpty' ),
                Field::inst( 'tbl_package_master_view.PMV_OPEN_DATE' )->validator( 'Validate::dateFormat', array(
                'empty' => false,
                'format' => 'm-d-Y g:i A'
            ) )
            ->getFormatter( 'Format::datetime', array(
                'from' => 'Y-m-d H:i:s',
                'to' =>   'm-d-Y g:i A'
            ) )
            ->setFormatter( 'Format::datetime', array(
                'from' => 'm-d-Y g:i A',
                'to' =>   'Y-m-d H:i:s'
            ) ),
		Field::inst( 'tbl_package_master_view.PMV_CLOSE_DATE' )->validator( 'Validate::dateFormat', array(
                'empty' => false,
                'format' => 'm-d-Y g:i A'
            ) )
            ->getFormatter( 'Format::datetime', array(
                'from' => 'Y-m-d H:i:s',
                'to' =>   'm-d-Y g:i A'
            ) )
            ->setFormatter( 'Format::datetime', array(
                'from' => 'm-d-Y g:i A',
                'to' =>   'Y-m-d H:i:s'
            ) ),
		
		
		//Field::inst( 'catid' ),
		
                Field::inst( 'tbl_package_master_view.PMV_DESCRIPTION' )->validator( 'Validate::notEmpty' ),
                Field::inst( 'tbl_package_master_view.PMV_RENEWFLAG' )->validator( 'Validate::notEmpty' ),
               
		
			Field::inst( 'tbl_package_master_view.PMV_STATUS' ),
                  Field::inst( 'readingOrder' )->validator( 'Validate::numeric' )
	)
      
    ->on( 'preRemove', function ( $editor, $id, $values ) {
        // On remove, the sequence needs to be updated to decrement all rows
        // beyond the deleted row. Get the current reading order by id (don't
        // use the submitted value in case of a multi-row delete).
        $order = $editor->db()
            ->select( 'tbl_package_master_view', 'readingOrder', array('PMV_ID' => $id) )
            ->fetch();
 
        $editor->db()
            ->query( 'update', 'tbl_package_master_view' )
            ->set( 'readingOrder', 'readingOrder-1', false )
            ->where( 'readingOrder', $order['readingOrder'], '>' )
            ->exec();
    } )
	
	->process( $_POST )
	->json();
