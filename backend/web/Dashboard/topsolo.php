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
        <link rel="stylesheet" href="css/separate/elements/cards.min.css">
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
                    
                    <header class="page-content-header">
			<div class="container-fluid">
				<div class="tbl">
					<div class="tbl-row">
						<div class="tbl-cell">
							<h3>Top Solo <small class="text-muted">Songs</small></h3>
						</div>
						<div class="tbl-cell tbl-cell-action">
							<a href="#" class="btn btn-rounded">View All Solo</a>
						</div>
					</div>
				</div>
			</div>
		</header><!--.page-content-header-->
		<div class="container-fluid">
			<div class="cards-grid" data-columns>
				<div class="card-grid-col">
					<article class="card-typical">
						<div class="card-typical-section">
							<div class="user-card-row">
								<div class="tbl-row">
									<div class="tbl-cell tbl-cell-photo">
										<a href="#">
											<img src="img/photo-64-2.jpg" alt="">
										</a>
									</div>
									<div class="tbl-cell">
										<p class="user-card-row-name"><a href="#">Tim Colins</a></p>
										<p class="color-blue-grey-lighter">3 days ago - 23 min read</p>
									</div>
									<div class="tbl-cell tbl-cell-status">
										<a href="#" class="font-icon font-icon-star active"></a>
									</div>
								</div>
							</div>
						</div>
						<div class="card-typical-section card-typical-content">
							<div class="photo">
								<img src="img/gall-img-1.jpg" alt="">
							</div>
							<header class="title"><a href="#">The Jacobs Ladder of coding</a></header>
							<p>That’s a great idea! I’m sure we could start this project as soon as possible. Let’s meet tomorow!</p>
						</div>
						<div class="card-typical-section">
							<div class="card-typical-linked">in <a href="#">Coders Life</a></div>
							<a href="#" class="card-typical-likes">
								<i class="font-icon font-icon-heart"></i>
								123
							</a>
						</div>
					</article><!--.card-typical-->
				</div><!--.card-grid-col-->

				<div class="card-grid-col">
					<article class="card-typical">
						<div class="card-typical-section">
							<div class="user-card-row">
								<div class="tbl-row">
									<div class="tbl-cell tbl-cell-photo">
										<a href="#">
											<img src="img/avatar-1-64.png" alt="">
										</a>
									</div>
									<div class="tbl-cell">
										<p class="user-card-row-name"><a href="#">Tim Colins</a></p>
										<p class="color-blue-grey-lighter">3 days ago - 23 min read</p>
									</div>
									<div class="tbl-cell tbl-cell-status">
										<a href="#" class="font-icon font-icon-star"></a>
									</div>
								</div>
							</div>
						</div>
						<div class="card-typical-section card-typical-content">
							<header class="title"><a href="#">The Jacobs Ladder of coding</a></header>
							<p>That’s a great idea! I’m sure we could start this project as soon as possible. Let’s meet tomorow! That’s a great idea! I’m sure we could start this project as soon as possible. Let’s meet tomorow! </p>
						</div>
						<div class="card-typical-section">
							<div class="card-typical-linked">in <a href="#">Coders Life</a></div>
							<a href="#" class="card-typical-likes">
								<i class="font-icon font-icon-heart"></i>
								123
							</a>
						</div>
					</article><!--.card-typical-->
				</div><!--.card-grid-col-->

				<div class="card-grid-col">
					<article class="card-typical">
						<div class="card-typical-section">
							<div class="user-card-row">
								<div class="tbl-row">
									<div class="tbl-cell tbl-cell-photo">
										<a href="#">
											<img src="img/avatar-2-64.png" alt="">
										</a>
									</div>
									<div class="tbl-cell">
										<p class="user-card-row-name"><a href="#">Tim Colins</a></p>
										<p class="color-blue-grey-lighter">3 days ago - 23 min read</p>
									</div>
									<div class="tbl-cell tbl-cell-status">
										<a href="#" class="font-icon font-icon-star active"></a>
									</div>
								</div>
							</div>
						</div>
						<div class="card-typical-section card-typical-content">
							<div class="photo">
								<img src="img/gall-img-4.jpg" alt="">
							</div>
							<header class="title"><a href="#">The Jacobs Ladder of coding</a></header>
							<p>That’s a great idea! I’m sure we could start this project as soon as possible. Let’s meet tomorow!</p>
						</div>
						<div class="card-typical-section">
							<div class="card-typical-linked">in <a href="#">Coders Life</a></div>
							<a href="#" class="card-typical-likes">
								<i class="font-icon font-icon-heart"></i>
								123
							</a>
						</div>
					</article><!--.card-typical-->
				</div><!--.card-grid-col-->

				<div class="card-grid-col">
					<article class="card-typical">
						<div class="card-typical-section">
							<div class="user-card-row">
								<div class="tbl-row">
									<div class="tbl-cell tbl-cell-photo">
										<a href="#">
											<img src="img/photo-64-3.jpg" alt="">
										</a>
									</div>
									<div class="tbl-cell">
										<p class="user-card-row-name"><a href="#">Tim Colins</a></p>
										<p class="color-blue-grey-lighter">3 days ago - 23 min read</p>
									</div>
									<div class="tbl-cell tbl-cell-status">
										<a href="#" class="font-icon font-icon-star"></a>
									</div>
								</div>
							</div>
						</div>
						<div class="card-typical-section card-typical-content">
							<header class="title"><a href="#">The Jacobs Ladder of coding</a></header>
							<p>That’s a great idea! I’m sure we could start this project as soon as possible. Let’s meet tomorow! That’s a great idea! I’m sure we could start this project as soon as possible. Let’s meet tomorow! </p>
						</div>
						<div class="card-typical-section">
							<div class="card-typical-linked">in <a href="#">Coders Life</a></div>
							<a href="#" class="card-typical-likes">
								<i class="font-icon font-icon-heart"></i>
								123
							</a>
						</div>
					</article><!--.card-typical-->
				</div><!--.card-grid-col-->

				<div class="card-grid-col">
					<article class="card-typical">
						<div class="card-typical-section">
							<div class="user-card-row">
								<div class="tbl-row">
									<div class="tbl-cell tbl-cell-photo">
										<a href="#">
											<img src="img/photo-64-4.jpg" alt="">
										</a>
									</div>
									<div class="tbl-cell">
										<p class="user-card-row-name"><a href="#">Tim Colins</a></p>
										<p class="color-blue-grey-lighter">3 days ago - 23 min read</p>
									</div>
									<div class="tbl-cell tbl-cell-status">
										<a href="#" class="font-icon font-icon-star active"></a>
									</div>
								</div>
							</div>
						</div>
						<div class="card-typical-section card-typical-content">
							<header class="title"><a href="#">The Jacobs Ladder of coding</a></header>
							<p>That’s a great idea! I’m sure we could start this project as soon as possible. Let’s meet tomorow! That’s a great idea! I’m sure we could start this project as soon as possible. Let’s meet tomorow! </p>
						</div>
						<div class="card-typical-section">
							<div class="card-typical-linked">in <a href="#">Coders Life</a></div>
							<a href="#" class="card-typical-likes">
								<i class="font-icon font-icon-heart"></i>
								123
							</a>
						</div>
					</article><!--.card-typical-->
				</div><!--.card-grid-col-->

				<div class="card-grid-col">
					<article class="card-typical">
						<div class="card-typical-section">
							<div class="user-card-row">
								<div class="tbl-row">
									<div class="tbl-cell tbl-cell-photo">
										<a href="#">
											<img src="img/avatar-3-64.png" alt="">
										</a>
									</div>
									<div class="tbl-cell">
										<p class="user-card-row-name"><a href="#">Tim Colins</a></p>
										<p class="color-blue-grey-lighter">3 days ago - 23 min read</p>
									</div>
									<div class="tbl-cell tbl-cell-status">
										<a href="#" class="font-icon font-icon-star"></a>
									</div>
								</div>
							</div>
						</div>
						<div class="card-typical-section card-typical-content">
							<div class="photo">
								<img src="img/gall-img-5.jpg" alt="">
							</div>
							<header class="title"><a href="#">The Jacobs Ladder of coding</a></header>
							<p>That’s a great idea! I’m sure we could start this project as soon as possible. Let’s meet tomorow!</p>
						</div>
						<div class="card-typical-section">
							<div class="card-typical-linked">in <a href="#">Coders Life</a></div>
							<a href="#" class="card-typical-likes">
								<i class="font-icon font-icon-heart"></i>
								123
							</a>
						</div>
					</article><!--.card-typical-->
				</div><!--.card-grid-col-->

				<div class="card-grid-col">
					<article class="card-typical">
						<div class="card-typical-section">
							<div class="user-card-row">
								<div class="tbl-row">
									<div class="tbl-cell tbl-cell-photo">
										<a href="#">
											<img src="img/photo-64-2.jpg" alt="">
										</a>
									</div>
									<div class="tbl-cell">
										<p class="user-card-row-name"><a href="#">Tim Colins</a></p>
										<p class="color-blue-grey-lighter">3 days ago - 23 min read</p>
									</div>
									<div class="tbl-cell tbl-cell-status">
										<a href="#" class="font-icon font-icon-star active"></a>
									</div>
								</div>
							</div>
						</div>
						<div class="card-typical-section card-typical-content">
							<header class="title"><a href="#">The Jacobs Ladder of coding</a></header>
							<p>That’s a great idea! I’m sure we could start this project as soon as possible. Let’s meet tomorow! That’s a great idea! I’m sure we could start this project as soon as possible. Let’s meet tomorow! </p>
						</div>
						<div class="card-typical-section">
							<div class="card-typical-linked">in <a href="#">Coders Life</a></div>
							<a href="#" class="card-typical-likes">
								<i class="font-icon font-icon-heart"></i>
								123
							</a>
						</div>
					</article><!--.card-typical-->
				</div><!--.card-grid-col-->

				<div class="card-grid-col">
					<article class="card-typical">
						<div class="card-typical-section">
							<div class="user-card-row">
								<div class="tbl-row">
									<div class="tbl-cell tbl-cell-photo">
										<a href="#">
											<img src="img/avatar-1-64.png" alt="">
										</a>
									</div>
									<div class="tbl-cell">
										<p class="user-card-row-name"><a href="#">Tim Colins</a></p>
										<p class="color-blue-grey-lighter">3 days ago - 23 min read</p>
									</div>
									<div class="tbl-cell tbl-cell-status">
										<a href="#" class="font-icon font-icon-star"></a>
									</div>
								</div>
							</div>
						</div>
						<div class="card-typical-section card-typical-content">
							<header class="title"><a href="#">The Jacobs Ladder of coding</a></header>
							<p>That’s a great idea! I’m sure we could start this project as soon as possible. Let’s meet tomorow! That’s a great idea! I’m sure we could start this project as soon as possible. Let’s meet tomorow! </p>
						</div>
						<div class="card-typical-section">
							<div class="card-typical-linked">in <a href="#">Coders Life</a></div>
							<a href="#" class="card-typical-likes">
								<i class="font-icon font-icon-heart"></i>
								123
							</a>
						</div>
					</article><!--.card-typical-->
				</div><!--.card-grid-col-->

				<div class="card-grid-col">
					<article class="card-typical">
						<div class="card-typical-section">
							<div class="user-card-row">
								<div class="tbl-row">
									<div class="tbl-cell tbl-cell-photo">
										<a href="#">
											<img src="img/photo-64-2.jpg" alt="">
										</a>
									</div>
									<div class="tbl-cell">
										<p class="user-card-row-name"><a href="#">Tim Colins</a></p>
										<p class="color-blue-grey-lighter">3 days ago - 23 min read</p>
									</div>
									<div class="tbl-cell tbl-cell-status">
										<a href="#" class="font-icon font-icon-star active"></a>
									</div>
								</div>
							</div>
						</div>
						<div class="card-typical-section card-typical-content">
							<div class="photo">
								<img src="img/gall-img-6.jpg" alt="">
							</div>
							<header class="title"><a href="#">The Jacobs Ladder of coding</a></header>
							<p>That’s a great idea! I’m sure we could start this project as soon as possible. Let’s meet tomorow!</p>
						</div>
						<div class="card-typical-section">
							<div class="card-typical-linked">in <a href="#">Coders Life</a></div>
							<a href="#" class="card-typical-likes">
								<i class="font-icon font-icon-heart"></i>
								123
							</a>
						</div>
					</article><!--.card-typical-->
				</div><!--.card-grid-col-->

				<div class="card-grid-col">
					<article class="card-typical">
						<div class="card-typical-section">
							<div class="user-card-row">
								<div class="tbl-row">
									<div class="tbl-cell tbl-cell-photo">
										<a href="#">
											<img src="img/avatar-2-64.png" alt="">
										</a>
									</div>
									<div class="tbl-cell">
										<p class="user-card-row-name"><a href="#">Tim Colins</a></p>
										<p class="color-blue-grey-lighter">3 days ago - 23 min read</p>
									</div>
									<div class="tbl-cell tbl-cell-status">
										<a href="#" class="font-icon font-icon-star"></a>
									</div>
								</div>
							</div>
						</div>
						<div class="card-typical-section card-typical-content">
							<header class="title"><a href="#">The Jacobs Ladder of coding</a></header>
							<p>That’s a great idea! I’m sure we could start this project as soon as possible. Let’s meet tomorow! That’s a great idea! I’m sure we could start this project as soon as possible. Let’s meet tomorow! </p>
						</div>
						<div class="card-typical-section">
							<div class="card-typical-linked">in <a href="#">Coders Life</a></div>
							<a href="#" class="card-typical-likes">
								<i class="font-icon font-icon-heart"></i>
								123
							</a>
						</div>
					</article><!--.card-typical-->
				</div><!--.card-grid-col-->

				<div class="card-grid-col">
					<article class="card-typical">
						<div class="card-typical-section">
							<div class="user-card-row">
								<div class="tbl-row">
									<div class="tbl-cell tbl-cell-photo">
										<a href="#">
											<img src="img/photo-64-3.jpg" alt="">
										</a>
									</div>
									<div class="tbl-cell">
										<p class="user-card-row-name"><a href="#">Tim Colins</a></p>
										<p class="color-blue-grey-lighter">3 days ago - 23 min read</p>
									</div>
									<div class="tbl-cell tbl-cell-status">
										<a href="#" class="font-icon font-icon-star active"></a>
									</div>
								</div>
							</div>
						</div>
						<div class="card-typical-section card-typical-content">
							<header class="title"><a href="#">The Jacobs Ladder of coding</a></header>
							<p>That’s a great idea! I’m sure we could start this project as soon as possible. Let’s meet tomorow! That’s a great idea! I’m sure we could start this project as soon as possible. Let’s meet tomorow! </p>
						</div>
						<div class="card-typical-section">
							<div class="card-typical-linked">in <a href="#">Coders Life</a></div>
							<a href="#" class="card-typical-likes">
								<i class="font-icon font-icon-heart"></i>
								123
							</a>
						</div>
					</article><!--.card-typical-->
				</div><!--.card-grid-col-->

				<div class="card-grid-col">
					<article class="card-typical">
						<div class="card-typical-section">
							<div class="user-card-row">
								<div class="tbl-row">
									<div class="tbl-cell tbl-cell-photo">
										<a href="#">
											<img src="img/avatar-3-64.png" alt="">
										</a>
									</div>
									<div class="tbl-cell">
										<p class="user-card-row-name"><a href="#">Tim Colins</a></p>
										<p class="color-blue-grey-lighter">3 days ago - 23 min read</p>
									</div>
									<div class="tbl-cell tbl-cell-status">
										<a href="#" class="font-icon font-icon-star"></a>
									</div>
								</div>
							</div>
						</div>
						<div class="card-typical-section card-typical-content">
							<div class="photo">
								<img src="img/gall-img-7.jpg" alt="">
							</div>
							<header class="title"><a href="#">The Jacobs Ladder of coding</a></header>
							<p>That’s a great idea! I’m sure we could start this project as soon as possible. Let’s meet tomorow!</p>
						</div>
						<div class="card-typical-section">
							<div class="card-typical-linked">in <a href="#">Coders Life</a></div>
							<a href="#" class="card-typical-likes">
								<i class="font-icon font-icon-heart"></i>
								123
							</a>
						</div>
					</article><!--.card-typical-->
				</div><!--.card-grid-col-->

			</div><!--.card-grid-->
			<div class="clear"></div>

		</div><!--.container-fluid-->
	</div><!--.page-content-->

<div class="control-panel-container">
	    <ul>
	        <li class="tasks">
	        
	            <div class="control-item-content">
	                <div class="control-item-content-text">You don't have pending tasks.</div>
	            </div>
	        </li>
	   
	        <li class="emails">
	     
	   
	        </li>
	        <li class="add">
	            <div class="control-item-header">
	                <a href="#" class="icon-toggle no-caret">
	                    <span class="icon fa fa-plus"></span>
	                </a>
	            </div>
	        </li>
	    </ul>
	    <a class="control-panel-toggle">
	        <span class="fa fa-angle-double-left"></span>
	    </a>
	</div>

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
<script src="js/lib/salvattore/salvattore.min.js"></script>
	<script type="text/javascript" src="js/lib/match-height/jquery.matchHeight.min.js"></script>
	<script>
		$(function() {
			$('.card-user').matchHeight();
		});
	</script>

	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script src="js/app.js"></script>
</body>
</html>