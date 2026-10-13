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
	
// Todo field type plug-in code
(function ($, DataTable) {
 
if ( ! DataTable.ext.editorFields ) {
    DataTable.ext.editorFields = {};
}
 
var Editor = DataTable.Editor;
var _fieldTypes = DataTable.ext.editorFields;

 
_fieldTypes.todokmrange = {
    create: function ( conf ) {
        var that = this;
 
        conf._enabled = true;
 
        // Create the elements to use for the input
        conf._input = $(
            '<div id="'+Editor.safeId( conf.id )+'">'+
                '<button type="button" class="inputButton" value="0">Traffic</button>'+
                '<button type="button" class="inputButton" value="1">Leads</button>'+
                  '<button type="button" class="inputButton" value="2">Branding</button>'+
                   '<button type="button" class="inputButton" value="3">Views</button>'+
                    '<button type="button" class="inputButton" value="4">All</button>'+
            '</div>');
 
        // Use the fact that we are called in the Editor instance's scope to call
        // the API method for setting the value when needed
        $('button.inputButton', conf._input).click( function () {
            if ( conf._enabled ) {
                that.set( conf.name, $(this).attr('value') );
            }
 
            return false;
        } );
 
        return conf._input;
    },
 
    get: function ( conf ) {
        return $('button.selected', conf._input).attr('value');
    },
 
    set: function ( conf, val ) {
        $('button.selected', conf._input).removeClass( 'selected' );
        $('button.inputButton[value='+val+']', conf._input).addClass('selected');
    },
 
    enable: function ( conf ) {
        conf._enabled = true;
        $(conf._input).removeClass( 'disabled' );
    },
 
    disable: function ( conf ) {
        conf._enabled = false;
        $(conf._input).addClass( 'disabled' );
    }
};
 
 _fieldTypes.todohours = {
    create: function ( conf ) {
        var that = this;
 
        conf._enabled = true;
 
        // Create the elements to use for the input
        conf._input = $(
            '<div id="'+Editor.safeId( conf.id )+'">'+
                '<button type="button" class="inputButton" value="0">Morning</button>'+
                '<button type="button" class="inputButton" value="1">Afternoon</button>'+
                  '<button type="button" class="inputButton" value="2">Evening</button>'+
                   '<button type="button" class="inputButton" value="3">Night</button>'+
                    '<button type="button" class="inputButton" value="4">All</button>'+
            '</div>');
 
        // Use the fact that we are called in the Editor instance's scope to call
        // the API method for setting the value when needed
        $('button.inputButton', conf._input).click( function () {
            if ( conf._enabled ) {
                that.set( conf.name, $(this).attr('value') );
            }
 
            return false;
        } );
 
        return conf._input;
    },
 
    get: function ( conf ) {
        return $('button.selected', conf._input).attr('value');
    },
 
    set: function ( conf, val ) {
        $('button.selected', conf._input).removeClass( 'selected' );
        $('button.inputButton[value='+val+']', conf._input).addClass('selected');
    },
 
    enable: function ( conf ) {
        conf._enabled = true;
        $(conf._input).removeClass( 'disabled' );
    },
 
    disable: function ( conf ) {
        conf._enabled = false;
        $(conf._input).addClass( 'disabled' );
    }
};
 
 

})(jQuery, jQuery.fn.dataTable);


var editor; // use a global for the submit and return data rendering in the examples

$(document).ready(function() {
    
    
	editor = new $.fn.dataTable.Editor( {
            
		ajax: "examples/php/active_cmp.php",
                
		
		table: "#example",
                template: '#customForm',
		fields: [ {
                label: 'Order:',
                 def: "10",
                name: 'f_campaign.camp_order',
                fieldInfo: 'This field can only be edited via click and drag row reordering.'
            },{
                label:     "Status:",
                name:      "f_campaign.camp_status",
                type:      "checkbox",
                separator: "|",
                options:   [
                    { label: '', value: 1 }
                ]
            },
             {
		
				label: "Campaign Title:",
				name: "f_campaign.camp_name"

			},
          
           
                         {
                label: "Campaign Media ( <a href='admedia.php' target='_blank' > List? </a> ):",
                name: "f_campaign.camp_ads_id",
                type: "select",
                placeholder: "-- Select Media --",
             //    multiple: true,
   // separator: ',',
              
            },       {
                label: "Campaign Audience ( <a href='audience.php' target='_blank' > List? </a> ):",
                name: "f_campaign.camp_aud_id",
                type: "select",
                placeholder: "-- Select Audience --",
             //    multiple: true,
   // separator: ',',
              
            },
                         
                        {
		
				label: "Cpamign Landing URL:",
				name: "f_campaign.camp_landingurl",
                                type:"textarea"

			},
                       
      
                        {
                label: "Campaign Objective  ( <a href='#'  > Type </a> ) :",
                name: "f_campaign.camp_objective",
                type: "todokmrange", // Using the custom field type
                def: 0
            },
                        
                        
                      
                        {
				label: "Campaign Logo:",
				name: "f_campaign.camp_logo",
				type: "upload",
				display: function ( file_id ) {
					return '<img width="150px" src="'+editor.file( 'files', file_id ).web_path+'"/>';
				},
				clearText: "Clear",
				noImageText: 'No Logo'
			},
                            
                            
                            
                          {
		
				label: "Campaign Target Number:",
				name: "f_campaign.camp_targetnumber"

			},
                            {
				label:     'Campaign Start date:',
                name:      'f_campaign.camp_date_start',
				// label:     'Updated date:',
               // name:      'updated_date',
               type:   'datetime',
                def:    function () { return new Date(); },
                format: 'dddd D MMMM YYYY',
                 fieldInfo: 'Starts from 00:00 AM',
                keyInput: false
			
			},
                            {
				 label: 'Campaign End date:',
                name:  'f_campaign.camp_date_stop',
				// label:     'Updated date:',
               // name:      'updated_date',
               type:   'datetime',
                def:    function () { return new Date(); },
                format: 'dddd D MMMM YYYY',
                fieldInfo: 'End from 00:00 AM',
                keyInput: false
			
			},
                            {
                label: "Campaign Active Period  :",
                name: "f_campaign.camp_active_hours",
                type: "todohours", // Using the custom field type
                def: 0
            },
                    {
		
				label: "Capamign CPC:",
				name: "f_campaign.camp_cpc",
                              

			},    
                            {
		
				label: "Capamign Daily Budget:",
				name: "f_campaign.camp_dailybudget",
                              

			},    
                            
			
                           
		]
	}
        
        );
        
        
     
  
        
        
    
     

	var table = $('#example').DataTable( {
        
		dom: "Bfrtip",
               
		ajax: "examples/php/active_cmp.php",
		// contentType: "application/json; charset=utf-8",
		columns: [
                     { data: 'f_campaign.camp_order', className: 'reorder' },
                   
                     { data: "f_campaign.camp_name" },
                    { data: "f_ads.ad_name" },
                     { data: "f_audience.aud_name" },
                     { data: "f_campaign.camp_landingurl" },
                     
                    
			 {
                className: "center",
                data: "f_campaign.camp_objective",
                render: function (data, type, row) {
                    if ( type === 'display' || type === 'filter' ) {
                        // Filtering and display get the rendered string
                        return data == 0 ? "Traffic" : ((data == 1) ? "Leads" : (data == 2) ? "Branding" :(data == 3) ? "Views" : "All");
                       

                    }
                    // Otherwise just give the original data
                    return data;
                }
            },
			 {
				data: "f_campaign.camp_logo",
				render: function ( file_id ) {
					return file_id ?
					//	'<video width="150px" controls> <source src="'+editor.file( 'files', file_id ).web_path+'"  />' :
                                        '<img width="150px"   src="'+editor.file( 'files', file_id ).web_path+'"  />' :
						null;
				},
				defaultContent: "No Image",
				//title: "Icon"
			}, 
                         
                            { data: "f_campaign.camp_targetnumber" },   
                            
                       { data: "f_campaign.camp_date_start" },
                         { data: "f_campaign.camp_date_stop" },
                        
                          	 {
                className: "center",
                data: "f_campaign.camp_active_hours",
                render: function (data, type, row) {
                    if ( type === 'display' || type === 'filter' ) {
                        // Filtering and display get the rendered string
                        return data == 0 ? "Morning" : ((data == 1) ? "Afternoon" : (data == 2) ? "Evening" :(data == 3) ? "Night" : "All");
                       

                    }
                    // Otherwise just give the original data
                    return data;
                }
            },   { data: "f_campaign.camp_cpc" },   
                { data: "f_campaign.camp_dailybudget" },   
                   //     { data: "f_campaign.ad_link" },
			
                       
                        
			
                            {
                data:   "f_campaign.camp_status",
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
            dataSrc: 'f_campaign.camp_order',
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
            $('input.editor-active', row).prop( 'checked', data.f_campaign.camp_status == 1 );
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
            editor.field( 'f_campaign.camp_order' ).enable();
        } )
        .on( 'initEdit', function () {
            // Disable for edit (re-ordering is performed by click and drag)
            editor.field( 'f_campaign.camp_order' ).disable();
        } );
        
          $('#example').on( 'change', 'input.editor-active', function () {
        editor
            .edit( $(this).closest('tr'), false )
            .set( 'f_campaign.camp_status', $(this).prop( 'checked' ) ? 1 : 0 )
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
							<h3>Campaign setup & management</h3>
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
    font-weight: 600;">Campaign Information</legend>
       <editor-field name="f_campaign.camp_targetnumber"></editor-field>
     <editor-field name="f_campaign.camp_name"></editor-field>
         <editor-field name="f_campaign.camp_ads_id"></editor-field>   
           <editor-field name="f_campaign.camp_aud_id"></editor-field>    
                            
                           
                        </fieldset>
                   <fieldset class="hr">
                            <legend style="    border-radius: 3px;
    border: 1px solid #00a8ff;
    background: #00a8ff;
    color: #fff;
    font-size:16px;
    font-weight: 600;" >Campaign Visibility</legend>
                           
                          
                              <editor-field name="f_campaign.camp_order"></editor-field>
                             <editor-field name="f_campaign.camp_status"></editor-field>
                               
                           
                        </fieldset>
                  
                        <fieldset class="name">
                            <legend style="border-radius: 3px;
    border: 1px solid #00a8ff;
       background-color: #ac6bec;
    border-color: #ac6bec;
     font-size:16px;
    color: #fff;
    font-weight: 600;">Campaign Media</legend>
                            
                                                          <editor-field name="f_campaign.camp_objective"></editor-field>  

                            <editor-field name="f_campaign.camp_logo"></editor-field>
                           
                                
                            <editor-field name="f_campaign.camp_landingurl"></editor-field>
                             <editor-field name="f_campaign.camp_date_start"></editor-field>
                              <editor-field name="f_campaign.camp_date_stop"></editor-field>
                              <editor-field name="f_campaign.camp_active_hours"></editor-field>
                                <editor-field name="f_campaign.camp_cpc"></editor-field>
                                  <editor-field name="f_campaign.camp_dailybudget"></editor-field>
                          
                   
                            
                            
                        
                               
                        </fieldset>
                  
                       
                    </div>
            
			
			
			<table id="example" class="display" cellspacing="0" width="100%">
				<thead>
					<tr>
				<th>Order</th>
                                <th>Campaign Title</th>
                                 <th>Campaign Media</th>
                                <th>Campaign Audience</th>
                                 <th>Landing URL</th>
                                <th>Campaign Objective</th>
                                <th>Campaign Logo</th>
                                <th>Target No</th>
                                 <th>Campaign Start Date</th>
                                  <th>Campaign Stop Date</th>
                                   <th>Campaign Active Hr</th>
                                   <th>Campaign CPC</th>
                                   <th>Campaign Daily Budget</th>
						 
                                                 
                                                   
                                              
						
                                                  <th>Active</th>
                                                
					</tr>
				</thead>
				<tfoot>
					<th>Order</th>
                                <th>Campaign Title</th>
                                  <th>Campaign Media</th>
                                <th>Campaign Audience</th>
                                 <th>Landing URL</th>
                                <th>Campaign Objective</th>
                                <th>Campaign Logo</th>
                                <th>Target No</th>
                                <th>Campaign Start Date</th>
                                  <th>Campaign Stop Date</th>
                                  <th>Campaign Active Hr</th>
				 <th>Campaign CPC</th>
                                   <th>Campaign Daily Budget</th>		
                                                 
                                                   
                                              
						
                                                  <th>Active</th>
					</tr>
				</tfoot>
			</table>
	
			
				
			</div>
		
</div><!--.page-content-->


<script src="js/app.js"></script>




</body>
</html>