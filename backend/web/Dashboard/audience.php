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
    label {
    margin: 5 !important;
     display: inline !important; 
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
        width: 50px;
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
 
_fieldTypes.todo = {
    create: function ( conf ) {
        var that = this;
 
        conf._enabled = true;
 
        // Create the elements to use for the input
        conf._input = $(
            '<div id="'+Editor.safeId( conf.id )+'">'+
                '<button type="button" class="inputButton" value="0">All</button>'+
                '<button type="button" class="inputButton" value="1">English</button>'+
                  '<button type="button" class="inputButton" value="2">Hindi</button>'+
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


_fieldTypes.todogender = {
    create: function ( conf ) {
        var that = this;
 
        conf._enabled = true;
 
        // Create the elements to use for the input
        conf._input = $(
            '<div id="'+Editor.safeId( conf.id )+'">'+
                '<button type="button" class="inputButton" value="0">All</button>'+
                '<button type="button" class="inputButton" value="1">Male</button>'+
                  '<button type="button" class="inputButton" value="2">Female</button>'+
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
 
 
 
_fieldTypes.todoplatform = {
    create: function ( conf ) {
        var that = this;
 
        conf._enabled = true;
 
        // Create the elements to use for the input
        conf._input = $(
            '<div id="'+Editor.safeId( conf.id )+'">'+
                '<button type="button" class="inputButton" value="0">All</button>'+
                '<button type="button" class="inputButton" value="1">Android</button>'+
                  '<button type="button" class="inputButton" value="2">iOS</button>'+
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
 
 
 
_fieldTypes.todoagerange = {
    create: function ( conf ) {
        var that = this;
 
        conf._enabled = true;
 
        // Create the elements to use for the input
        conf._input = $(
            '<div id="'+Editor.safeId( conf.id )+'">'+
                '<button type="button" class="inputButton" value="0">All</button>'+
                '<button type="button" class="inputButton" value="1">18-25</button>'+
                  '<button type="button" class="inputButton" value="2">25-32</button>'+
                   '<button type="button" class="inputButton" value="3">32-42</button>'+
                    '<button type="button" class="inputButton" value="4">42+</button>'+
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
 
 
_fieldTypes.todokmrange = {
    create: function ( conf ) {
        var that = this;
 
        conf._enabled = true;
 
        // Create the elements to use for the input
        conf._input = $(
            '<div id="'+Editor.safeId( conf.id )+'">'+
                '<button type="button" class="inputButton" value="0">All</button>'+
                '<button type="button" class="inputButton" value="1">0.5</button>'+
                  '<button type="button" class="inputButton" value="2">2</button>'+
                   '<button type="button" class="inputButton" value="3">5</button>'+
                    '<button type="button" class="inputButton" value="4">5+</button>'+
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
            
		ajax: "examples/php/audience.php",
                
		
		table: "#example",
                template: '#customForm',
		fields: [ {
                label: 'Order:',
                 def: "10",
                name: 'f_audience.aud_order',
                fieldInfo: 'This field can only be edited via click and drag row reordering.'
            },{
                label:     "Status:",
                name:      "f_audience.aud_status",
                type:      "checkbox",
                separator: "|",
                options:   [
                    { label: '', value: 1 }
                ]
            }, {
		
				label: "Ad Name:",
				name: "f_audience.aud_name"

			},
        
                 
                        {
                label: "Gender:",
                name: "f_audience.aud_gender",
                type: "todogender", // Using the custom field type
                def: 0
            }, 
                         {
                label: "Platforms:",
                name: "f_audience.aud_platform",
                type: "todoplatform", // Using the custom field type
                def: 0
            }, 
                        {
                label: "Language:",
                name: "f_audience.aud_language",
                type: "todo", // Using the custom field type
                def: 0
            }, 
                        {
                label: "Age Range ( <a href='#' > Years </a> ) :",
                name: "f_audience.aud_age_range",
                type: "todoagerange", // Using the custom field type
                def: 0
            }, 
                        {
                label: "Center Point ( <a href='https://www.latlong.net/' target='_blank' > Help? </a> ):",
                name: "f_audience.aud_geo_point",
                type: "select",
                placeholder: "-- Select Center Point --",
             //    multiple: true,
   // separator: ',',
              
            }, {
                label: "Center point Range  ( <a href='#'  > Kilometers </a> ) :",
                name: "f_audience.aud_range",
                type: "todokmrange", // Using the custom field type
                def: 0
            }, {
                label: "Interest ( <a href='#' target='_blank' > How ? </a> ):",
                name: "f_audience.aud_intrests",
                type: "select",
                placeholder: "-- Select Audience Intrests --",
                multiple: true,
                separator: ',',
              
            }, 
		]
	}
        
        );
        
        
     
    
   
        
        
    
     

	var table = $('#example').DataTable( {
        
		dom: "Bfrtip",
               
		ajax: "examples/php/audience.php",
		// contentType: "application/json; charset=utf-8",
		columns: [
                     { data: 'f_audience.aud_order', className: 'reorder' },
                       { data: "f_audience.aud_name" },
                   
                     
                    {
                className: "center",
                data: "f_audience.aud_gender",
                render: function (data, type, row) {
                    if ( type === 'display' || type === 'filter' ) {
                        // Filtering and display get the rendered string
                        return data == 0 ? "All" : ((data == 1) ? "Male" : "Female");
                       

                    }
                    // Otherwise just give the original data
                    return data;
                }
            },
                      { data: "f_audience.aud_platform" },
                      {
                className: "center",
                data: "f_audience.aud_language",
                render: function (data, type, row) {
                    if ( type === 'display' || type === 'filter' ) {
                        // Filtering and display get the rendered string
                        return data == 0 ? "All" : ((data == 1) ? "English" : "Hindi");
                       

                    }
                    // Otherwise just give the original data
                    return data;
                }
            },
                      // { data: "f_audience.aud_language" },
                       {
                className: "center",
                data: "f_audience.aud_age_range",
                render: function (data, type, row) {
                    if ( type === 'display' || type === 'filter' ) {
                        // Filtering and display get the rendered string
                        return data == 0 ? "All" : ((data == 1) ? "18-25" :  (data == 2) ? "25-32" :  (data == 3) ? "32-42" : "42+");
                       

                    }
                    // Otherwise just give the original data
                    return data;
                }
            },
             { data: "f_customers.fc_area" },
           
            {
                className: "center",
                data: "f_audience.aud_range",
                render: function (data, type, row) {
                    if ( type === 'display' || type === 'filter' ) {
                        // Filtering and display get the rendered string
                        return data == 0 ? "All" : ((data == 1) ? "0.5" : (data == 2) ? "2" :(data == 3) ? "5" : "5+");
                       

                    }
                    // Otherwise just give the original data
                    return data;
                }
            },
                       
		  { data: "f_ads_interest.fai_name" },	
                         
			
                         
                           
                            
                     
                   //     { data: "f_audience.ad_link" },
			
                       
                        
			
                            {
                data:   "f_audience.aud_status",
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
            dataSrc: 'f_audience.aud_order',
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
            $('input.editor-active', row).prop( 'checked', data.f_audience.aud_status == 1 );
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
            editor.field( 'f_audience.aud_order' ).enable();
        } )
        .on( 'initEdit', function () {
            // Disable for edit (re-ordering is performed by click and drag)
            editor.field( 'f_audience.aud_order' ).disable();
        } );
        
          $('#example').on( 'change', 'input.editor-active', function () {
        editor
            .edit( $(this).closest('tr'), false )
            .set( 'f_audience.aud_status', $(this).prop( 'checked' ) ? 1 : 0 )
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
							<h3>Ads Audience Setup & Management</h3>
						</div>
					</div>
				</header>
            
            
    
            
              <div id="customForm">
                          <fieldset class="name">
                            <legend style="border-radius: 3px;
    border: 1px solid #00a8ff;
       background-color: #ac6bec;
    border-color: #ac6bec;
     font-size:16px;
    color: #fff;
    font-weight: 600;">Audience Configuration</legend>
                            
                           
                          
                        <editor-field name="f_audience.aud_name"></editor-field>
                         <editor-field name="f_audience.aud_gender"></editor-field>   
        <editor-field name="f_audience.aud_platform"></editor-field>  
           <editor-field name="f_audience.aud_language"></editor-field>
          <editor-field name="f_audience.aud_age_range"></editor-field>  
                        <editor-field name="f_audience.aud_geo_point"></editor-field>
                                <editor-field name="f_audience.aud_range"></editor-field>
                                <editor-field name="f_audience.aud_intrests"></editor-field>
                             
                            
                   
                            
                            
                        
                               
                        </fieldset>
                  
                     <fieldset class="hr">
                            <legend style="    border-radius: 3px;
    border: 1px solid #00a8ff;
    background: #00a8ff;
    color: #fff;
    font-size:16px;
    font-weight: 600;" >Audience Visibility</legend>
                           
                       <editor-field name="f_audience.aud_order"></editor-field>
                             <editor-field name="f_audience.aud_status"></editor-field>     
                            
                          
                              
                               
                               
                           
                        </fieldset>
                  
                
                  
                
                  
                       
                    </div>
            
			
			
			<table id="example" class="display" cellspacing="0" width="100%">
				<thead>
					<tr>
				<th>Audience Order</th>
                                <th>Audience Name</th>
                                <th>Audience Gender</th>
                                <th>Audience Platform</th>
                              
                                <th>Audience Language</th>
                                 <th>Audience Age Range</th>
                                   <th>Audience Center Point</th>
                                    <th> Location Range (km)</th>
                                     <th> Audience Interests</th>
                                <th>Active</th>
                                                
					</tr>
				</thead>
				<tfoot>
					<th>Audience Order</th>
                                <th>Audience Name</th>
                                <th>Audience Gender</th>
                                <th>Audience Platform</th>
                                 
                                <th>Audience Language</th>
                                <th>Audience Age Range</th>
                                    <th>Audience Center Point</th>
                                   <th> Location Range (km)</th>
                                      <th> Audience Interests</th>
                                <th>Active</th>
					</tr>
				</tfoot>
			</table>
	
			
				
			</div>
		
</div><!--.page-content-->


<script src="js/app.js"></script>




</body>
</html>