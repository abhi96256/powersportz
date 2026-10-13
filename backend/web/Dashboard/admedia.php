<?php
session_start();

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
	<title> FOCO Dashboard</title>

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
            
		ajax: "examples/php/admedia.php",
                
		
		table: "#example",
                template: '#customForm',
		fields: [ {
                label: 'Order:',
                 def: "10",
                name: 'f_ads.ad_order',
                fieldInfo: 'This field can only be edited via click and drag row reordering.'
            },{
                label:     "Status:",
                name:      "f_ads.ad_status",
                type:      "checkbox",
                separator: "|",
                options:   [
                    { label: '', value: 1 }
                ]
            }, {
		
				label: "Ad Name:",
				name: "f_ads.ad_name"

			},
            {
		
				label: "Ad Title:",
				name: "f_ads.ad_title"

			},
                         
                        {
		
				label: "Ad Text Description:",
				name: "f_ads.ad_descr",
                                type:"textarea"

			},
                       
      
                        
                        
                        
                        {
				label: "Ad Type:",
				name: "f_ads.ad_type",
				//label: "Show options:",
              //  name: "options",
                type: "select",
                options: [ "ALL","Image", "Text" ,"Video"    ],
                def: "ALL"
			},
                        {
				label: "Ad Image:",
				name: "f_ads.ad_img",
				type: "upload",
				display: function ( file_id ) {
					return '<img width="150px" src="'+editor.file( 'files', file_id ).web_path+'"/>';
				},
				clearText: "Clear",
				noImageText: 'No Image'
			},
                            {
				label: "Ad Video:",
				name: "f_ads.ad_video",
				type: "upload",
				display: function ( file_id ) {
                                   
					return '<video width="150px" controls > <source src="'+editor.file( 'files', file_id ).web_path+'" > type="video/mp4" ></video>';
				},
				clearText: "Clear",
				noImageText: 'No Video'
			},
                            
                        
			
                           
		]
	}
        
        );
        
        
     
    
    editor.field( 'f_ads.ad_type' ).input().on( 'change', function () {
    if ( editor.field( 'f_ads.ad_type' ).val() === 'Video' ) {
        editor.field( 'f_ads.ad_video' ).show();
       editor.field( 'f_ads.ad_descr' ).show();
         editor.field( 'f_ads.ad_img' ).hide();
         
    }
    if ( editor.field( 'f_ads.ad_type' ).val() === 'Image' ) {
        editor.field( 'f_ads.ad_img' ).show();
                 editor.field( 'f_ads.ad_descr' ).show();
        editor.field( 'f_ads.ad_video' ).hide();

     
    }
    if ( editor.field( 'f_ads.ad_type' ).val() === 'Text' ) {
        editor.field( 'f_ads.ad_descr' ).show();
        editor.field( 'f_ads.ad_video' ).hide();
         editor.field( 'f_ads.ad_img' ).hide();
        
    }if ( editor.field( 'f_ads.ad_type' ).val() === 'ALL' ) {
        editor.field( 'f_ads.ad_descr' ).show();
        editor.field( 'f_ads.ad_video' ).show();
         editor.field( 'f_ads.ad_img' ).show();
        
    }
    
    
    
} );
        
        
    
     

	var table = $('#example').DataTable( {
        
		dom: "Bfrtip",
               
		ajax: "examples/php/admedia.php",
		// contentType: "application/json; charset=utf-8",
		columns: [
                     { data: 'f_ads.ad_order', className: 'reorder' },
                       { data: "f_ads.ad_name" },
                     { data: "f_ads.ad_title" },
                    
                     { data: "f_ads.ad_descr" },
                     
                     { data: "f_ads.ad_type" },
			
			 {
				data: "f_ads.ad_img",
				render: function ( file_id ) {
					return file_id ?
					//	'<video width="150px" controls> <source src="'+editor.file( 'files', file_id ).web_path+'"  />' :
                                        '<img width="150px"   src="'+editor.file( 'files', file_id ).web_path+'"  />' :
						null;
				},
				defaultContent: "No Image",
				//title: "Icon"
			}, {
				data: "f_ads.ad_video",
				render: function ( file_id ) {
					return file_id ?
						'<video width="150px" controls> <source src="'+editor.file( 'files', file_id ).web_path+'"  />' :
                                      //  '<img width="150px"   src="'+editor.file( 'files', file_id ).web_path+'"  />' :
						null;
				},
				defaultContent: "No Video",
				//title: "Icon"
			},
                         
                           
                            
                     
                   //     { data: "f_ads.ad_link" },
			
                       
                        
			
                            {
                data:   "f_ads.ad_status",
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
            dataSrc: 'f_ads.ad_order',
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
            $('input.editor-active', row).prop( 'checked', data.f_ads.ad_status == 1 );
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
            editor.field( 'f_ads.ad_order' ).enable();
        } )
        .on( 'initEdit', function () {
            // Disable for edit (re-ordering is performed by click and drag)
            editor.field( 'f_ads.ad_order' ).disable();
        } );
        
          $('#example').on( 'change', 'input.editor-active', function () {
        editor
            .edit( $(this).closest('tr'), false )
            .set( 'f_ads.ad_status', $(this).prop( 'checked' ) ? 1 : 0 )
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
							<h3>Ads Media Repository & Management</h3>
						</div>
					</div>
				</header>
            
            
    
            
              <div id="customForm">
                      <fieldset class="hr">
                           <legend style="border-radius: 3px;
    border: 1px solid #00a8ff;
          background-color: #f4a641;
    border-color: #f4a641;
     font-size:16px;
    color: #fff;
    font-weight: 600;">Ads Information</legend>
       <editor-field name="f_ads.ad_name"></editor-field>
     <editor-field name="f_ads.ad_title"></editor-field>
        <editor-field name="f_ads.ad_type"></editor-field>                
                            
                           
                        </fieldset>
                   <fieldset class="hr">
                            <legend style="    border-radius: 3px;
    border: 1px solid #00a8ff;
    background: #00a8ff;
    color: #fff;
    font-size:16px;
    font-weight: 600;" >Ads Visibility</legend>
                           
                          
                              
                              <editor-field name="f_ads.ad_order"></editor-field>
                             <editor-field name="f_ads.ad_status"></editor-field>
                               
                           
                        </fieldset>
                  
                        <fieldset class="name">
                            <legend style="border-radius: 3px;
    border: 1px solid #00a8ff;
       background-color: #ac6bec;
    border-color: #ac6bec;
     font-size:16px;
    color: #fff;
    font-weight: 600;">Ads Media</legend>
                            
                           
                            <editor-field name="f_ads.ad_img"></editor-field>
                            <editor-field name="f_ads.ad_video"></editor-field>
                                
                            <editor-field name="f_ads.ad_descr"></editor-field>
                          
                   
                            
                            
                        
                               
                        </fieldset>
                  
                       
                    </div>
            
			
			
			<table id="example" class="display" cellspacing="0" width="100%">
				<thead>
					<tr>
				<th>Ad Order</th>
                                 <th>Ad Name</th>
                                <th>Ad Title</th>
                                <th>Ad Detail</th>
                                <th>Ad Type</th>
						 <th>Ad Image</th>
                                                 
                                                    <th>Ad Video</th>
                                              
						
                                                  <th>Active</th>
                                                
					</tr>
				</thead>
				<tfoot>
					<th>Ad Order</th>
                                 <th>Ad Name</th>
                                <th>Ad Title</th>
                                <th>Ad Detail</th>
                                <th>Ad Type</th>
						 <th>Ad Image</th>
                                                 
                                                    <th>Ad Video</th>
                                                 
						
                                                  <th>Active</th>
					</tr>
				</tfoot>
			</table>
	
			
				
			</div>
		
</div><!--.page-content-->


<script src="js/app.js"></script>




</body>
</html>