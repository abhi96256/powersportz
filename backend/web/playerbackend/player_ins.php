<?php
//VAR_DUMP($_POST); die;
$connect = mysqli_connect("10.10.10.28", "powersport", "Dgt569khd", "powersport");
//$connect = mysqli_connect("localhost", "root", "root", "powersportztv");

//$connect = mysqli_connect("52.193.254.0", "powersport", "Google@123", "powersport");
//$number = count($_POST["name"]);
$wcwidget_web = $_POST["wcwidget_web"];

if($_POST["wcwidget_web"]!=''){
	$wcwidget_web = $_POST["wcwidget_web"];
}else{
	$wcwidget_web ='';
}
if($_POST["wcwidget_ios"]!=''){
	$wcwidget_ios = $_POST["wcwidget_ios"];
}else{
	$wcwidget_ios ='';
}

if($_POST["wcwidget_fire"]!=''){
	$wcwidget_fire = $_POST["wcwidget_fire"];
}else{
	$wcwidget_fire ='';
}
if($_POST["wcwidget_android"]!=''){
	$wcwidget_android = $_POST["wcwidget_android"];
}else{
	$wcwidget_android ='';
}




$wcwidget1 = $_POST["wcwidget1"];
$wcwidget2 = $_POST["wcwidget2"];
$wcwidget3 = $_POST["wcwidget3"];
$p1t = $_POST["p1t"];
$p2t = $_POST["p2t"];
$p3t = $_POST["p3t"];
$p1u = $_POST["p1u"];
$p2u = $_POST["p2u"];
$p3u = $_POST["p3u"];
//$p2gif = $_POST["p2gif"];
//$p3gif = $_POST["p3gif"];
//$p1thu = $_POST["p1thu"];
//$p2thu = $_POST["p2thu"];
//$p3thu = $_POST["p3thu"];
$wcad1 = $_POST["wcad1"];
$wcad2 = $_POST["wcad2"];
$wcad3 = $_POST["wcad3"];

if($p1u !=''){

$sql_wid_main = "update homepage set  wc_web='$wcwidget_web'  ,  wc_ios='$wcwidget_ios' ,  wc_android='$wcwidget_android'
,  wc_fire='$wcwidget_fire' ,  wcwidget1='$wcwidget1' ,  wcwidget2='$wcwidget2'
,  wcwidget3='$wcwidget3' ,  p1_ttl='$p1t' ,  p2_ttl='$p2t'
,  p3_ttl='$p3t' ,  p1_url='$p1u' ,  p2_url='$p2u' ,  p3_url='$p3u'  ,  p1_adv='$wcad1' ,  p2_adv='$wcad2' ,  p3_adv='$wcad3'

where HomeID=1 "; //die;
//echo $sql_wid_main; die;
			mysqli_query($connect, $sql_wid_main);

}



  if(isset($_FILES['p2gif'])){
      $errors= array();
      $file_name = $_FILES['p2gif']['name'];
      $file_size =$_FILES['p2gif']['size'];
      $file_tmp =$_FILES['p2gif']['tmp_name'];
      $file_type=$_FILES['p2gif']['type'];
      $file_ext=strtolower(end(explode('.',$_FILES['p2gif']['name'])));
      
      $extensions= array("jpeg","jpg","png","gif");
      
      if(in_array($file_ext,$extensions)=== false){
         $errors[]="extension not allowed, please choose a JPEG,GIF or PNG file.";
      }
      
      if($file_size > 1097152){
         $errors[]='File size must be excately 1 MB';
      }
      
      if(empty($errors)==true){
		  $new_name=date('m_d_Y_H_i_s').".".$file_ext;
  //  move_uploaded_file($_FILES['file']['tmp_name'],$new_name);
         move_uploaded_file($file_tmp,"../upload/player_images/".$new_name);
         
		 $sql_wid_pgif = "update homepage set  p2_gif='$new_name' where HomeID=1 "; //die;
			mysqli_query($connect, $sql_wid_pgif);
		 
      }else{
         print_r($errors);
      }
   }
   
    if(isset($_FILES['p3gif'])){
      $errors= array();
      $file_name = $_FILES['p3gif']['name'];
      $file_size =$_FILES['p3gif']['size'];
      $file_tmp =$_FILES['p3gif']['tmp_name'];
      $file_type=$_FILES['p3gif']['type'];
      $file_ext=strtolower(end(explode('.',$_FILES['p3gif']['name'])));
      
      $extensions= array("jpeg","jpg","png","gif");
      
      if(in_array($file_ext,$extensions)=== false){
         $errors[]="extension not allowed, please choose a JPEG ,GIF or PNG file.";
      }
      
      if($file_size > 1097152){
         $errors[]='File size must be excately 1 MB';
      }
      
      if(empty($errors)==true){
		  $new_name_2=date('m_d_Y_H_i_s')."_2.".$file_ext;
  //  move_uploaded_file($_FILES['file']['tmp_name'],$new_name);
         move_uploaded_file($file_tmp,"../upload/player_images/".$new_name_2);
         
		 $sql_wid_pgif_2 = "update homepage set  p3_gif='$new_name_2' where HomeID=1 "; //die;
			mysqli_query($connect, $sql_wid_pgif_2);
		 
      }else{
         print_r($errors);
      }
   }
   
    if(isset($_FILES['p1thu'])){
      $errors= array();
      $file_name = $_FILES['p1thu']['name'];
      $file_size =$_FILES['p1thu']['size'];
      $file_tmp =$_FILES['p1thu']['tmp_name'];
      $file_type=$_FILES['p1thu']['type'];
      $file_ext=strtolower(end(explode('.',$_FILES['p1thu']['name'])));
      
      $extensions= array("jpeg","jpg","png");
      
      if(in_array($file_ext,$extensions)=== false){
         $errors[]="extension not allowed, please choose a JPEG  or PNG file.";
      }
      
      if($file_size > 1097152){
         $errors[]='File size must be excately 1 MB';
      }
      
      if(empty($errors)==true){
		  $new_name_2=date('m_d_Y_H_i_s')."_thumb_1.".$file_ext;
  //  move_uploaded_file($_FILES['file']['tmp_name'],$new_name);
         move_uploaded_file($file_tmp,"../upload/player_images/".$new_name_2);
         
		 $sql_wid_pgif_2 = "update homepage set  p1_thumb='$new_name_2' where HomeID=1 "; //die;
			mysqli_query($connect, $sql_wid_pgif_2);
		 
      }else{
         print_r($errors);
      }
   }
   
      if(isset($_FILES['p2thu'])){
      $errors= array();
      $file_name = $_FILES['p2thu']['name'];
      $file_size =$_FILES['p2thu']['size'];
      $file_tmp =$_FILES['p2thu']['tmp_name'];
      $file_type=$_FILES['p2thu']['type'];
      $file_ext=strtolower(end(explode('.',$_FILES['p2thu']['name'])));
      
      $extensions= array("jpeg","jpg","png");
      
      if(in_array($file_ext,$extensions)=== false){
         $errors[]="extension not allowed, please choose a JPEG  or PNG file.";
      }
      
      if($file_size > 1097152){
         $errors[]='File size must be excately 1 MB';
      }
      
      if(empty($errors)==true){
		  $new_name_2=date('m_d_Y_H_i_s')."_thumb_2.".$file_ext;
  //  move_uploaded_file($_FILES['file']['tmp_name'],$new_name);
         move_uploaded_file($file_tmp,"../upload/player_images/".$new_name_2);
         
		 $sql_wid_pgif_2 = "update homepage set  p2_thumb='$new_name_2' where HomeID=1 "; //die;
			mysqli_query($connect, $sql_wid_pgif_2);
		 
      }else{
         print_r($errors);
      }
   }
   
   if(isset($_FILES['p3thu'])){
      $errors= array();
      $file_name = $_FILES['p3thu']['name'];
      $file_size =$_FILES['p3thu']['size'];
      $file_tmp =$_FILES['p3thu']['tmp_name'];
      $file_type=$_FILES['p3thu']['type'];
      $file_ext=strtolower(end(explode('.',$_FILES['p3thu']['name'])));
      
      $extensions= array("jpeg","jpg","png");
      
      if(in_array($file_ext,$extensions)=== false){
         $errors[]="extension not allowed, please choose a JPEG  or PNG file.";
      }
      
      if($file_size > 1097152){
         $errors[]='File size must be excately 1 MB';
      }
      
      if(empty($errors)==true){
		  $new_name_2=date('m_d_Y_H_i_s')."_thumb_3.".$file_ext;
  //  move_uploaded_file($_FILES['file']['tmp_name'],$new_name);
         move_uploaded_file($file_tmp,"../upload/player_images/".$new_name_2);
         
		 $sql_wid_pgif_2 = "update homepage set  p3_thumb='$new_name_2' where HomeID=1 "; //die;
			mysqli_query($connect, $sql_wid_pgif_2);
		 
      }else{
         print_r($errors);
      }
   }




 //die;
header('Location: player_admin.php');
