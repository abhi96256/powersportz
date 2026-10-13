<?php

	require_once("Login/session.php");
	
	require_once("Login/class.user.php");
	$auth_user = new USER();
	
	
	$user_id = $_SESSION['user_session'];
	
	$stmt = $auth_user->runQuery("SELECT * FROM admin_users WHERE user_id=:user_id");
	$stmt->execute(array(":user_id"=>$user_id));
	
	$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
        
        if($userRow['user_role']=='User'){
            header("location:userlogin.php");
        }

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
        <link rel="stylesheet" href="css/separate/pages/others.min.css">
        <link rel="stylesheet" href="css/separate/pages/user.min.css">
<link rel="stylesheet" href="css/lib/lobipanel/lobipanel.min.css">
<link rel="stylesheet" href="css/separate/vendor/lobipanel.min.css">
<link rel="stylesheet" href="css/lib/jqueryui/jquery-ui.min.css">
<link rel="stylesheet" href="css/separate/pages/widgets.min.css">

<link rel="stylesheet" href="css/separate/vendor/slick.min.css">
<link rel="stylesheet" href="css/separate/vendor/select2.min.css">


    <link rel="stylesheet" href="css/lib/font-awesome/font-awesome.min.css">
    <link rel="stylesheet" href="css/lib/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="css/main.css">
</head>
<body class="with-side-menu control-panel control-panel-compact">

<?php include("inc/head.php"); ?>
	
	<div class="mobile-menu-left-overlay"></div>
<?php include("inc/left.php"); ?>

		<div class="page-content">
		<div class="container-fluid">
			<div class="box-typical box-typical-full-height">
				<div class="add-customers-screen tbl">
					<div class="add-customers-screen-in">
						<div class="add-customers-screen-user">
							<i class="font-icon font-icon-user"></i>
						</div>
						<h2>Your Home Widgets</h2>
						<p class="lead color-blue-grey-lighter">Create Widget - items with names, information<br/> and position to look differently.</p>
						<a href="#" class="btn">Add Widget</a>
					</div>
				</div>
			</div><!--.box-typical-->
		</div><!--.container-fluid-->
	</div><!--.page-content-->



	<script src="js/lib/jquery/jquery.min.js"></script>
	<script src="js/lib/tether/tether.min.js"></script>
	<script src="js/lib/bootstrap/bootstrap.min.js"></script>
	<script src="js/plugins.js"></script>

	<script type="text/javascript" src="js/lib/jqueryui/jquery-ui.min.js"></script>
	<script type="text/javascript" src="js/lib/lobipanel/lobipanel.min.js"></script>
	<script type="text/javascript" src="js/lib/match-height/jquery.matchHeight.min.js"></script>
	<script src="js/lib/asPieProgress/jquery-asPieProgress.min.js"></script>
	<script src="js/lib/select2/select2.full.min.js"></script>
	<script type="text/javascript" src="js/lib/match-height/jquery.matchHeight.min.js"></script>
	<script src="js/lib/slick-carousel/slick.min.js"></script>
	<script>
		$(function() {
			$(".circle-progress-bar").asPieProgress({
				namespace: 'asPieProgress',
				speed: 500
			});

			$(".circle-progress-bar").asPieProgress("start");


			$(".circle-progress-bar-typical").asPieProgress({
				namespace: 'asPieProgress',
				speed: 25
			});

			$(".circle-progress-bar-typical").asPieProgress("start");

			$('.widget-chart-combo-content-in, .widget-chart-combo-side').matchHeight();

			/* ==========================================================================
			 Widget weather slider
			 ========================================================================== */

			$('.widget-weather-slider').slick({
				arrows: false,
				dots: true,
				infinite: false,
				slidesToShow: 4,
				slidesToScroll: 4
			});
		});
	</script>

	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	<script type="text/javascript">
		google.charts.setOnLoadCallback(drawChart3);
		function drawChart3() {
			var data = google.visualization.arrayToDataTable([
				['Titles', 'Values'],
				['Websites', 17],
				['Logo', 8],
				['Social media', 12],
				['Adwords', 41],
				['E-Commerce', 39]
			]);

			var options = {
				legend: 'none',
				pieSliceText: 'none',
				chartArea: {
					width: '90%',
					height: '90%',
				},
				colors:['#46c35f','#fa424a','#e84f9a','#fdad2a','#00a8ff','#ac6bec'],
				slices: {
					0: { color: '#46c35f' },
					1: { color: '#fa424a' },
					2: { color: '#ac6bec' },
					3: { color: '#fdad2a' },
					4: { color: '#00a8ff' }
				},
				pieHole: 0.8,
				tooltip: { trigger: 'none' }
			};

			var chart = new google.visualization.PieChart(document.getElementById('donutchart3'));
			chart.draw(data, options);
		}
	</script>
	<script type="text/javascript">
		google.charts.setOnLoadCallback(drawChart2);
		function drawChart2() {
			var data = google.visualization.arrayToDataTable([
				['Title', 'Values'],
				['TBK', 8],
				['Fluor Corp', 12],
				['Fluor Group', 41],
				['Bechtel', 39]
			]);

			var options = {
				legend: 'none',
				pieSliceText: 'none',
				chartArea: {
					width: '90%',
					height: '90%',
				},
				colors:['#46c35f','#fa424a','#e84f9a','#fdad2a','#00a8ff','#ac6bec'],
				slices: {
					0: { color: '#46c35f' },
					1: { color: '#fa424a' },
					2: { color: '#ac6bec' },
					3: { color: '#fdad2a' }
				},
				pieHole: 0.8,
				tooltip: { trigger: 'none' }
			};

			var chart = new google.visualization.PieChart(document.getElementById('donutchart2'));
			chart.draw(data, options);
		}
	</script>
	<script type="text/javascript">
		google.charts.setOnLoadCallback(drawChart);
		function drawChart() {
			var data = google.visualization.arrayToDataTable([
				['Title', 'Values'],
				['TBK', 8],
				['Fluor Corp', 12],
				['Fluor Group', 41],
				['Bechtel', 39]
			]);

			var options = {
				legend: 'none',
				pieSliceText: 'none',
				chartArea: {
					width: '90%',
					height: '90%',
				},
				colors:['#fa424a','#ac6bec','#fdad2a','#00a8ff','#46c35f','#e84f9a'],
				slices: {
					0: { color: '#fa424a' },
					1: { color: '#ac6bec' },
					2: { color: '#fdad2a' },
					3: { color: '#00a8ff' }
				},
				pieHole: 0.8,
				tooltip: { trigger: 'none' }
			};

			var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
			chart.draw(data, options);
		}
	</script>
	<script type="text/javascript">
		google.charts.setOnLoadCallback(drawVisualization);

		function drawVisualization() {
			var data = google.visualization.arrayToDataTable([
				['value1', 'value2', 'value3'],
				['X', 5, 50],
				['F', 25, 55],
				['A', 12, 50],
				['B', 3, 85],
				['C', 35, 90],
				['D', 15, 98],
				['E', 12, 70],
				['O', 5, 80],
				['M', 18, 110],
				['N', 40, 128],
				['K', 50, 120],
				['L', 22, 130]
			]);

			var options = {
				legend: 'none',
				tooltip: { trigger: 'none' },
				enableInteractivity: false,
				vAxis: {
					textStyle: {
						color: '#919fa9',
						fontName: 'Proxima Nova',
						fontSize: 11
					},
					baselineColor: '#eff1f2',
					ticks: [0,25,50,75,100,125,150],
					gridlines: {
						color: '#eff1f2',
						count: 7
					}
				},
				hAxis: {
					textStyle: {
						color: '#919fa9',
						fontName: 'Proxima Nova',
						fontSize: 11
					}
				},
				chartArea:{
					left: 30,
					top: 10,
					width:'100%',
					height: 175
				},
				lineWidth: 2,
				seriesType: 'bars',
				series: {
					0: { color: '#ac6bec' },
					1: {
						type: 'line',
						color: '#00a8ff',
						pointSize: 4,
						pointShapeType: 'circle'
					}
				}
			};

			var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
			chart.draw(data, options);
		}
		$(window).resize(function(){
			drawVisualization();
		});
	</script>
	<script type="text/javascript">
		google.charts.load('current', {'packages':['corechart']});
		google.charts.setOnLoadCallback(drawBasic);

		function drawBasic() {

			var data = google.visualization.arrayToDataTable([
				['Month', 'Value'],
				['NOV', 2],
				['DEC', 6],
				['JAN', 5],
				['FEB', 7],
				['MAR', 5],
				['APR', 8]
			]);

			var options = {
				legend: 'none',
				areaOpacity: 0.18,
				tooltip: { trigger: 'none' },
				hAxis: {
					textStyle: {
						color: '#fff',
						fontName: 'Proxima Nova',
						fontSize: 11,
						bold: true
					},
					gridlines: 'null'
				},
				vAxis: {
					minValue: 0,
					textStyle: {
						color: '#fff',
						fontName: 'Proxima Nova',
						fontSize: 11,
						bold: true
					},
					baselineColor: '#16b4fc',
					ticks: [0,2,4,6,8,10,12],
					gridlines: {
						color: '#1ba0fc',
						count: 7
					},
				},
				lineWidth: 2,
				colors: ['#fff'],
				curveType: 'function',
				pointSize: 5,
				pointShapeType: 'circle',
				pointFillColor: '#f00',
				backgroundColor: {
					fill: '#008ffb',
					strokeWidth: 0
				},
				chartArea:{
					left: '10%',
					top: 5,
					width:'80%',
					height: 200
				}
			};

			var chart = new google.visualization.AreaChart(document.getElementById('chart_line'));

			chart.draw(data, options);
		}
		$(window).resize(function(){
			drawBasic();
		});
	</script>
        
        
	<script>
		$(document).ready(function() {
			$('.panel').lobiPanel({
				sortable: true
			});
			$('.panel').on('dragged.lobiPanel', function(ev, lobiPanel){
				$('.dahsboard-column').matchHeight();
			});

			google.charts.load('current', {'packages':['corechart']});
			google.charts.setOnLoadCallback(drawChart);
			function drawChart() {
				var dataTable = new google.visualization.DataTable();
				dataTable.addColumn('string', 'Day');
				dataTable.addColumn('number', 'Values');
				// A column for custom tooltip content
				dataTable.addColumn({type: 'string', role: 'tooltip', 'p': {'html': true}});
				dataTable.addRows([
					['MON',  130, ' '],
					['TUE',  130, '130'],
					['WED',  180, '180'],
					['THU',  175, '175'],
					['FRI',  200, '200'],
					['SAT',  170, '170'],
					['SUN',  250, '250'],
					['MON',  220, '220'],
					['TUE',  220, ' ']
				]);

				var options = {
					height: 314,
					legend: 'none',
					areaOpacity: 0.18,
					axisTitlesPosition: 'out',
					hAxis: {
						title: '',
						textStyle: {
							color: '#fff',
							fontName: 'Proxima Nova',
							fontSize: 11,
							bold: true,
							italic: false
						},
						textPosition: 'out'
					},
					vAxis: {
						minValue: 0,
						textPosition: 'out',
						textStyle: {
							color: '#fff',
							fontName: 'Proxima Nova',
							fontSize: 11,
							bold: true,
							italic: false
						},
						baselineColor: '#16b4fc',
						ticks: [0,25,50,75,100,125,150,175,200,225,250,275,300,325,350],
						gridlines: {
							color: '#1ba0fc',
							count: 15
						},
					},
					lineWidth: 2,
					colors: ['#fff'],
					curveType: 'function',
					pointSize: 5,
					pointShapeType: 'circle',
					pointFillColor: '#f00',
					backgroundColor: {
						fill: '#008ffb',
						strokeWidth: 0,
					},
					chartArea:{
						left:0,
						top:0,
						width:'100%',
						height:'100%'
					},
					fontSize: 11,
					fontName: 'Proxima Nova',
					tooltip: {
						trigger: 'selection',
						isHtml: true
					}
				};

				var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
				chart.draw(dataTable, options);
			}
			$(window).resize(function(){
				drawChart();
				setTimeout(function(){
				}, 1000);
			});
		});
	</script>
<script src="js/app.js"></script>
</body>
</html>