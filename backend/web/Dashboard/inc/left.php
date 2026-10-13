<!--.side-menu-->

<?php          if($userRow['user_role']=='Admin'){  
    
    ?>
	<nav class="side-menu">
              <header class="side-menu-title"> Admin Management</header>
                  <ul class="side-menu-list">
	      

 <li class="red with-sub">
<a href="index.php"> <i class="font-icon font-icon-dashboard"></i>
	                <span class="lbl">Dashboard</span> </a>   </li>
  <li class="green with-sub">
<a href="adminusers.php"> <i class="font-icon font-icon font-icon-user"></i>
	                <span class="lbl">Advertiser Login</span> </a>   </li>
	       
	    
                
                 
              
                

<li class="gold"> <a href="addads.php">   <i class="font-icon font-icon-video-fill"></i>
	                <span class="lbl">Add Ads</span> </a>   </li>
                   
                <li class="blue"> <a href="addslots.php">  <i class="font-icon font-icon-alarm"></i>
	                <span class="lbl">Add Ad's Slot Time</span> </a>   </li>
                
                 <li class="magenta with-sub "> <a href="addpopimage.php">  <i class="font-icon font-icon font-icon-picture-2"></i>
	                <span class="lbl">Add Pop-Up Image Ad</span> </a>   </li>
                
                                
	    </ul>
              
	   <header class="side-menu-title"> Ads Management</header>
	    <ul class="side-menu-list">
	      

	       
	    
                
                 
              
                

<li class="gold"> <a href="ads.php">   <i class="font-icon font-icon-help"></i>
	                <span class="lbl">View Ads</span> </a>   </li>
                   
                <li class="blue"> <a href="slots.php">  <i class="font-icon font-icon-speed"></i>
	                <span class="lbl">Todays Slots</span> </a>   </li>
                
                 <li class="magenta with-sub"> <a href="slotshistory.php">  <i class="font-icon glyphicon glyphicon-list-alt"></i>
	                <span class="lbl">Slots History</span> </a>   </li>
             
                
                 <li class="red"> <a href="reportsbanner.php"> <i class="font-icon font-icon-editor-img"></i>
	                <span class="lbl">Banner Ad Reports</span> </a>   </li>
                                
	    </ul>
          
       
          
        
	</nav><!--.side-menu-->


<?php 
    
}else{
?>
	<nav class="side-menu">
              <header class="side-menu-title"> Ads Management</header>
	 
	    <ul class="side-menu-list">
	      

 <li class="red with-sub">
<a href="index.php"> <i class="font-icon font-icon-dashboard"></i>
	                <span class="lbl">Dashboard</span> </a>   </li>
	       
	    
                
                 
              
                

<li class="gold"> <a href="ads.php">   <i class="font-icon font-icon-help"></i>
	                <span class="lbl">View Ads</span> </a>   </li>
                   
                <li class="blue"> <a href="slots.php">  <i class="font-icon font-icon-speed"></i>
	                <span class="lbl">Todays Slots</span> </a>   </li>
                
                 <li class="magenta with-sub"> <a href="slotshistory.php">  <i class="font-icon glyphicon glyphicon-list-alt"></i>
	                <span class="lbl">Slots History</span> </a>   </li>
                
                
                 <li class="red"> <a href="reportsbanner.php"> <i class="font-icon font-icon-editor-img"></i>
	                <span class="lbl">Banner Ad Reports</span> </a>   </li>
                                
	    </ul>
          
       
          
        
	</nav><!--.side-menu-->
<?php } ?>