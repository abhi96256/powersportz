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
Editor::inst( $db, 'sk_tour_detail', 'std_id' )
	->fields(
	
		Field::inst( 'sk_tour_detail.std_name' )->validator( 'Validate::notEmpty' ),
		Field::inst( 'sk_tour_detail.std_short_detail' )->validator( 'Validate::notEmpty' ),
		
		Field::inst( 'sk_tour_detail.std_maincat' )
            ->options( Options::inst()
                ->table( 'sk_tour_categories' )
                ->value( 'stc_id' )
                ->label( 'stc_title' )
            )
            ->validator( 'Validate::dbValues' ),
        Field::inst( 'sk_tour_categories.stc_title' ),
		
		    Field::inst( 'sk_tour_detail.std_cost' )->validator( 'Validate::notEmpty' ),
			Field::inst( 'sk_tour_detail.std_startdate' )->validator( 'Validate::notEmpty' )->validator( 'Validate::dateFormat', array(
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
			Field::inst( 'sk_tour_detail.std_enddate' )->validator( 'Validate::notEmpty' )->validator( 'Validate::dateFormat', array(
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
			Field::inst( 'sk_tour_detail.std_duration_days' )->validator( 'Validate::notEmpty' ),
			Field::inst( 'sk_tour_detail.std_duration_nights' )->validator( 'Validate::notEmpty' ),			
			Field::inst( 'sk_tour_detail.std_overview' )->validator( 'Validate::notEmpty' ),
			Field::inst( 'sk_tour_detail.std_daywise_detail' )->validator( 'Validate::notEmpty' ),
			Field::inst( 'sk_tour_detail.std_inc_exl' )->validator( 'Validate::notEmpty' ),
			Field::inst( 'sk_tour_detail.std_price_detail' )->validator( 'Validate::notEmpty' ),
			Field::inst( 'sk_tour_detail.std_dates_detail' )->validator( 'Validate::notEmpty' ),
			Field::inst( 'sk_tour_detail.std_hotel_detail' )->validator( 'Validate::notEmpty' ),
			Field::inst( 'sk_tour_detail.std_tnc' )->validator( 'Validate::notEmpty' ),
			Field::inst( 'sk_tour_detail.std_map' )->validator( 'Validate::notEmpty' ),
		//Field::inst( 'sk_tour_detail.std_facilities' )->validator( 'Validate::notEmpty' ),

		Field::inst( 'sk_tour_detail.std_order' )->validator( 'Validate::notEmpty' ),
		Field::inst( 'sk_tour_detail.std_tags' )->validator( 'Validate::notEmpty' ),
	
		
		//Field::inst( 'catid' ),
		
		
			
			Field::inst( 'sk_tour_detail.std_book_flag' ),
	
		
			Field::inst( 'sk_tour_detail.std_status' )
	)
	->join(
		Mjoin::inst( 'files' )
			->link( 'sk_tour_detail.std_id', 'users_files.user_id' )
			->link( 'files.id', 'users_files.file_id' )
			->fields(
				Field::inst( 'id' )
					->upload( Upload::inst( $_SERVER['DOCUMENT_ROOT'].'/senkay/img/__NAME__' )
						->db( 'files', 'id', array(
							'filename'    => Upload::DB_FILE_NAME,
							'filesize'    => Upload::DB_FILE_SIZE,
							'web_path'    => Upload::DB_WEB_PATH,
							'system_path' => Upload::DB_SYSTEM_PATH
						) )
						->validator( function ( $file ) {
							return$file['size'] >= 500000 ?
								"Files must be smaller than 500K" :
								null;
						} )
						->allowedExtensions( array( 'png', 'jpg' ), "Please upload an image" )
					)
			)
	)
	 ->leftJoin( 'sk_tour_categories', 'sk_tour_categories.stc_id', '=', 'sk_tour_detail.std_maincat' )
	  ->join(
        Mjoin::inst( 'sk_tour_facilities' )
            ->link( 'sk_tour_detail.std_id', 'sk_facility_map.sfm_id' )
            ->link( 'sk_tour_facilities.stf_id', 'sk_facility_map.sfm_fac_id' )
            ->order( 'stf_name asc' )
            ->fields(
                Field::inst( 'stf_id' )
                    ->validator( 'Validate::required' )
                    ->options( Options::inst()
                        ->table( 'sk_tour_facilities' )
                        ->value( 'stf_id' )
                        ->label( 'stf_name' )
                    ),
                Field::inst( 'stf_name' )
            )
    )
	->process( $_POST )
	->json();
