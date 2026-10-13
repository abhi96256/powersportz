<?php
//VAR_DUMP($_POST); die;
$connect = mysqli_connect("10.10.10.28", "powersport", "Dgt569khd", "powersport");
//$connect = mysqli_connect("localhost", "root", "", "ps");

//$connect = mysqli_connect("52.193.254.0", "powersport", "Google@123", "powersport");
//$number = count($_POST["name"]);





$l_text = $_POST["p1t"];
$l_link = $_POST["p1u"];
$l_active = $_POST["wcwidget1"];



if($l_text !=''){

$sql_wid_main = "update homepage set  l_text='$l_text'  ,  l_link='$l_link' ,  l_active=$l_active

where HomeID=1 "; //die;
//echo $sql_wid_main; die;
			mysqli_query($connect, $sql_wid_main);

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
         
		 $sql_wid_pgif_2 = "update homepage set  l_thumb='$new_name_2' where HomeID=1 "; //die;
			mysqli_query($connect, $sql_wid_pgif_2);
		 
      }else{
         print_r($errors);
      }
   }



 //die;
header('Location: popup_admin.php');
