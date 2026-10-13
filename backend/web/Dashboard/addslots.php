<?php
require_once("Login/session.php");

require_once("Login/class.user.php");


$auth_user = new USER();


$user_id = $_SESSION['user_session'];

$stmt = $auth_user->runQuery("SELECT * FROM admin_users WHERE user_id=:user_id");
$stmt->execute(array(":user_id" => $user_id));

$userRow = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>

<html>
    <head lang="en">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title> Ps Dashboard</title>

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

        <link rel="stylesheet" href="css/lib/font-awesome/font-awesome.min.css">
        <link rel="stylesheet" href="css/lib/bootstrap/bootstrap.min.css">
        <link rel="stylesheet" href="css/main.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.14/css/jquery.dataTables.min.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.3.1/css/buttons.dataTables.min.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/select/1.2.2/css/select.dataTables.min.css">
        <link rel="stylesheet" type="text/css" href="css/editor.dataTables.min.css">

        <style type="text/css" class="init">

        </style>
        <script type="text/javascript" language="javascript" src="//code.jquery.com/jquery-1.12.4.js">
        </script>
        <script src="js/lib/jquery/jquery.min.js"></script>
        <script src="js/lib/tether/tether.min.js"></script>
        <script src="js/lib/bootstrap/bootstrap.min.js"></script>
        <script src="js/plugins.js"></script>

        <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.14/js/jquery.dataTables.min.js">
        </script>
        <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js">
        </script>
        <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/select/1.2.2/js/dataTables.select.min.js">
        </script>
        <script type="text/javascript" language="javascript" src="js/dataTables.editor.min.js">
        </script>



        <script type="text/javascript" language="javascript" class="init">



        </script>

        <link rel="stylesheet" type="text/css" href="https://weareoutman.github.io/clockpicker/dist/bootstrap-clockpicker.min.css">
        <link rel="stylesheet" type="text/css" href="https://weareoutman.github.io/clockpicker/assets/css/github.min.css">

        <script type="text/javascript" src="https://weareoutman.github.io/clockpicker/assets/js/jquery.min.js"></script>
        <script type="text/javascript" src="https://weareoutman.github.io/clockpicker/assets/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="https://weareoutman.github.io/clockpicker/dist/bootstrap-clockpicker.min.js"></script>

    </head>
    <body class="with-side-menu control-panel control-panel-compact">

<?php include("inc/head.php"); ?>

        <div class="mobile-menu-left-overlay"></div>
        <?php include("inc/left.php"); ?>
    

        <div class="page-content">
            <div class="container">
              <header class="box-typical-header">
					<div class="tbl-row">
						<div class="tbl-cell tbl-cell-title">
							<h3>Advertisement Slot Management</h3>
						</div>
					</div>
				</header>

                <div class="form-group">
                    <form name="add_name" action="saveslot.php" method="POST" >
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dynamic_field" style="width:85% !important;" >


                                <tr>
                                    <td><label for="wcwidget">Advertisement:</label>












                                        <select class="form-control" name="ad_id">
                                            <option value="">----Select Advertisement----</option>
<?php
try {



    $stmt1 = $auth_user->runQuery("SELECT `ad_id`, `ad_name`,ad_duration, `ad_isactive`, `ad_createdon` FROM `ads` ");



    $stmt1->execute();

    //$userRow1=$stmt1->fetch(PDO::FETCH_ASSOC);


    if ($stmt1->rowCount() > 0) {
        $i = 1;
        while ($row = $stmt1->fetch()) {  //echo '1';
            //var_dump($row);
            $cur_id = $row[0];
            $cur_name = $row[1];
            $cur_dur = $row[2];
            ?>
                                                        <option  value="<?php echo $cur_id; ?>"><?php echo $cur_name; ?>- Duration: <?php echo $cur_dur; ?> sec</option>
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
                                    </td>
                                    <td></td>
                                </tr>



                                <tr>
                                    <td>
                                        <label for="wcauto">Slot Start Time 1:</label>
                                        <div class="input-group clockpicker" data-placement="right" data-align="top" data-autoclose="true">
                                            <input type="text" name="sl[]"  class="form-control" value="">
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-time"></span>
                                            </span>
                                        </div>
                                        <script type="text/javascript">
$('.clockpicker').clockpicker();
                                        </script></td>
                                    <td>
                                        <label for="wcauto">Slot Start Time 2:</label>
                                        <div class="input-group clockpicker" data-placement="right" data-align="top" data-autoclose="true">
                                            <input type="text"  name="sl[]"   class="form-control" value="">
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-time"></span>
                                            </span>
                                        </div>
                                        <script type="text/javascript">
$('.clockpicker').clockpicker();
                                        </script>
                                        
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <label for="wcauto">Slot Start Time 3:</label>
                                        <div class="input-group clockpicker" data-placement="right" data-align="top" data-autoclose="true">
                                            <input type="text"  name="sl[]"   class="form-control" value="">
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-time"></span>
                                            </span>
                                        </div>
                                        <script type="text/javascript">
                                            $('.clockpicker').clockpicker();
                                        </script></td>
                                   <td>
                                        <label for="wcauto">Slot Start Time 4:</label>
                                        <div class="input-group clockpicker" data-placement="right" data-align="top" data-autoclose="true">
                                            <input type="text"  name="sl[]"   class="form-control" value="">
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-time"></span>
                                            </span>
                                        </div>
                                        <script type="text/javascript">
                                            $('.clockpicker').clockpicker();
                                        </script></td>
                                </tr>

                        <tr>
                                    <td>
                                        <label for="wcauto">Slot Start Time 5:</label>
                                        <div class="input-group clockpicker" data-placement="right" data-align="top" data-autoclose="true">
                                            <input type="text"  name="sl[]"   class="form-control" value="">
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-time"></span>
                                            </span>
                                        </div>
                                        <script type="text/javascript">
                                            $('.clockpicker').clockpicker();
                                        </script></td>
                                   <td>
                                        <label for="wcauto">Slot Start Time 6:</label>
                                        <div class="input-group clockpicker" data-placement="right" data-align="top" data-autoclose="true">
                                            <input type="text"  name="sl[]"   class="form-control" value="">
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-time"></span>
                                            </span>
                                        </div>
                                        <script type="text/javascript">
                                            $('.clockpicker').clockpicker();
                                        </script></td>
                                </tr>

                              <tr>
                                    <td>
                                        <label for="wcauto">Slot Start Time 7:</label>
                                        <div class="input-group clockpicker" data-placement="right" data-align="top" data-autoclose="true">
                                            <input type="text"  name="sl[]"   class="form-control" value="">
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-time"></span>
                                            </span>
                                        </div>
                                        <script type="text/javascript">
                                            $('.clockpicker').clockpicker();
                                        </script></td>
                                   <td>
                                        <label for="wcauto">Slot Start Time 8:</label>
                                        <div class="input-group clockpicker" data-placement="right" data-align="top" data-autoclose="true">
                                            <input type="text"  name="sl[]"   class="form-control" value="">
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-time"></span>
                                            </span>
                                        </div>
                                        <script type="text/javascript">
                                            $('.clockpicker').clockpicker();
                                        </script></td>
                                </tr>
                                 <tr>
                                    <td>
                                        <label for="wcauto">Slot Start Time 9:</label>
                                        <div class="input-group clockpicker" data-placement="right" data-align="top" data-autoclose="true">
                                            <input type="text"  name="sl[]"   class="form-control" value="">
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-time"></span>
                                            </span>
                                        </div>
                                        <script type="text/javascript">
                                            $('.clockpicker').clockpicker();
                                        </script></td>
                                   <td>
                                        <label for="wcauto">Slot Start Time 10:</label>
                                        <div class="input-group clockpicker" data-placement="right" data-align="top" data-autoclose="true">
                                            <input type="text"  name="sl[]"   class="form-control" value="">
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-time"></span>
                                            </span>
                                        </div>
                                        <script type="text/javascript">
                                            $('.clockpicker').clockpicker();
                                        </script></td>
                                </tr>




                            </table>
                            <input type="submit" name="submit" id="submit" class="btn btn-info" style="background-color: #c00 !important;color:#fff !important" value="Submit" />
                        </div>
                    </form>
                </div>
            </div>	
        </div><!--.page-content-->






        <script src="js/app.js"></script>
    </body>
</html>