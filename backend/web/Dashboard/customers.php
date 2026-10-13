<?php
//echo $_POST["signup_v1[name]"]['signup_v1']; //die;
//echo $_POST[signup_v1][name];
//echo $_POST['submit'];



   if(isset($_POST[signup_v1][name]))
{ //print_r($_POST); die;//echo 'inside'; die;
     
     $conn=mysqli_connect("localhost","root","root","aresglobaldb");

if(!$conn)
{
die("Connection failed: " . mysqli_connect_error());
}

/*
$sqlfind="select customerID from customerdetail where customerID='".$_POST[signup_v1][customerid]."'";

$resultfind = mysqli_query($conn,$sqlfind);

 $rowcount=mysqli_num_rows($resultfind);
 
 

  mysqli_free_result($resultfind);
  
  if($rowcount>0){
      echo 'exist'; die;
  }
*/


foreach ($_POST['recdoclist'] as $wselectedOption => $value) {
		 $selectedOption .= $value.','; // I am separating Values with a comma (,) so that I can extract data using explode()
	}
        //echo $selectedOption;
        
        foreach ($_POST['peddoclist'] as $wselectedOption1 => $value1) {
		 $selectedOption1 .= $value1.','; // I am separating Values with a comma (,) so that I can extract data using explode()
	}
       // echo $selectedOption1;

 $recdoc=$selectedOption;
    $recdoc=rtrim($recdoc,',');
  //$recodc=rtrim($recodc,',');


 $peddoc=$selectedOption1;
   $peddoc=rtrim($peddoc,',');

//die;//src="../old_site/admin/eTokenType.php" eTokenNo mCustomerType
     
    $sql = "INSERT INTO `customerdetail`( `regnDate`, `customerID`, `name`, `companyName`, `emailID`, 
            `customerDOB`, `contactNo`, `mobileNo`, `address`, `userName`, 
            `typeID`, `department`, `division`, `desg`, `transactionType`, `dd_infavour`, 
            `dd_chequeNo`, `amount`, `aReceived`, `payRecDate`, `paymentStatus`, `dd_chequeDate`, 
            `bankName`, `dscStatus`, `hDsc`, `hPersonName`, `designation`, `hPersonMobileNo`, `dscRecvDate`, 
            `e_token`, `e_tokenNo`, `e_tokenPassword`, `e_tokenType`, `rDox`, `doxRecd`, `doxRecVia`, `pDoxName`, 
            `coverID`, `refferedBy`,  `panCategory`, `panNo`,departmentType,country,state,city,picode,createdBy) 
            VALUES ('".$_POST[signup_v1][date]."','".$_POST[signup_v1][customerid]."','".$_POST[signup_v1][name]."',
                '".$_POST[signup_v1][cname]."','".$_POST[signup_v1][email]."','".$_POST[signup_v1][dob]."',
                    '".$_POST[signup_v1][landline]."','".$_POST[signup_v1][contact]."','".$_POST[depaddress]."',
                        '".$_POST[Loginid]."','".$_POST[producttype]."','".$_POST[signup_v1][department]."',
                    '".$_POST[signup_v1][Division]."','".$_POST[signup_v1][designation]."','".$_POST[signup_v1][paymethod]."',
                     '".$_POST[signup_v1][ddfavorof]."','".$_POST[signup_v1][ddneftrefno]."','".$_POST[signup_v1][paymentamount]."',
                       '".$_POST[signup_v1][amountreceived]."','".$_POST[signup_v1][amountreceiveddate]."','".$_POST[signup_v1][paymentstatus]."',  
                    '".$_POST[signup_v1][ddneftrefdate]."','".$_POST[signup_v1][bankname]."','".$_POST[signup_v1][dsccreated]."',
                        '".$_POST[signup_v1][dschandover]."','".$_POST[signup_v1][dschandoverperson]."','".$_POST[signup_v1][dschanddesignation]."',
                      '".$_POST[signup_v1][dschanddmobile]."','".$_POST[signup_v1][dschanddate]."','".$_POST[etokenyn]."',
                          '".$_POST[etokenno]."','".$_POST[signup_v1][etpwd]."','".$_POST[etokentype]."',
                   '".$_POST[recdoc]."','".$recdoc."','".$_POST[signup_v1][modeofrecdoc]."',
                       '".$peddoc."','".$_POST[signup_v1][coverid]."','".$_POST[signup_v1][refby]."',
                           '".$_POST[signup_v1][pancategory]."','".$_POST[signup_v1][panno]."','".$_POST[signup_v1][departmentType]."','".$_POST[country]."',
                               '".$_POST[state]."','".$_POST[city]."','".$_POST[signup_v1][picode]."','".$_POST[creby]."'
                    )";

    $result = mysqli_query($conn,$sql); //die;
    
   // $message = "Your Digital Signature Cert. has been created successfully on " . $aj->params->regnDate . " for " . $type["duration"] . " Years.
//Thank you for choosing .
//Any query call @ 9560487000";
 
    
$url = "http://login.redsms.in/API/SendMessage.ashx?user=ares&password=Hemant@123&phone=9873214648&text=test%20messagedemo&type=t&senderid=ARESGS"; //the gateway's interface provided by the gateway provider
 
 
 
$ch = curl_init;
 
curl_setopt($ch, CURLOPT_URL, $url);
 
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
 
curl_setopt($ch, CURLOPT_POST, 1);
 
curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
 
$response = curl_exec($ch);
 
curl_close($ch);
    

      //sms api
    //http://login.redsms.in/API/SendMessage.ashx?user=ares&password=Hemant@123&phone=9873214648&text=test%20message&type=t&senderid=ARESGS
 

    
    
}


require_once("Login/session.php");

require_once("Login/class.user.php");


$auth_user = new USER();


$user_id = $_SESSION['user_session'];

$stmt = $auth_user->runQuery("SELECT * FROM admin_users WHERE user_id=:user_id");
$stmt->execute(array(":user_id" => $user_id));

$userRow = $stmt->fetch(PDO::FETCH_ASSOC);
//print_r($_SESSION);die;
?>
<!DOCTYPE html>

<html>
    <head lang="en">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Dashboard</title>

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

        <link rel="stylesheet" href="css/separate/vendor/bootstrap-select/bootstrap-select.min.css">
        <link rel="stylesheet" href="css/separate/vendor/select2.min.css">
        <link rel="stylesheet" href="css/lib/font-awesome/font-awesome.min.css">
        <link rel="stylesheet" href="css/lib/bootstrap/bootstrap.min.css">
        <link rel="stylesheet" href="css/main.css">
        <link rel="stylesheet" href="css/lib/datatables-net/datatables.min.css">
        <link rel="stylesheet" href="css/separate/vendor/datatables-net.min.css">
    </head>
    <body class="with-side-menu control-panel control-panel-compact">

        <?php include("inc/head.php"); ?>

        <div class="mobile-menu-left-overlay"></div>
        <?php include("inc/left.php"); ?>


        <div class="page-content">
            <div class="container-fluid">
           

                <section class="card">
                    <div class="card-block">

                        <form id="form-signup_v1" name="form-signup_v1" method="POST">
                            <h5 class="with-border m-t-lg" style="color:  #0095dd">Customer Information</h5>

                            <div class="row">
                                <div class="col-md-4">
                                    <fieldset class="form-group">
                                        <label class="form-label" for="signup_v1-date">Date of Registration<span class="color-red">*</span></label>

                                        <input id="signup_v1-date" 
                                               class="form-control"
                                               name="signup_v1[date]"
                                               type="date"
                                               value="<?php //echo date("Y-m-d"); ?>"
                                               data-validation="[NOTEMPTY]"
                                               data-validation-message="$ must be at selected">


                                    </fieldset>
                                </div>
                                <div class="col-md-4">
                                    <fieldset class="form-group">
                                        <label class="form-label" for="signup_v1-customerid">	Customer Id<span class="color-red">*</span></label>

                                        <input id="signup_v1-customerid"
                                               class="form-control"
                                               name="signup_v1[customerid]"
                                               type="text"
                                               data-validation="[NOTEMPTY]"
                                               data-validation-message="$ must be at filled">

 <small class="text-muted">Must be unique</small>
                                    </fieldset>
                                </div>

                                <div class="col-md-4">
                                    <fieldset class="form-group">
                                        <label class="form-label" for="signup_v1-name">	Name<span class="color-red">*</span></label>
                                        <input id="signup_v1-name"
                                               class="form-control"
                                               name="signup_v1[name]"
                                               type="text"
                                               data-validation="[NOTEMPTY]"
                                               data-validation-message="$ must be at filled" maxlength="35" >
                                        <small class="text-muted">Max length 35</small>
                                    </fieldset>
                                </div>
                                
                                   <div class="col-md-4">
                                        <fieldset class="form-group">
                                            <label class="form-label" for="signup_v1-cname">Company Name</label>

                                            <input id="signup_v1-cname" 
                                                   class="form-control"
                                                   name="signup_v1[cname]"
                                                   type="text"
                                                   >


                                        </fieldset>
                                    </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label" for="signup_v1-email">Email<span class="color-red">*</span></label>
                                        <div class="form-control-wrapper">
                                            <input id="signup_v1-email"
                                                   class="form-control"
                                                   name="signup_v1[email]"
                                                   type="text"
                                                   data-validation="[EMAIL]">
                                            <small class="text-muted">Email's will be sent to this  only.</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label" for="signup_v1-contact">Mobile No<span class="color-red">*</span></label>
                                        <div class="form-control-wrapper">
                                            <input id="signup_v1-contact"
                                                   class="form-control"
                                                   name="signup_v1[contact]"
                                                   type="number"
                                                   data-validation="[L>=10, L<=12, NUMBER]">
                                            <small class="text-muted">Messages will be sent to this number only.</small>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <fieldset class="form-group">
                                        <label class="form-label" for="signup_v1-dob">Date of Birth</label>

                                        <input id="signup_v1-dob" 
                                               class="form-control"
                                               name="signup_v1[dob]"
                                               type="date"

                                               >


                                    </fieldset>
                                </div>


                            </div>
                            <h5 class="with-border" style="color:  #0095dd;margin-top:20px">Department Information</h5>




                            <div class="row">
                                
                                 
                                <div class="col-md-4">
                                    <label class="form-label" for="signup_v1-departmentType">Department Category</label>
                                    <select id="ddlPassport" class="select2" name="signup_v1[departmentType]"

                                            data-validation="[NOTEMPTY]"
                                            data-validation-message="$ must be selected">

                                        <option selected value="Government">Government</option>
                                        <option value="Other">Other</option>


                                    </select>
                                    <br/>
                                    <br/>  <small class="text-muted">&nbsp;</small>
                                </div>
                                <div id="dvPassport">
                                    <div class="col-md-4">
                                        <fieldset class="form-group">
                                            <label class="form-label" for="signup_v1-department">Department</label>

                                            <input id="signup_v1-department" 
                                                   class="form-control"
                                                   name="signup_v1[department]"
                                                   type="text"
                                                   >


                                        </fieldset>
                                    </div>
                                    <div class="col-md-4">
                                        <fieldset class="form-group">
                                            <label class="form-label" for="signup_v1-Division"> Division</label>

                                            <input id="signup_v1-Division"
                                                   class="form-control"
                                                   name="signup_v1[Division]"
                                                   type="text"
                                                   >


                                        </fieldset>
                                    </div> </div>

                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <fieldset class="form-group">
                                        <label class="form-label" for="signup_v1-designation">Designation</label>

                                        <input id="signup_v1-designation" 
                                               class="form-control"
                                               name="signup_v1[designation]"
                                               type="text"
                                               >


                                    </fieldset>
                                    <small class="text-muted">&nbsp;</small>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label" for="signup_v1-pancategory">PAN Category</label>
                                    <select class="select2" name="signup_v1[pancategory]"

                                            data-validation="[NOTEMPTY]"
                                            data-validation-message="$ must be selected">
                                        <option value="">-- Select PAN Category --</option>
                                        <option value="N/A">N/A</option>
                                        <option value="Individual">Individual</option>
                                        <option value="Company">Company</option>
                                        <option value="Firm / Limited Liability Partnership">Firm / Limited Liability Partnership</option>
                                        <option value="Government">Government</option>


                                    </select>
                                    <br/>
                                    <br/>
                                </div>
                                <div class="col-md-4">
                                    <fieldset class="form-group">
                                        <label class="form-label" for="signup_v1-panno">	PAN No</label>

                                        <input id="signup_v1-panno"
                                               class="form-control"
                                               name="signup_v1[panno]"
                                               type="text"
                                               data-validation="[NOTEMPTY]"
                                               data-validation-message="$ must be filled"
                                               >


                                    </fieldset>
                                </div>  </div><div class="row">


                                <div class="col-md-4">
                                    <fieldset class="form-group">
                                        <label class="form-label" for="signup_v1-landline">	Landline No</label>

                                        <input id="signup_v1-landline"
                                               class="form-control"
                                               name="signup_v1[landline]"
                                               type="text"
                                               >


                                    </fieldset>
                                    <small class="text-muted">&nbsp;</small>
                                </div>



                                <div class="col-md-4">
                                    <fieldset class="form-group">
                                        <label class="form-label" for="country">	Country</label>

                                        <select  name="country"   class="select2 countries" id="countryId" >
                                            <option value="">--Select Country--</option>
                                        </select>


                                    </fieldset>
                                </div>


                                <div class="col-md-4">
                                    <fieldset class="form-group">
                                        <label class="form-label" for="country">	State</label>

                                        <select name="state"   class="select2 states" id="stateId" >
                                            <option value="">-- Select State --</option>
                                        </select>


                                    </fieldset>
                                </div> </div><div class="row">

                                <div class="col-md-4">
                                    <fieldset class="form-group">
                                        <label class="form-label" for="country">	City</label>

                                        <select name="city"   class="select2 cities" id="cityId" >
                                            <option value="">-- Select City --</option>
                                        </select>


                                    </fieldset>
                                </div>















                                <div class="col-md-4">
                                    <fieldset class="form-group">
                                        <label class="form-label" for="signup_v1-pincode">	Pin Code</label>

                                        <input id="signup_v1-pincode"
                                               class="form-control"
                                               name="signup_v1[picode]"
                                               type="text"
                                               >


                                    </fieldset>
                                </div>
                                <div class="col-xs-4">
                                    <fieldset class="form-group">
                                        <label class="form-label" for="depaddress">Department Address</label>
                                        <textarea rows="3" name="depaddress" class="form-control maxlength-simple" placeholder="Address max length 250 chars" maxlength="250"></textarea>
                                    </fieldset>
                                </div>


                            </div>



                            <h5 class="with-border" style="color:  #0095dd;margin-top:0px">Digital Signature Certificate(DSC) Detail</h5>
                            <div class="row">
                                <div class="col-md-4">
                                    <fieldset class="form-group">
                                        <label class="form-label" for="Loginid">	Login ID</label>

                                        <select  name="Loginid"  data-validation="[NOTEMPTY]"
                                                 data-validation-message="$ must be selected" class="select2" id="Loginid" required="required">


                                            <option value="">--Select Login ID --</option>
                                            <?php
                                            try {





                                                $stmt = $auth_user->runQuery("SELECT distinct `loginID` FROM customertype");
                                                $stmt->execute();
                                                if ($stmt->rowCount() > 0) {
                                                    $i = 1;
                                                    while ($row1 = $stmt->fetch()) {
                                                        ?>

                                                        <option value="<?php echo $row1['loginID']; ?>"><?php echo $row1['loginID']; ?></option>




            <?php
            $i++;
        }
    } else {
        echo 'No Data Available !';
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}
?>

                                        </select>


                                    </fieldset>
                              
                                </div>


                                <div class="col-md-4">
                                    <fieldset class="form-group">
                                        <label class="form-label" for="producttype">	Product Type</label>

                                        <select onChange="getdocs(this.value);"  name="producttype"  data-validation="[NOTEMPTY]"
                                                data-validation-message="$ must be selected" class="select2" id="producttype" required="required">


                                            <option value="">--Select Product Type --</option>
<?php
try {





    $stmt = $auth_user->runQuery("SELECT distinct typeID,`typeName` FROM customertype");
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        $i = 1;
        while ($row1 = $stmt->fetch()) {
            ?>

                                                        <option value="<?php echo $row1['typeID']; ?>"><?php echo $row1['typeName']; ?></option>




            <?php
            $i++;
        }
    } else {
        echo 'No Data Available !';
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}
?>

                                        </select>


                                    </fieldset>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label" for="signup_v1-paymethod">	Payment Method</label>
                                    <select id="ddlPassport1" class="select2" name="signup_v1[paymethod]"

                                            >
                              
                                        <option value="DD">DD</option>
                                        <option value="CHEQUE">CHEQUE</option>
                                        <option selected value="CASH">CASH</option>
                                        <option value="RTGD">RTGS</option>
                                        <option value="NEFT">NEFT</option>


                                    </select>
                                    <br/>
                                    <br/>
                                </div>
          <div class="row">
<div  id="p4" style="display: none">
                                <div class="col-md-4">
                                       <fieldset class="form-group">
                                    <label class="form-label" for="signup_v1-ddfavorof">		
                                        DD IN FAVOUR OF</label>
                                    <select id="ddlPassport" class="select2"  name="signup_v1[ddfavorof]"

                                           >
                                        <option value="">--Select Option--</option>
                                        <option value=""></option>
                                        <option value="(n)Code Solutions">(n)Code Solutions</option>



                                    </select>
                                      </fieldset>
                                </div> </div>

<div  id="p5" style="display: none">
                                <div class="col-md-4">
                                    <fieldset class="form-group">
                                        <label class="form-label" for="signup_v1-ddneftrefno">	DD/CHEQUE/RTGS/NEFT- No.</label>

                                        <input id="signup_v1-ddneftrefno"
                                               class="form-control"
                                               name="signup_v1[ddneftrefno]"
                                               type="text"
                                               >


                                    </fieldset>
                                </div>

                                <div class="col-md-4">
                                    <fieldset class="form-group">
                                        <label class="form-label" for="signup_v1-ddneftrefdate">	DD/CHEQUE/RTGS/NEFT- Date.</label>

                                        <input id="signup_v1-ddneftrefdate"
                                               class="form-control"
                                               name="signup_v1[ddneftrefdate]"
                                               type="Date"
                                               >


                                    </fieldset>
                                </div> </div>
          </div>
                                <div class="col-md-4">
                                    <fieldset class="form-group">
                                        <label class="form-label" for="signup_v1-paymentamount">	Total Amount</label>

                                        <input id="signup_v1-paymentamount"
                                               class="form-control"
                                               name="signup_v1[paymentamount]"
                                               type="text"
                                               >


                                    </fieldset>
                                </div>

                                <div class="col-md-4">
                                    <fieldset class="form-group">
                                        <label class="form-label" for="signup_v1-amountreceived">	 Amount Received</label>

                                        <input id="signup_v1-amountreceived"
                                               class="form-control"
                                               name="signup_v1[amountreceived]"
                                               type="text"
                                               >


                                    </fieldset>
                                </div>

                                <div class="col-md-4">
                                    <fieldset class="form-group">
                                        <label class="form-label" for="signup_v1-amountreceiveddate">	Amount Received Date</label>

                                        <input id="signup_v1-amountreceiveddate"
                                               class="form-control"
                                               name="signup_v1[amountreceiveddate]"
                                               type="date"
                                               >


                                    </fieldset>
                                </div>


                                <div class="col-md-4">
                                    <label class="form-label" for="signup_v1-paymentstatus">		
                                        Payment Status</label>
                                    <select id="ddlPassport" class="select2" name="signup_v1[paymentstatus]"

                                            >
                                        <option value="">--Select Option--</option>
                                        <option value="Pending">Pending</option>
                                        <option value="Received">Received</option>



                                    </select>
                                    <br/>
                                    <br/>
                                </div>

                                <div class="col-md-4">
                                    <fieldset class="form-group">
                                        <label class="form-label" for="signup_v1-bankname">	Bank Name</label>

                                        <input id="signup_v1-bankname"
                                               class="form-control"
                                               name="signup_v1[bankname]"
                                               type="text"
                                               >


                                    </fieldset>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label" for="signup_v1-dsccreated">		

                                        DSC Created</label>
                                    <select id="ddlPassport3" class="select2" name="signup_v1[dsccreated]"

                                            >
                                        <option value="">--Select Option--</option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>



                                    </select>
                                    <br/>
                                    <br/>
                                </div>
                                <div id="p6" style="display: none">
                                <div class="col-md-4">
                                    <label class="form-label" for="signup_v1-dschandover">		

                                        DSC Handover</label>
                                    <select id="ddlPassport4" class="select2" name="signup_v1[dschandover]"

                                            >
                                        <option value="">--Select Option--</option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>



                                    </select>
                                    <br/>
                                    <br/>
                                </div>

                                </div>
                                <div id="p7" style="display: none">
                                <div class="col-md-4">
                                    <fieldset class="form-group">
                                        <label class="form-label" for="signup_v1-dschandoverperson">		
                                            Handover to Person</label>

                                        <input id="signup_v1-dschandoverperson"
                                               class="form-control"
                                               name="signup_v1[dschandoverperson]"
                                               type="text"
                                               >


                                    </fieldset>
                                </div>

                                <div class="col-md-4">
                                    <fieldset class="form-group">
                                        <label class="form-label" for="signup_v1-dschanddesignation">		

                                            Designation in Company</label>

                                        <input id="signup_v1-dschanddesignation"
                                               class="form-control"
                                               name="signup_v1[dschanddesignation]"
                                               type="text"
                                               >


                                    </fieldset>
                                </div></div></div>
                            <div class="row">
                                <div id="p8" style="display: none">
                                <div class="col-md-4">
                                    <fieldset class="form-group">
                                        <label class="form-label" for="signup_v1-dschanddmobile">		
                                            Handover to Person Mobile No.</label>

                                        <input id="signup_v1-dschanddmobile"
                                               class="form-control"
                                               name="signup_v1[dschanddmobile]"
                                               type="text"
                                               >


                                    </fieldset>
                                </div>

                                <div class="col-md-4">
                                    <fieldset class="form-group">
                                        <label class="form-label" for="signup_v1-dschanddate">		

                                            DSC Handover Date</label>

                                        <input id="signup_v1-dschanddate"
                                               class="form-control"
                                               name="signup_v1[dschanddate]"
                                               type="date"
                                               >


                                    </fieldset>
                                </div> </div>
                            </div>




                            <h5 class="with-border" style="color:  #0095dd;margin-top:20px">E-Token  & Documents Detail</h5>
                            <div class="row">



                                <div class="col-md-10 col-sm-10">
                                    <div class="checkbox-detailed">
                                        <input onChange="getothdiv(this.value);" type="radio" value="Y" name="etokenyn" id="check-det-1" />
                                        <label for="check-det-1">
                                            <span class="checkbox-detailed-tbl">
                                                <span class="checkbox-detailed-cell">
                                                    <span class="checkbox-detailed-title">Yes , with E-Token </span>

                                                </span>
                                            </span>
                                        </label>
                                    </div>
                                    <div class="checkbox-detailed">
                                        <input type="radio" onChange="getothdiv(this.value);" name="etokenyn" value="N" id="check-det-2" checked />
                                        <label for="check-det-2">
                                            <span class="checkbox-detailed-tbl">
                                                <span class="checkbox-detailed-cell">
                                                    <span class="checkbox-detailed-title">No , without E-Token</span>

                                                </span>
                                            </span>
                                        </label>
                                    </div>
                                </div>
                                
                                <div id="p1" style="display:none">
                                <div class="col-md-4">
                                    <fieldset class="form-group">
                                        <label class="form-label" for="etokentype">		
                                            E-Token Type</label>

                                        <select onChange="gettokens(this.value);"  name="etokentype"  class="select2" >


                                            <option value="">--Select E-Token Type --</option>
<?php
try {





    $stmt = $auth_user->runQuery("SELECT `token_ID`,`t_type` FROM etokentype	 WHERE `t_status`='Active'");
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        $i = 1;
        while ($row1 = $stmt->fetch()) {
            ?>

                                                        <option value="<?php echo $row1['token_ID']; ?>"><?php echo $row1['t_type']; ?></option>




            <?php
            $i++;
        }
    } else {
        echo 'No Data Available !';
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}
?>

                                        </select>


                                    </fieldset>
                                </div>

                                <div class="col-md-4">
                                    <fieldset class="form-group">
                                        <label class="form-label" for="etokenno">		

                                            E-token No.</label>

                                        <select id="state-list"   name="etokenno"   class="select2" >




                                        </select>


                                    </fieldset>
                                </div>


                                <div class="col-md-4">
                                    <fieldset class="form-group">
                                        <label class="form-label" for="signup_v1-etpwd">		
                                            E-Token Password</label>

                                        <input id="signup_v1-etpwd"
                                               class="form-control"
                                               name="signup_v1[etpwd]"
                                               type="text"
                                               >


                                    </fieldset>
                                </div>
                                </div>


                                <div class="col-md-10 col-sm-10">
                                    <div class="checkbox-detailed">
                                        <input type="radio" onChange="getp2(this.value);" name="recdoc" value="Y" id="check-recdoc-1" />
                                        <label for="check-recdoc-1">
                                            <span class="checkbox-detailed-tbl">
                                                <span class="checkbox-detailed-cell">
                                                    <span class="checkbox-detailed-title">	Received Documents , Yes </span>

                                                </span>
                                            </span>
                                        </label>
                                    </div>
                                    <div class="checkbox-detailed">
                                        <input onChange="getp2(this.value);" type="radio" name="recdoc" checked value="N" id="check-recdoc-2"/>
                                        <label for="check-recdoc-2">
                                            <span class="checkbox-detailed-tbl">
                                                <span class="checkbox-detailed-cell">
                                                    <span class="checkbox-detailed-title">	Received Documents , No</span>

                                                </span>
                                            </span>
                                        </label>
                                    </div>
                                </div>
<div id="p2" style="display:none">
                                <div class="col-md-4">
                                    <label class="form-label" for="recdoclist">	Document Received List</label>
                                    <select id="docseg" multiple class="select2" name="recdoclist[]"

                                            
                                           >





                                    </select>
                                    <br/>
                                    <br/>
                                </div>




                                <div class="col-md-4">
                                    <label class="form-label" for="signup_v1-modeofrecdoc">	Mode of Document Received</label>
                                    <select id="signup_v1-modeofrecdoc" class="select2" name="signup_v1[modeofrecdoc]"

                                          >
                                        <option value="">--Select Option--</option>
                                        <option value="By ARES">By ARES </option>    
                                        <option value="By Courier">By Courier</option>
                                        <option value="By Customer">By Customer</option>



                                    </select>
                                    <br/>
                                    <br/>
                                </div>
</div>

                                <div class="col-md-10 col-sm-10">
                                    <div class="checkbox-detailed">
                                        <input type="radio" onChange="getp3(this.value);"  name="recdoc2" value="Y" id="check-recdoc1-1" />
                                        <label for="check-recdoc1-1">
                                            <span class="checkbox-detailed-tbl">
                                                <span class="checkbox-detailed-cell">
                                                    <span class="checkbox-detailed-title">	Pending Documents , Yes </span>

                                                </span>
                                            </span>
                                        </label>
                                    </div>
                                    <div class="checkbox-detailed">
                                        <input type="radio" onChange="getp3(this.value);" value="N"  name="recdoc2" checked id="check-recdoc1-2"/>
                                        <label for="check-recdoc1-2">
                                            <span class="checkbox-detailed-tbl">
                                                <span class="checkbox-detailed-cell">
                                                    <span class="checkbox-detailed-title">	Pending Documents , No</span>

                                                </span>
                                            </span>
                                        </label>
                                    </div>
                                </div>
                                <div id="p3" style="display: none">
                                <div class="col-md-4">
                                    <label class="form-label" for="peddoclist">	 Pending Document List</label>
                                    <select id="docsegpen" multiple class="select2" name="peddoclist[]"

                                            >





                                    </select>
                                    <br/>
                                    <br/>
                                </div> </div>








                                <div class="col-md-4">
                                    <fieldset class="form-group">
                                        <label class="form-label" for="signup_v1-coverid">	Cover Id </label>

                                        <input id="signup_v1-coverid"
                                               class="form-control"
                                               name="signup_v1[coverid]"
                                               type="text"
                                               >


                                    </fieldset>
                                </div>

                                <div class="col-md-4">
                                    <fieldset class="form-group">
                                        <label class="form-label" for="signup_v1-refby">	Referred by</label>

                                        <input id="signup_v1-refby"
                                               class="form-control"
                                               name="signup_v1[refby]"
                                               type="text"
                                               >


                                    </fieldset>
                                </div>
                                
                                  <div class="col-md-12 col-sm-12">
                                          <div class="checkbox-detailed">
                                        <input type="radio"   value="N" checked  name="recdoc3"  id="check-recdoc2-4"/>
                                        <label for="check-recdoc2-4">
                                            <span class="checkbox-detailed-tbl">
                                                <span class="checkbox-detailed-cell">
                                                    <span class="checkbox-detailed-title">	NONE</span>

                                                </span>
                                            </span>
                                        </label>
                                    </div> 
                                    <div class="checkbox-detailed">
                                        <input type="radio"  name="recdoc3"  value="E" id="check-recdoc2-1" />
                                        <label for="check-recdoc2-1">
                                            <span class="checkbox-detailed-tbl">
                                                <span class="checkbox-detailed-cell">
                                                    <span class="checkbox-detailed-title">	Email Notification </span>

                                                </span>
                                            </span>
                                        </label>
                                    </div>
                                    <div class="checkbox-detailed">
                                        <input type="radio"  value="S"  name="recdoc3"  id="check-recdoc2-2"/>
                                        <label for="check-recdoc2-2">
                                            <span class="checkbox-detailed-tbl">
                                                <span class="checkbox-detailed-cell">
                                                    <span class="checkbox-detailed-title">	SMS Notification</span>

                                                </span>
                                            </span>
                                        </label>
                                    </div>
                                       <div class="checkbox-detailed">
                                           
                                               <input type="hidden"  value="<?php echo $userRow['user_name']; ?>"  name="creby"  />
                                        <input type="radio"  value="B"  name="recdoc3"  id="check-recdoc2-3"/>
                                        <label for="check-recdoc2-3">
                                            <span class="checkbox-detailed-tbl">
                                                <span class="checkbox-detailed-cell">
                                                    <span class="checkbox-detailed-title">	EMAIL + SMS Notification</span>

                                                </span>
                                            </span>
                                        </label>
                                    </div>
                                     
                                      
                                </div>




                            </div>


                            <button type="submit" name="save" id="save"  value="Create Customer" class="btn">Create Customer </button>
                            <!--.row--></form>
                    </div>
                </section>
            </div><!--.container-fluid-->
        </div><!--.page-content-->




        <script src="js/lib/datatables-net/datatables.min.js"></script>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.3.1/css/buttons.dataTables.min.css">
        <script type="text/javascript" language="javascript" src="//code.jquery.com/jquery-1.12.4.js">
        </script>
        <script src="js/lib/jquery/jquery.min.js"></script>
        <script src="js/lib/tether/tether.min.js"></script>
        <script src="js/lib/bootstrap/bootstrap.min.js"></script>
        <script src="js/plugins.js"></script>
        <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js">
        </script>
        <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js">
        </script>
        <script type="text/javascript" language="javascript" src="//cdn.datatables.net/buttons/1.3.1/js/buttons.flash.min.js">
        </script>
        <script type="text/javascript" language="javascript" src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js">
        </script>
        <script type="text/javascript" language="javascript" src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/pdfmake.min.js">
        </script>
        <script type="text/javascript" language="javascript" src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/vfs_fonts.js">
        </script>
        <script type="text/javascript" language="javascript" src="//cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js">
        </script>
        <script type="text/javascript" language="javascript" src="//cdn.datatables.net/buttons/1.3.1/js/buttons.print.min.js">
        </script>
        <script type="text/javascript" language="javascript" src="//cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js">
        </script>
        <script type="text/javascript" language="javascript" src="//cdn.datatables.net/buttons/1.3.1/js/buttons.colVis.min.js">
        </script>
        <script src="js/location.js"></script>   
        <script>
                                    function gettokens(val) { //alert(val);
                                        $.ajax({
                                            type: "POST",
                                            url: "get_token.php",
                                            data: 'country_id=' + val,
                                            success: function (data) {
                                                $("#state-list").html(data);
                                            }
                                        });
                                    }

                                    function getdocs(val) { //alert(val);
                                        $.ajax({
                                            type: "POST",
                                            url: "get_docs.php",
                                            data: 'country_id=' + val,
                                            success: function (data) {
                                                $("#docseg").html(data);
                                                $("#docsegpen").html(data);
                                            }
                                        });
                                    }
                                    
                                      function getothdiv(val) { 
                                         if (val == "Y") { //alert(val);
                                                                              $("#p1").show();
                                                                          } else {
                                                                              $("#p1").hide();
                                                                          }
                                    }
                                    
                                     function getp2(val) { 
                                         if (val == "Y") { //alert(val);
                                                                              $("#p2").show();
                                                                          } else {
                                                                              $("#p2").hide();
                                                                          }
                                    }
                                       function getp3(val) { 
                                         if (val == "Y") { //alert(val);
                                                                              $("#p3").show();
                                                                          } else {
                                                                              $("#p3").hide();
                                                                          }
                                    }


                                </script>
        <script type="text/javascript">
                                                                  $(function () {
                                                                      $("#ddlPassport").change(function () {
                                                                          if ($(this).val() == "Government") {
                                                                              $("#dvPassport").show();
                                                                          } else {
                                                                              $("#dvPassport").hide();
                                                                          }
                                                                      });


                                                                      $("#ddlPassport1").change(function () {
                                                                          if ($(this).val() == "DD") {
                                                                              $("#p4").show();
                                                                               $("#p5").hide();
                                                                          } else if ($(this).val() == "CASH") {
                                                                              $("#p4").hide();
                                                                               $("#p5").hide();
                                                                          } else {
                                                                              $("#p4").hide();
                                                                               $("#p5").show();
                                                                          }
                                                                      });
                                                                      
                                                                         $("#ddlPassport3").change(function () {
                                                                          if ($(this).val() == "Yes") {
                                                                              $("#p6").show();
                                                                               $("#p7").hide();
                                                                                 $("#p8").hide();
                                                                          } else {
                                                                              $("#p6").hide();
                                                                               $("#p7").hide();
                                                                                 $("#p8").hide();
                                                                          }
                                                                      });
                                                                      
                                                                        $("#ddlPassport4").change(function () {
                                                                          if ($(this).val() == "Yes") {
                                                                             
                                                                               $("#p7").show();
                                                                                $("#p8").show();
                                                                          } else {
                                                                            
                                                                               $("#p7").hide();
                                                                                $("#p8").hide();
                                                                          }
                                                                      });

                                                                  });
        </script>
        <script>
            $(document).ready(function () {

                var table = $('#example').DataTable({
                    "order": [[2, "desc"]],
                    "oLanguage": {
                        "sInfo": "Showing _START_ to _END_ of _TOTAL_ items."
                    },

                    dom: 'Bfrtip',
                    buttons: [
                        {
                            extend: 'copyHtml5',
                            exportOptions: {
                                columns: [0, ':visible']
                            }, title: 'Data_Visitors'
                        },
                        {
                            extend: 'print',
                            exportOptions: {
                                columns: [0, ':visible']
                            }, title: 'Data_Visitors'
                        },
                        {
                            extend: 'csv',
                            exportOptions: {
                                columns: [0, ':visible'],

                            }, title: 'Data_Visitors'
                        },
                        {
                            extend: 'excelHtml5',
                            exportOptions: {
                                columns: ':visible'
                            }, title: 'Data_Visitors'
                        },
                        {
                            extend: 'pdfHtml5',
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4, 5, 6]
                            }, title: 'Data_Visitors'
                        },
                        'colvis'
                    ]
                });



                $("#example tfoot th").each(function (i) {

                    if (i < 6) {



                        if ($(this).text() !== '') {
                            var isStatusColumn = (($(this).text() == 'Status') ? true : false);
                            var select = $('<select><option value=""></option></select>')
                                    .appendTo($(this).empty())
                                    .on('change', function () {
                                        var val = $(this).val();

                                        table.column(i)
                                                .search(val ? '^' + $(this).val() + '$' : val, true, false)
                                                .draw();
                                    });

                            // Get the Status values a specific way since the status is a anchor/image
                            if (isStatusColumn) {
                                var statusItems = [];

                                /* ### IS THERE A BETTER/SIMPLER WAY TO GET A UNIQUE ARRAY OF <TD> data-filter ATTRIBUTES? ### */
                                table.column(i).nodes().to$().each(function (d, j) {
                                    var thisStatus = $(j).attr("data-filter");
                                    if ($.inArray(thisStatus, statusItems) === -1)
                                        statusItems.push(thisStatus);
                                });

                                statusItems.sort();

                                $.each(statusItems, function (i, item) {
                                    select.append('<option value="' + item + '">' + item + '</option>');
                                });

                            }
                            // All other non-Status columns (like the example)
                            else {
                                table.column(i).data().unique().sort().each(function (d, j) {
                                    select.append('<option value="' + d + '">' + d + '</option>');
                                });
                            }

                        }
                    }
                });

            });


        </script>
        <script src="js/lib/select2/select2.full.min.js"></script>
        <script src="js/app.js"></script>
        <script src="js/lib/html5-form-validation/jquery.validation.min.js"></script>
        <script>
            $(function () {
                /* ==========================================================================
                 Validation
                 ========================================================================== */

                $('#form-signin_v1').validate({
                    submit: {
                        settings: {
                            inputContainer: '.form-group'
                        }
                    }
                });

                $('#form-signin_v2').validate({
                    submit: {
                        settings: {
                            inputContainer: '.form-group',
                            errorListClass: 'form-error-text-block',
                            display: 'block',
                            insertion: 'prepend'
                        }
                    }
                });

                $('#form-signup_v1').validate({
                    submit: {
                        settings: {
                            inputContainer: '.form-group',
                            errorListClass: 'form-tooltip-error'
                        }
                    }
                });

                $('#form-signup_v1').validate({
                    submit: {
                        settings: {
                            inputContainer: '.form-group',
                            errorListClass: 'form-tooltip-error'
                        }
                    }
                });
            });
        </script>

    </body>
</html>