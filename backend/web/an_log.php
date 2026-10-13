<?php
echo "Server Actual DateTime :: ".  date( "Y-m-d H:i:s"); echo "<br><br>"; //die;
$connect = mysqli_connect("10.10.10.28", "powersport", "Dgt569khd", "powersport");
//$connect = mysqli_connect("localhost", "root", "root", "powersportztv");

 $slot_v_time= date('Y-m-d', strtotime('-1 days'));
$slot_v_time_2= date('Y-m-d', strtotime('-2 days')); 
 //die;
   //echo 'hi'; die;
           $slot_today_time= date( "Y-m-d"); // die;
           
          
           
       
            
            
           echo  $sql_slot="SELECT count(*) as cnt FROM `ad_analytics` where date(aa_datetime)='$slot_v_time'";
            
            

           if ($result_slot=mysqli_query($connect,$sql_slot))
  {
 
  while ($row_slot=mysqli_fetch_row($result_slot))
    {
     // echo 'in'; die;
     //   echo '</br/></br>';
           $slot_id=$row_slot[0];
           echo " <h1>ad_analytics  $slot_v_time = $slot_id </h1>";
           
    }
  }
  
        echo     $sql_slot_log="SELECT count(*) as cnt FROM `ad_analytics_log` where date(aa_datetime)='$slot_v_time'";
            
            

           if ($result_slot_log=mysqli_query($connect,$sql_slot_log))
  {
 
  while ($row_slot_log=mysqli_fetch_row($result_slot_log))
    {
      echo '</br/></br>'; //die;
           $slot_id_log=$row_slot_log[0];
           echo "<h1>ad_analytics_log $slot_v_time = $slot_id_log </h1>";
           
    }
  }
  
  
  
  //die;
  
  if($slot_id_log==0){
      
            
      echo      $sql_slot_ins="insert into ad_analytics_log(`aa_slot_id`, `aa_userid`, `aa_ad_id`, `aa_duration`,
               `aa_ip`, `aa_ua`, `aa_session`, `aa_datetime`, `aa_page`)
SELECT  `aa_slot_id`, `aa_userid`, `aa_ad_id`, `aa_duration`, `aa_ip`, `aa_ua`, `aa_session`, `aa_datetime`,
`aa_page` FROM `ad_analytics` where date(aa_datetime)='$slot_v_time'";
            
      //  die;    

           if ($result_slot_ins=mysqli_query($connect,$sql_slot_ins))
  {
 
 
      echo '</br/></br>'; //die;
           $slot_id_ins=$row_slot_ins[0];
           echo "<h1>ad_analytics to ad_analytics_log  $slot_v_time done ! </h1>";
           
    
  }else{
       echo "<h1>Problem in Inserting(db connection) for date $slot_v_time </h1>";
  }
      
      
  }else{
      
      echo "<h1>Already Inserted for date $slot_v_time </h1>";
      
  }
  
  
            echo  $sql_slot_his="SELECT count(*) as cnt FROM ad_slots_his where as_createdon='$slot_v_time'";
            
            

           if ($result_slot_his=mysqli_query($connect,$sql_slot_his))
  {
 
  while ($row_slot_his=mysqli_fetch_row($result_slot_his))
    {
     // echo 'in'; die;
           $slot_id_his=$row_slot_his[0];
           echo " <h1>slot History  $slot_v_time = $slot_id_his </h1>";
           
    }
  }
  
   
  if($slot_id_his==0){
      
            
      echo      $sql_slot_ins_his="INSERT INTO `ad_slots_his`( `as_ad_id`, `as_starttime`, `as_createdon`) 
SELECT `as_ad_id`,`as_starttime`,'$slot_v_time' FROM ad_slots_his      WHERE `as_createdon`='$slot_v_time_2'";
            
       // die;    

           if ($result_slot_ins_his=mysqli_query($connect,$sql_slot_ins_his))
  {
 
 
      echo '</br/></br>'; //die;
           $slot_id_ins_his=$row_slot_ins_his[0];
           echo "<h1>slot  to slot his from $slot_v_time_2 to  $slot_v_time done ! </h1>";
           
    
  }else{
       echo "<h1>Problem in Inserting(db connection) for date $slot_v_time </h1>";
  }
      
      
  }else{
      
      echo "<h1>Already Inserted for date $slot_v_time </h1>";
      
  }