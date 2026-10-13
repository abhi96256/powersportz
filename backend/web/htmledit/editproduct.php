<?php

error_reporting(0);

require_once("Login/class.user.php");
$auth_user = new USER();


$pid = $_REQUEST['vid'];



$stmtedit = $auth_user->runQuery("SELECT * FROM video where ID=:edit_id");
$stmtedit->execute(array(":edit_id" => $pid));
$userRowEdit = $stmtedit->fetch(PDO::FETCH_ASSOC);

$userRowSubCatID = $userRowEdit['Title'];
//echo $userRowEdit['rsmp_img'];die;



if (isset($_POST['submit'])) {
    //var_dump($_POST);
    // die;


    //$conn = mysqli_connect("localhost", "root", "root", "test");
    $conn = mysqli_connect("10.10.10.28", "powersport", "Dgt569khd", "powersport");
    if (!$conn) {
        die('Could not connect: ' . mysql_error());
    }

    $des = $_POST['long_desc'];
    //die;

    $sql1 = "update video
    set Description='" . $des . "'
        where ID='" . $pid . "' ";
    //echo $sql1;

    // $sql1 = "update `rsm_products`
    // set `rsmp_title`='" . $name . "',
    //  `rsmp_catid`='" . $dbcatid . "',
    //   `rsmp_subcatid`='" . $dbsubcat . "',
    //   rsmp_img= '" . $filename . "',
    //    `rsmp_description`='" . $des . "',
    //     `rsmp_about`='" . $about . "',
    //       `active`='" . $active . "',
    //        `rsmp_homepage`='" . $home . "' where rsmp_id='" . $pid . "'
    //         ";

    $result = mysqli_query($conn, $sql1);

    if ($result) {
        $savemsg = 1;
    } else {
        $savemsg = 2;
    }

    $stmtedit = $auth_user->runQuery("SELECT * FROM video where ID=:edit_id");
    $stmtedit->execute(array(":edit_id" => $pid));
    $userRowEdit = $stmtedit->fetch(PDO::FETCH_ASSOC);

    $userRowSubCatID = $userRowEdit['Title'];
}

?>

<!DOCTYPE html>

<html>

<head lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Edit VOD Description</title>

    <link rel="stylesheet" href="css/lib/font-awesome/font-awesome.min.css">
    <link rel="stylesheet" href="css/separate/vendor/select2.min.css">
    <link rel="stylesheet" href="css/lib/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/lib/datatables-net/datatables.min.css">
    <link rel="stylesheet" href="css/separate/vendor/datatables-net.min.css">

    <script src="ckeditor/ckeditor.js"></script>

</head>

<body class="control-panel control-panel-compact">



    <div class="page-content" style="padding: 0 !important;">
        <div class="container-fluid">


            <section class="card">
                <div class="card-block">
                    <form id="form-signup_v1" action="editproduct.php?vid=<?php echo $pid; ?>" name="form-signup_v1" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?php echo $pid; ?>">
                        <h5 class="with-border m-t-lg" style="color:  #0095dd">Edit Description :: <span style="color: #ff0000;"><?php echo $userRowSubCatID; ?></span></h5>

                        <?php if ($savemsg == '1') { ?>
                            <div class="alert alert-success alert-fill alert-close alert-dismissible fade in __web-inspector-hide-shortcut__" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                                VOD Description has been Updated successfully !
                            </div>
                        <?php } ?>


                        <div class="row">




                            <div class="col-md-4">
                                <fieldset class="form-group">
                                    <textarea required id='long_desc' name='long_desc'> <?php echo $userRowEdit['Description'] ?></textarea>
                                </fieldset>
                            </div>

                        </div>



                        <button type="submit" name="submit" value="Submit" class="btn" style="color: #fff !important;">Update Description </button>
                        <!--.row-->
                    </form>
                </div>
        </div>
        </section>
    </div>
    <!--.container-fluid-->
    </div>
    <!--.page-content-->
    <script type="text/javascript">
        // Initialize CKEditor
        CKEDITOR.inline('short_desc');

        CKEDITOR.replace('long_desc', {

            width: "980px",
            height: "300px"

        });
    </script>
    <script src="js/lib/jquery/jquery.min.js"></script>
    <script src="js/lib/tether/tether.min.js"></script>
    <script src="js/lib/bootstrap/bootstrap.min.js"></script>
    <script src="js/plugins.js"></script>

    <script src="js/lib/jquery-tag-editor/jquery.caret.min.js"></script>
    <script src="js/lib/jquery-tag-editor/jquery.tag-editor.min.js"></script>
    <script src="js/lib/bootstrap-select/bootstrap-select.min.js"></script>
    <script src="js/lib/select2/select2.full.min.js"></script>


    <script src="js/app.js"></script>

</body>

</html>