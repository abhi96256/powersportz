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

    <link rel="stylesheet" href="css/lib/font-awesome/font-awesome.min.css">
    <link rel="stylesheet" href="css/lib/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="css/main.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.14/css/jquery.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.3.1/css/buttons.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/select/1.2.2/css/select.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="css/editor.dataTables.min.css">

	<style type="text/css" class="init">
	
	</style>
	<script type="text/javascript" language="javascript" src="//code.jquery.com/jquery-1.12.4.js">
	</script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.14/js/jquery.dataTables.min.js">
	</script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js">
	</script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/select/1.2.2/js/dataTables.select.min.js">
	</script>
	<script type="text/javascript" language="javascript" src="js/dataTables.editor.min.js">
	</script>
	

	
	<script type="text/javascript" language="javascript" class="init">
	

var editor; // use a global for the submit and return data rendering in the examples
 
var options = {
    'United States': {
        'California': [
            'Los Angeles',
            'Sacramento',
            'San Diego',
            'San Francisco'
        ],
        'New York': [
            'New York City'
        ],
        'Washington': [
            'Seattle',
            'Spokane'
        ],
        'Texas': [
            'Austin',
            'Dallas',
            'Houston',
            'San Antonio'
        ]
    },
 
    'Canada': {
        'British Columbia': [
            'Abbotsford',
            'Vancover',
            'Victoria'
        ],
        'Quebec': [
            'Gatineau',
            'Montreal',
            'Quebec City'
        ]
    }
};
 
 
// Object that will contain the local state
var records = {};
 
// Create or update the records localStorage entry
if ( localStorage.getItem('records') ) {
    records = JSON.parse( localStorage.getItem('records') );
}
 
var localStore = function ( method, url, d, successCallback, errorCallback ) {
    var output = { data: [] };
 
    if ( d.action === 'create' ) {
        // Create new row(s), using the current time and loop index as
        // the row id
        var dateKey = +new Date();
 
        $.each( d.data, function (key, value) {
            var id = dateKey+''+key;
 
            value.DT_RowId = id;
            records[ id ] = value;
            output.data.push( value );
        } );
    }
    else if ( d.action === 'edit' ) {
        // Update each edited item with the data submitted
        $.each( d.data, function (id, value) {
            value.DT_RowId = id;
            $.extend( records[ id ], value );
            output.data.push( records[ id ] );
        } );
    }
    else if ( d.action === 'remove' ) {
        // Remove items from the object
        $.each( d.data, function (id) {
            delete records[ id ];
        } );
    }
 
    // Store the latest `records` object for next reload
    localStorage.setItem( 'records', JSON.stringify(records) );
 
    // Show Editor what has changed
    successCallback( output );
};
 
$(document).ready(function() {
    // Set up the editor
    editor = new $.fn.dataTable.Editor( {
        table: "#example",
        fields: [
            {
                label: 'Country:',
                name: 'country',
                type: 'select',
                options: $.map( options, function ( val, key ) {
                    return key;
                } )
            }, {
                label: 'State / Province:',
                name: 'state',
                type: 'select'
            }, {
                label: 'City:',
                name: 'city',
                type: 'select'
            }
        ],
        ajax: localStore
    } );
 
    editor.dependent( 'country', function ( val, data, callback ) {
        setTimeout( function () {
            callback( {
                options: {
                    state: $.map( options[ val ], function ( val, key ) {
                        return key;
                    } )
                }
            } );
        }, 1000 );
    } );
 
    editor.dependent( 'state', function ( val, data, callback ) {
        setTimeout( function () {
            callback( {
                options: {
                    city: options[ data.values.country ][ val ]
                }
            } );
        }, 1000 );
    } );
 
    // Initialise the DataTable
    $('#example').DataTable( {
        dom: "Bfrtip",
        data: $.map( records, function (value, key) {
            return value;
        } ),
        columns: [
            { data: "country" },
            { data: "state" },
            { data: "city" }
        ],
        select: true,
        buttons: [
            { extend: "create", editor: editor },
            { extend: "edit",   editor: editor },
            { extend: "remove", editor: editor }
        ]
    } );
} );


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
							<h3>Languages !!</h3>
						</div>
					</div>
				</header>
			
			
			<table id="example" class="display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Country</th>
                <th>State / Province</th>
                <th>City</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>Country</th>
                <th>State / Province</th>
                <th>City</th>
            </tr>
        </tfoot>
    </table>
	
			
				
			</div>
		
</div><!--.page-content-->
<script src="js/lib/bootstrap/bootstrap.min.js"></script>


	

	<script>
		$(function () {
			$(".bar-chart").peity("bar",{
				delimiter: ",",
				fill: ["#919fa9"],
				height: 16,
				max: null,
				min: 0,
				padding: 0.1,
				width: 384
			});

			
		});
	</script>

</body>
</html>