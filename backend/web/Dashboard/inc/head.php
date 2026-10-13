<header class="site-header">
	    <div class="container-fluid">
	
	        <a href="index.php" class="site-logo">
	            <img class="hidden-md-down" src="img/ps_large.jpg" alt=""> 
	            <img class="hidden-lg-up" src="img/ps_logo.png" alt="">
				
	        </a>
	
	        <button id="show-hide-sidebar-toggle" class="show-hide-sidebar">
	            <span>toggle menu</span>
	        </button>
	
	        <button class="hamburger hamburger--htla">
	            <span>toggle menu</span>
	        </button>
	        <div class="site-header-content">
	            <div class="site-header-content-in">
	                <div class="site-header-shown">
	         
	
	      
	
	              
	
	                    <div class="dropdown user-menu">
	                        <button class="dropdown-toggle" id="dd-user-menu" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							
	                            <img src="img/ps_logo.png" alt="">
	                        </button>
	                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dd-user-menu">
	                            <a class="dropdown-item" href="#"><span class="font-icon glyphicon glyphicon-user"></span><?php print($userRow['user_name']); ?> (<?php print($userRow['user_role']); ?>)</a>
	                            <a class="dropdown-item" href="#"><span class="font-icon glyphicon glyphicon-cog"></span>Settings</a>
	                            <a class="dropdown-item" href="#"><span class="font-icon glyphicon glyphicon-question-sign"></span>Help</a>
	                            <div class="dropdown-divider"></div>
	                            <a class="dropdown-item" href="Login/logout.php?logout=true"><span class="font-icon glyphicon glyphicon-log-out"></span>Logout</a>
	                        </div>
	                    </div>
	
	                    <button type="button" class="burger-right">
	                        <i class="font-icon-menu-addl"></i>
	                    </button>
	                </div><!--.site-header-shown-->
	
	                <div class="mobile-menu-right-overlay"></div>
	                <div class="site-header-collapsed">
	                    <div class="site-header-collapsed-in">
	
	                        <a class="btn btn-nav btn-nav btn-inline " href="#">
	                         Welcome !  <?php print($userRow['user_name']); ?>
                                 
                                 
	                        </a>
                                
                                <a class="btn btn-nav btn-nav btn-success-outline " href="javascript:window.print()">
	                         Save Report
                                 
                                
	                        </a>
	                        <div class="site-header-search-container">
	                
	                        </div>
	                    </div><!--.site-header-collapsed-in-->
	                </div><!--.site-header-collapsed-->
	            </div><!--site-header-content-in-->
	        </div><!--.site-header-content-->
	    </div><!--.container-fluid-->
	</header><!--.site-header-->
