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
Editor::inst( $db, 'tbl_master_tracks', 'tmt_id' )
	->fields(
	
		Field::inst( 'tbl_master_tracks.tmt_name' )->validator( 'Validate::notEmpty' ),
		
		//Field::inst( 'catid' ),
		Field::inst( 'tbl_master_tracks.tmt_generid' )
            ->options( Options::inst()
                ->table( 'tbl_master_music_cat' )
                ->value( 'tmmc_id' )
                ->label( 'tmmc_name' )
            )
            ->validator( 'Validate::dbValues' ),
        Field::inst( 'tbl_master_music_cat.tmmc_name' ),
                
                
                Field::inst( 'tbl_master_tracks.tmt_artist_id' )
            ->options( Options::inst()
                ->table( 'tbl_master_artist' )
                ->value( 'tma_id' )
                ->label( 'tma_name' )
            )
            ->validator( 'Validate::dbValues' ),
        Field::inst( 'tbl_master_artist.tma_name' ),
                
                	Field::inst( 'tbl_master_tracks.tmt_catid' )
            ->options( Options::inst()
                ->table( 'tbl_songTypes' )
                ->value( 'st_id' )
                ->label( 'st_name' )
            )
            ->validator( 'Validate::dbValues' ),
                  Field::inst( 'tbl_songTypes.st_name' ),
                
                Field::inst( 'tbl_master_tracks.tmt_duration' )->validator( 'Validate::notEmpty' ),
                Field::inst( 'tbl_master_tracks.tmt_songid' )->validator( 'Validate::notEmpty' ),
                Field::inst( 'tbl_master_tracks.tmt_metadata' )->validator( 'Validate::notEmpty' ),
                Field::inst( 'tbl_master_tracks.tmt_mediafile' )->validator( 'Validate::notEmpty' ),
                   Field::inst( 'tbl_master_tracks.tmt_language' )->validator( 'Validate::notEmpty' ),
                
                	Field::inst( 'tbl_master_tracks.tmt_icon' )
		->setFormatter( 'Format::ifEmpty', null )
		
			->upload( Upload::inst( $_SERVER['DOCUMENT_ROOT'].'/musicscorer/img/__NAME__' )
				->db( 'files', 'id', array(
					'filename'    => Upload::DB_FILE_NAME,
                                    'filesize'    => Upload::DB_FILE_SIZE,
							'web_path'    => Upload::DB_WEB_PATH,
							'system_path' => Upload::DB_SYSTEM_PATH
					
				) )
				->validator( function ( $file ) {
					return$file['size'] >= 121000000 ?
						"Files must be smaller than 500K" :
						null;
				} )
				->allowedExtensions( array( 'wmv','png', 'jpg', 'gif' ), "Please upload an image" )
			),
                
		//  Field::inst( 'tbl_master_tracks.tmt_catid' )->validator( 'Validate::notEmpty' ),
		
		
		 
                                          Field::inst( 'tbl_master_tracks.active' )
                                        ->setFormatter( function ( $val, $data, $opts ) {
                return ! $val ? 0 : 1;
            } ),
                     Field::inst( 'tbl_master_tracks.tmt_order' )->validator( 'Validate::numeric' )
	)
                    
    ->on( 'preRemove', function ( $editor, $id, $values ) {
        // On remove, the sequence needs to be updated to decrement all rows
        // beyond the deleted row. Get the current reading order by id (don't
        // use the submitted value in case of a multi-row delete).
        $order = $editor->db()
            ->select( 'tbl_master_tracks', 'tbl_master_tracks.tmt_order', array('tmt_id' => $id) )
            ->fetch();
 
        $editor->db()
            ->query( 'update', 'tbl_master_tracks' )
            ->set( 'tbl_master_tracks.tmt_order', 'tbl_master_tracks.tmt_order-1', false )
            ->where( 'tbl_master_tracks.tmt_order', $order['tbl_master_tracks.tmt_order'], '>' )
            ->exec();
    } )
	 ->leftJoin( 'tbl_master_music_cat', 'tbl_master_music_cat.tmmc_id', '=', 'tbl_master_tracks.tmt_generid' )
             ->leftJoin( 'tbl_songTypes', 'tbl_songTypes.st_id', '=', 'tbl_master_tracks.tmt_catid' )
             ->leftJoin( 'tbl_master_artist', 'tbl_master_artist.tma_id', '=', 'tbl_master_tracks.tmt_artist_id' )
	->process( $_POST )
	->json();
