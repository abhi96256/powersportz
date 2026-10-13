<?php

	require_once("Login/session.php");
	
	require_once("Login/class.user.php");

	
	$auth_user = new USER();
	
	
	$user_id = $_SESSION['user_session'];
	
	$stmt = $auth_user->runQuery("SELECT * FROM admin_users WHERE user_id=:user_id");
	$stmt->execute(array(":user_id"=>$user_id));
	
	$userRow=$stmt->fetch(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>

<html>
<head lang="en">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title> Dashboard</title>

	<link href="img/favicon.144x144.png" rel="apple-touch-icon" type="image/png" sizes="144x144">
	<link href="img/favicon.114x114.png" rel="apple-touch-icon" type="image/png" sizes="114x114">
	<link href="img/favicon.72x72.png" rel="apple-touch-icon" type="image/png" sizes="72x72">
	<link href="img/favicon.57x57.png" rel="apple-touch-icon" type="image/png">
	<link href="img/favicon.png" rel="icon" type="image/png">
	<link href="img/favicon.ico" rel="shortcut icon">

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
        <style>
            #customForm {
    display: flex;
    flex-flow: row wrap;
}
 
#customForm fieldset {
    flex: 1;
    border: 1px solid #aaa;
    margin: 0.5em;
}
 
#customForm fieldset legend {
    padding: 5px 20px;
    border: 1px solid #aaa;
    font-weight: bold;
}
 
#customForm fieldset.name {
    flex: 2 100%;
}
 
#customForm fieldset.name legend {
    background: #bfffbf;
}
 
#customForm fieldset.office legend {
    background: #ffffbf;
}
 
#customForm fieldset.hr legend {
    background: #ffbfbf;
}
 
#customForm div.DTE_Field {
    padding: 5px;
}

.dt-button.red {
        color: red;
        
        
    }
 
    .dt-button.orange {
        color: orange;
        
    }
 
    .dt-button.green {
        color: #16b4fc;
     
    }
            
        </style>>
    <link rel="stylesheet" href="css/lib/font-awesome/font-awesome.min.css">
    <link rel="stylesheet" href="css/lib/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="css/main.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.14/css/jquery.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.3.1/css/buttons.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/select/1.2.2/css/select.dataTables.min.css">
                <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/rowreorder/1.2.3/css/rowReorder.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="css/editor.dataTables.min.css">

	<script type="text/javascript" language="javascript" src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js">
	</script>
<script type="text/javascript" language="javascript" src="//code.jquery.com/jquery-1.12.4.js">
	</script>
        <script src="js/lib/jquery/jquery.min.js"></script>
	<script src="js/lib/tether/tether.min.js"></script>
	<script src="js/lib/bootstrap/bootstrap.min.js"></script>
	<script src="js/plugins.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.14/js/jquery.dataTables.min.js">
	</script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js">
	</script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/select/1.2.2/js/dataTables.select.min.js">
	</script>
          <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/rowreorder/1.2.3/js/dataTables.rowReorder.min.js">
	</script>
	<script type="text/javascript" language="javascript" src="js/dataTables.editor.min.js">
	</script>
	

	
	<script type="text/javascript" language="javascript" class="init">
	



var editor; // use a global for the submit and return data rendering in the examples

$(document).ready(function() {
    
    
	editor = new $.fn.dataTable.Editor( {
            
		ajax: "examples/php/banners.php",
                
		
		table: "#example",
                template: '#customForm',
		fields: [ {
                label: 'Order:',
                 def: "10",
                name: 'tbl_banner.tb_order',
                fieldInfo: 'This field can only be edited via click and drag row reordering.'
            },{
                label:     "Status:",
                name:      "tbl_banner.tb_active",
                type:      "checkbox",
                separator: "|",
                options:   [
                    { label: '', value: 1 }
                ]
            }, {
				label: "Genre:",
				//label: "Site:",
                name: "tbl_banner.tb_generid",
                type: "select"
			//	name: "catid"
			},
                        {
				label: "Artist:",
				//label: "Site:",
                name: "tbl_banner.tb_artistid",
                type: "select"
			//	name: "catid"
			},
            {
				label: "Song Name:",
				name: "tbl_banner.tb_songid",
				//label: "Show options:",
              //  name: "options",
               type: "select"
			},
                        
                        {
		
				label: "Enternal URL:",
				name: "tbl_banner.tb_url",
				//  def: "Quiz"

			},
                        
                        {
				label: "Banner Action:",
				name: "tbl_banner.tb_type",
				//label: "Show options:",
              //  name: "options",
                type: "select",
                options: [ "Song Page", "Artist Page" ,"External URL","None"   ],
                def: "None"
			},
                        {
				label: "Banner Image:",
				name: "tbl_banner.tb_img",
				type: "upload",
				display: function ( file_id ) {
					return '<img width="150px" src="'+editor.file( 'files', file_id ).web_path+'"/>';
				},
				clearText: "Clear",
				noImageText: 'No Icon'
			},
                        
			
                           
		]
	} );
        
            editor.dependent( 'tbl_banner.tb_type', function ( val ) {
         //   alert(val); //die;
         
    //return
    if(val === 'Song Page' ){
         //alert(val);
            
        return   {   hide: ['tbl_banner.tb_url', 'tbl_banner.tb_artistid', 'tbl_banner.tb_generid']} ;
        
    }else if(val === 'External URL' ){
         // alert(val);
         
    return {  hide: ['tbl_banner.tb_songid', 'tbl_banner.tb_artistid', 'tbl_banner.tb_generid'] };
          
        }else if(val === 'Artist Page' ){
         // alert(val);
         
    return {  hide: ['tbl_banner.tb_songid', 'tbl_banner.tb_url', 'tbl_banner.tb_generid'] };
          
        }
        else{
            return {  show: ['tbl_banner.tb_songid', 'tbl_banner.tb_artistid', 'tbl_banner.tb_url'] };
        }
    
  //  return val;
    
 
    } );
    
     

	var table = $('#example').DataTable( {
        
		dom: "Bfrtip",
               
		ajax: "examples/php/banners.php",
		// contentType: "application/json; charset=utf-8",
		columns: [
                     { data: 'tbl_banner.tb_order', className: 'reorder' },
			
			 {
				data: "tbl_banner.tb_img",
				render: function ( file_id ) {
					return file_id ?
						'<img width="150px" src="'+editor.file( 'files', file_id ).web_path+'"/>' :
						null;
				},
				defaultContent: "No Icon",
				//title: "Icon"
			},
                         
                             { data: "tbl_banner.tb_type" },
                            
                            { data: "tbl_master_music_cat.tmmc_name" },
                        { data: "tbl_master_artist.tma_name" },
			{ data: "tbl_master_tracks.tmt_name" },
                       
                         { data: "tbl_banner.tb_url" },
			
                            {
                data:   "tbl_banner.tb_active",
                render: function ( data, type, row ) {
                    if ( type === 'display' ) {
                        return '<input type="checkbox" class="editor-active">';
                    }
                    return data;
                },
                className: "dt-body-center"
            }
		],
                 columnDefs: [
            { orderable: false, targets: [ 1,2,3 ] }
        ],
        rowReorder: {
            dataSrc: 'tbl_banner.tb_order',
            editor:  editor
        },
     
		select: {
            style: 'os',
            selector: 'td:not(:last-child)' // no row selection on last column
        },
        
		buttons: [
                 
			{ extend: "create", className: 'green' ,  editor: editor },
			{ extend: "edit", className: 'orange'  ,  editor: editor },
			{ extend: "remove", 
                className: 'red' , editor: editor },
			{
                extend: 'collection',
                text: 'Export',
                buttons: [
                    'copy',
                    'excel',
                    'csv',
                    'pdf',
                    'print'
                ]
            },
            
             
            
            
            
		], rowCallback: function ( row, data ) {
            // Set the checked state of the checkbox in the table
            $('input.editor-active', row).prop( 'checked', data.tbl_banner.tb_active == 1 );
        }
		
	} );
         editor
        .on( 'postCreate postRemove', function () {
            // After create or edit, a number of other rows might have been effected -
            // so we need to reload the table, keeping the paging in the current position
            table.ajax.reload( null, false );
        } )
        .on( 'initCreate', function () {
            // Enable order for create
            editor.field( 'tbl_banner.tb_order' ).enable();
        } )
        .on( 'initEdit', function () {
            // Disable for edit (re-ordering is performed by click and drag)
            editor.field( 'tbl_banner.tb_order' ).disable();
        } );
        
          $('#example').on( 'change', 'input.editor-active', function () {
        editor
            .edit( $(this).closest('tr'), false )
            .set( 'tbl_banner.tb_active', $(this).prop( 'checked' ) ? 1 : 0 )
            .submit();
    } );
} );



	</script>
		<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js">
	</script>
        </script>
		<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.colVis.min.js">
	</script>
	<script type="text/javascript" language="javascript" src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js">
	</script>
	<script type="text/javascript" language="javascript" src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/pdfmake.min.js">
	</script>
	<script type="text/javascript" language="javascript" src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/vfs_fonts.js">
	</script>
	<script type="text/javascript" language="javascript" src="//cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js">
	</script>
	<script type="text/javascript" language="javascript" src="//cdn.datatables.net/buttons/1.3.1/js/buttons.print.min.js">
	</script>
	<script type="text/javascript" language="javascript" src="../resources/syntax/shCore.js">
	</script>
	
</head>
<body class="with-side-menu control-panel control-panel-compact">

<?php include("inc/head.php"); ?>
	
	<div class="mobile-menu-left-overlay"></div>
<?php include("inc/left.php"); ?>

	
	<div class="page-content">
	
	<div class="container">
	
				<header class="box-typical-header">
					<div class="tbl-row">
						<div class="tbl-cell tbl-cell-title">
							<h3>Banner Management</h3>
						</div>
					</div>
				</header>
            
            
    
            
              <div id="customForm">
                  
                   <fieldset class="hr">
                            <legend style="    border-radius: 3px;
    border: 1px solid #00a8ff;
    background: #00a8ff;
    color: #fff;
    font-size:16px;
    font-weight: 600;" >Banner Details</legend>
                           
                            <editor-field name="tbl_banner.tb_img"></editor-field>
                              <editor-field name="tbl_banner.tb_type"></editor-field>
                              <editor-field name="tbl_banner.tb_order"></editor-field>
                             <editor-field name="tbl_banner.tb_active"></editor-field>
                           
                        </fieldset>
                        <fieldset class="name">
                            <legend style="border-radius: 3px;
    border: 1px solid #00a8ff;
       background-color: #ac6bec;
    border-color: #ac6bec;
     font-size:16px;
    color: #fff;
    font-weight: 600;">Banner Action</legend>
                            
                           
                           <editor-field name="tbl_banner.tb_url"></editor-field>
                            <editor-field name="tbl_banner.tb_songid"></editor-field>
                             <editor-field name="tbl_banner.tb_generid"></editor-field>
                              <editor-field name="tbl_banner.tb_artistid"></editor-field>
                        
                               
                        </fieldset>
                  
                       
                    </div>
            
			
			
			<table id="example" class="display" cellspacing="0" width="100%">
				<thead>
					<tr>
				<th>Order</th>
						 <th>Banner Image</th>
                                                   <th>Action Type</th>
						<th>Genre Name</th>
                                                <th>Artist Name</th>
                                                <th>Song Name</th>
                                                
						
						
						<th>Action URL</th>
                                                  
                                                
                                                  
						
                                                  <th>Active</th>
                                                
					</tr>
				</thead>
				<tfoot>
					<th>Order</th>
						<th>Banner Image</th>
                                                   <th>Action Type</th>
						<th>Genre Name</th>
                                                <th>Artist Name</th>
                                                <th>Song Name</th>
                                                
						
						
						<th>Action URL</th>
                                                  
                                                
                                                  
						
                                                  <th>Active</th>
					</tr>
				</tfoot>
			</table>
	
			
				
			</div>
		
</div><!--.page-content-->


<script src="js/app.js"></script>




</body>
</html>