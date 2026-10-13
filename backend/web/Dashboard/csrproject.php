<?php
//session_start();

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
	<title>  Dashboard</title>

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
    
     button.inputButton {
        float: left;
        text-align: center;
        display: block;
        cursor: pointer;
        margin: 0 10px 5px 0;
        padding: 2px 0;
        background: #F8F8F8;
        background: -webkit-gradient(linear, center bottom, center top, from(#CCC), to(white));
        background: -moz-linear-gradient(top, white, #CCC);
        background: linear-gradient(to bottom, white, #CCC);
        text-shadow: 0 1px 0 white;
        border: 1px solid #999;
        border-radius: 3px;
        -moz-border-radius: 3px;
        -webkit-border-radius: 3px;
        box-shadow: 0px 0px 2px #999;
        -moz-box-shadow: 0px 0px 2px #999;
        -webkit-box-shadow: 0px 0px 2px #999;
        width: 60px;
         font-weight: bold !important;
         
    }
 
    button.inputButton.selected {
        font-weight: bold !important;
        background: #02475A;
        background: -webkit-gradient(linear, center bottom, center top, from(#777), to(#333));
        background: -moz-linear-gradient(top, #333, #777);
        background: linear-gradient(to bottom, #333, #777);
        box-shadow: inset 0px 0px 2px #222;
        -moz-box-shadow: inset 0px 0px 2px #222;
        -webkit-box-shadow: inset 0px 0px 2px #222;
        color: white !important;
        text-shadow: none;
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
            
		ajax: "examples/php/csrproject.php",
                
		
		table: "#example",
                template: '#customForm',
		fields: [ {
                label: 'Order:',
                 def: "10",
                name: 'csrproject.camp_order',
                fieldInfo: 'This field can only be edited via click and drag row reordering.'
            },{
                label:     "Project Status:",
                name:      "csrproject.camp_status",
                type:      "checkbox",
                separator: "|",
                options:   [
                    { label: '', value: 1 }
                ]
            },
             {
		
				label: "Project Name:",
				name: "csrproject.pname"

			},
          {
                label: "Function/Domain:",
                name: "csrproject.functions",
                type: "select",
                 multiple: true,
    separator: ',',
                placeholder: "-- Select Domains --",
             //    multiple: true,
   // separator: ',',
              
            },
           
                    {
                label: "State:",
                name: "csrproject.state",
                type: "select",
                placeholder: "-- Select State --",
             //    multiple: true,
   // separator: ',',
              
            },
               {
                label: "City:",
                name: "csrproject.city",
                 multiple: true,
    separator: ',',
                type: "select",
                placeholder: "-- Select City --",
             //    multiple: true,
   // separator: ',',
              
            },
             
                         
                        {
		
				label: "Project Detail/Summary:",
				name: "csrproject.pdetail",
                                type:"textarea"

			},
                       
                            
                          {
                label: "Project Budget:",
                name: "csrproject.budget",
                type: "select",
           //      multiple: true,
   // separator: ',',
                placeholder: "-- Select Budget --",
             //    multiple: true,
   // separator: ',',
              
            },
                            {
				label:     'Project Start date:',
                name:      'csrproject.startdate',
				// label:     'Updated date:',
               // name:      'updated_date',
               type:   'datetime',
                def:    function () { return new Date(); },
                format: 'dddd D MMMM YYYY',
                 fieldInfo: 'Starts from 00:00 AM',
                keyInput: false
			
			},
                            {
				 label: 'Project End date:',
                name:  'csrproject.enddate',
				// label:     'Updated date:',
               // name:      'updated_date',
               type:   'datetime',
                def:    function () { return new Date(); },
                format: 'dddd D MMMM YYYY',
                fieldInfo: 'End from 00:00 AM',
                keyInput: false
			
			},
                          
                    {
		
				label: "NGO:",
				name: "csrproject.ngo",
                              

			},    
                        {
		
				label: "NGO Years in Operation :",
				name: "csrproject.ngoyears",
                              

			},  
                        {
		
				label: "NGO Legal Status :",
				name: "csrproject.legal",
                              

			},  
                        {
		
				label: "Benificiaries :",
				name: "csrproject.benificiaries",
                              

			},  
                         {
		
				label: "Project Search Tags :",
				name: "csrproject.searchtags",
                              

			},  
                            
                            
			
                           
		]
	}
        
        );
        
        
     
  
        
        
    
     

	var table = $('#example').DataTable( {
        
		dom: "Bfrtip",
               
		ajax: "examples/php/csrproject.php",
		// contentType: "application/json; charset=utf-8",
		columns: [
                     { data: 'csrproject.camp_order', className: 'reorder' },
                   
                     { data: "csrproject.pname" },
                       { data: "csrproject.ngo" },   
                       { data: "csrproject.ngoyears" }, 
                         { data: "csrproject.legal" }, 
                           { data: "csrproject.benificiaries" },  
                     { data: "domains.name" },
                    { data: "states.name" },
                     { data: "cities.name" },
                     { data: "csrproject.pdetail" },
                     
                    
		
                         
                            { data: "budget.bfrom" },   
                            
                       { data: "csrproject.startdate" },
                         { data: "csrproject.enddate" },
                         
                           { data: "csrproject.searchtags" },   
              
			
                       
                        
			
                            {
                data:   "csrproject.camp_status",
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
            dataSrc: 'csrproject.camp_order',
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
            $('input.editor-active', row).prop( 'checked', data.csrproject.camp_status == 1 );
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
            editor.field( 'csrproject.camp_order' ).enable();
        } )
        .on( 'initEdit', function () {
            // Disable for edit (re-ordering is performed by click and drag)
            editor.field( 'csrproject.camp_order' ).disable();
        } );
        
          $('#example').on( 'change', 'input.editor-active', function () {
        editor
            .edit( $(this).closest('tr'), false )
            .set( 'csrproject.camp_status', $(this).prop( 'checked' ) ? 1 : 0 )
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
							<h3>CSR Project Detail Management</h3>
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
    font-weight: 600;">CSR Project Information</legend>
     
     <editor-field name="csrproject.pname"></editor-field>
         <editor-field name="csrproject.state"></editor-field>   
           <editor-field name="csrproject.city"></editor-field>  
           <editor-field name="csrproject.functions"></editor-field>    
          
                            
                           
                        </fieldset>
                   <fieldset class="hr">
                            <legend style="    border-radius: 3px;
    border: 1px solid #00a8ff;
    background: #00a8ff;
    color: #fff;
    font-size:16px;
    font-weight: 600;" >CSR Project Visibility</legend>
                           
                          
                              <editor-field name="csrproject.camp_order"></editor-field>
                             <editor-field name="csrproject.camp_status"></editor-field>
                                 <editor-field name="csrproject.startdate"></editor-field>
                              <editor-field name="csrproject.enddate"></editor-field>
                           
                        </fieldset>
                  
                        <fieldset class="name">
                            <legend style="border-radius: 3px;
    border: 1px solid #00a8ff;
       background-color: #ac6bec;
    border-color: #ac6bec;
     font-size:16px;
    color: #fff;
    font-weight: 600;">CSR Project Details</legend>
                            
                                   <editor-field name="csrproject.budget"></editor-field>                          
                            <editor-field name="csrproject.ngo"></editor-field>
                                <editor-field name="csrproject.ngoyears"></editor-field>
                                <editor-field name="csrproject.legal"></editor-field>
                                   <editor-field name="csrproject.benificiaries"></editor-field> 
                            <editor-field name="csrproject.pdetail"></editor-field>
                              <editor-field name="csrproject.searchtags"></editor-field>
                           
                           
                                
                                 
                          
                   
                            
                            
                        
                               
                        </fieldset>
                  
                       
                    </div>
            
			
			
			<table id="example" class="display" cellspacing="0" width="100%">
				<thead>
					<tr>
				<th>Order</th>
                                <th>Project Name</th>
                                 <th>NGO</th>
                                    <th>NGO Years in Operation</th>
                                     <th>NGO Legal Status</th>
                                      <th>Benificiaries</th>
                                <th>Function/Domain</th>
                                 <th>State</th>
                                <th>City</th>
                                 <th>Project Detail/Summary</th>
                       
                                <th>Budget</th>
                                 <th>Project Start Date</th>
                                  <th>Project Stop Date</th>
                                  
                                         <th>Search Tags</th>
                                   
                                                  <th>Active</th>
                                                
					</tr>
				</thead>
				<tfoot>
							<th>Order</th>
                                <th>Project Name</th>
                                 <th>NGO</th>
                                    <th>NGO Years in Operation</th>
                                     <th>NGO Legal Status</th>
                                      <th>Benificiaries</th>
                                <th>Function/Domain</th>
                                 <th>State</th>
                                <th>City</th>
                                 <th>Project Detail/Summary</th>
                        
                                <th>Budget</th>
                                 <th>Project Start Date</th>
                                  <th>Project Stop Date</th>
                                  
                                     <th>Search Tags</th>
                                                  <th>Active</th>
					</tr>
				</tfoot>
			</table>
	
			
				
			</div>
		
</div><!--.page-content-->


<script src="js/app.js"></script>




</body>
</html>