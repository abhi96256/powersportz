<?php
require_once("Login/session.php");
require_once("Login/class.user.php");

	
	$auth_user = new USER();
	//var_dump($_POST);
	$action=$_POST['action'];
		$sub_id=$_POST['id'];
	if($action=='edit'){
	

	 $mby=$_SESSION['user_session'];
		$name=$_POST['name'];
		$stmt = $auth_user->runQuery("update mst_subject set sub_name=:sub_name,lmon=now(),lmby=:lmby WHERE sub_id=:sub_id");
		
		$stmt->bindparam(":sub_id", $sub_id);
		$stmt->bindparam(":sub_name", $name);
		$stmt->bindparam(":lmby", $mby);
		
		//$stmt->bindParam (":lmon", now());
		//$stmt->bindparam(":lmby", $lmby);
	
	$stmt->execute();
	//return 'updatd';
	//var_dump($stmt); 
	}elseif($action=='delete'){
		
		$stmt = $auth_user->runQuery("delete from mst_subject  WHERE sub_id=:sub_id");
		
		$stmt->bindparam(":sub_id", $sub_id);
		$stmt->execute();
		
		//var_dump($stmt);
	}
 ?>