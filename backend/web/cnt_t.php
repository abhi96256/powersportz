<?php
//VAR_DUMP($_POST); die;
$connect = mysqli_connect("10.10.10.28", "powersport", "Dgt569khd", "powersport");
//$connect = mysqli_connect("localhost", "root", "", "powersport");
$ad_id_url=@$_POST['ad_id'];

  if(isset($_POST['cnt'])){
    $values_cnt =  implode(',',$_POST['cnt']);
    
  }




if($ad_id_url !='' && $values_cnt !=''){
	
  $sql_wid = "update customadvertisement set  ForCountry='$values_cnt' where CustomAdvertiseID=$ad_id_url "; 
			mysqli_query($connect, $sql_wid);   
    
}




header("Location: update_ad_cnt.php?ad_id=$ad_id_url");
