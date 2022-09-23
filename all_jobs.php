<?php
    require_once('db/database.php');
    $db=new DB();
    $conn=$db->connect();
    session_start();
    date_default_timezone_set('Asia/Colombo');
    $currentYear=date('Y');
    
    $user_id='';
    $user_name='';
    $user_email='';
    $user_role='';


    if (isset($_SESSION['Logged']) && $_SESSION['Logged'] == true) 
    {

      $user_email = $_SESSION["email"];

      $getEmpQuery=$conn->query("SELECT user_id,name,email,role FROM users_login WHERE email='$user_email' ");
      while ($emp=$getEmpQuery->fetch_array()) {

        $user_id = $emp['0']; 
        $user_name = $emp['1']; 
        $user_email = $emp['2']; 
        $user_role = $emp['3']; 
        

      }
      
    }

    else
    {
        ?>

            <script type="text/javascript">
                window.location.href="login";
            </script>

        <?php
    }
?>
<!doctype html>
<html lang="en">
<head>
<?php include_once('controls/meta.php'); ?>
<!-- Plugins css -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.1.0/css/buttons.dataTables.min.css">
</head>

<body class="font-opensans">

<!-- Page Loader -->
<div class="page-loader-wrapper">
    <div class="loader">
    </div>
</div>

<!-- Start main html -->
<div id="main_content">

    <?php include_once('controls/side_nav.php'); ?>

    <!-- start main body part-->
    <div class="page">

        <!-- start body header -->
        <?php include_once('controls/top_nav.php'); ?>

        <div class="section-body">
            <div class="container-fluid">
                
                <div class="row clearfix">
                    <div class="col-lg-12">
                        <div class="card" style="background-color: #FFF;">
                            <div class="card-header">
                                <h3 class="card-title">All Jobs</h3>
                            </div>
                            <div class="card-body">
                                
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="row">
                                            <div class="col-sm-2">
                                                <div id="stone_damage_red" style="background-color: #008000; padding: 15px; margin-bottom: 5px; width: 2%; height: 10px;"></div>
                                            </div>
                                            <div class="col-sm-4">
                                                <span>Opened Jobs</span>
                                            </div>
                                            <div class="col-sm-6"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="row">
                                            <div class="col-sm-2">
                                                <div id="stone_damage_red" style="background-color: #FF0000; padding: 15px; margin-bottom: 5px; width: 2%; height: 10px;"></div>
                                            </div>
                                            <div class="col-sm-4">
                                                <span>Closed Jobs</span>
                                            </div>
                                            <div class="col-sm-6"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6"></div>
                                </div>
                                <br>
                                
                                <div class="table-responsive">
                                    <table class="table table-hover table-vcenter table-striped" cellspacing="0" id="pendingjobsTable">
                                        <thead>
                                            <tr>
                                                <th>Job Number</th>
                                                <!--<th></th>-->
                                                <th>License Number</th>
                                                <th>Customer Name</th>
                                                <th>Telephone Number</th>
                                                <th>Vehicle Model</th>
                                                <th>Mileage (Km)</th>
                                                <th>Job Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php

                                                $sql = "SELECT * FROM `tbl_job_details`";
                                                $rs=$conn->query($sql);
                                                while($row =$rs->fetch_array())
                                                {
                                                    $reg_date = date('d-m-Y', strtotime($row[2]));
                                                    $JobYear = date('Y', strtotime($row[2]));
                                                    $Stat = $row[12];
                                            
                                            ?>
                                            <?php if($Stat=='1'){ ?>
                                            <tr class="gradeA">
                                                <td><a href="job_card?j=<?php echo base64_encode($row[0]);?>" style="color: #008000; font-weight: 600;">BAE/JOB/<?php echo $JobYear; ?>/<?php echo (10000+$row[0]); ?></a></td>
                                                <!--<td>
                                                    <button type="button" onclick="location.href='job_card?j=<?php //echo base64_encode($row[0]); ?>'" class="btn btn-success waves-effect waves-light">Job Card</button>
                                                </td>-->
                                                <td><a href="job_card?j=<?php echo base64_encode($row[0]);?>" style="color: #008000; font-weight: 600;"><?php echo $row[8]; ?></a></td>
                                                <td><a href="job_card?j=<?php echo base64_encode($row[0]);?>" style="color: #008000; font-weight: 600;"><?php echo $row[3]; ?></a></td>
                                                <td><a href="job_card?j=<?php echo base64_encode($row[0]);?>" style="color: #008000; font-weight: 600;"><?php echo $row[4]; ?></a></td>
                                                <td><a href="job_card?j=<?php echo base64_encode($row[0]);?>" style="color: #008000; font-weight: 600;"><?php echo $row[6]; ?></a></td>
                                                <td><a href="job_card?j=<?php echo base64_encode($row[0]);?>" style="color: #008000; font-weight: 600;"><?php echo $row[9]; ?></a></td>
                                                <td><a href="job_card?j=<?php echo base64_encode($row[0]);?>" style="color: #008000; font-weight: 600;"><?php echo $reg_date; ?></a></td>
                                            </tr>
                                            <?php }elseif($Stat=='2'){ ?>
                                            <tr class="gradeA">
                                                <td><a href="finish_job_card?j=<?php echo base64_encode($row[0]); ?>" style="color: #FF0000; font-weight: 600;">BAE/JOB/<?php echo $JobYear; ?>/<?php echo (10000+$row[0]); ?></a></td>
                                                <!--<td>
                                                    <button type="button" onclick="location.href='finish_job_card?j=<?php echo base64_encode($row[0]); ?>'" class="btn btn-success waves-effect waves-light">Job Card</button>
                                                </td>-->
                                                <td><a href="finish_job_card?j=<?php echo base64_encode($row[0]); ?>" style="color: #FF0000; font-weight: 600;"><?php echo $row[8]; ?></a></td>
                                                <td><a href="finish_job_card?j=<?php echo base64_encode($row[0]); ?>" style="color: #FF0000; font-weight: 600;"><?php echo $row[3]; ?></a></td>
                                                <td><a href="finish_job_card?j=<?php echo base64_encode($row[0]); ?>" style="color: #FF0000; font-weight: 600;"><?php echo $row[4]; ?></a></td>
                                                <td><a href="finish_job_card?j=<?php echo base64_encode($row[0]); ?>" style="color: #FF0000; font-weight: 600;"><?php echo $row[6]; ?></a></td>
                                                <td><a href="finish_job_card?j=<?php echo base64_encode($row[0]); ?>" style="color: #FF0000; font-weight: 600;"><?php echo $row[9]; ?></a></td>
                                                <td><a href="finish_job_card?j=<?php echo base64_encode($row[0]); ?>" style="color: #FF0000; font-weight: 600;"><?php echo $reg_date; ?></a></td>
                                            </tr>
                                            <?php }else{} ?>
                                            
                                            <?php } ?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>                        
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Start page footer -->
        <?php include_once('controls/footer.php'); ?>
    </div>
</div>

<!-- jQuery and bootstrtap js -->
<script src="assets/assets/bundles/lib.vendor.bundle.js"></script>

<!-- start plugin js file  -->
<!-- <script src="assets/assets/bundles/dataTables.bundle.js"></script> -->

<!-- Start core js and page js -->
<script src="assets/assets/js/core.js"></script>
<!-- <script src="assets/js/table/datatable.js"></script> -->
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script src="assets/js/themechanger.js"></script>

<script src="https://cdn.datatables.net/buttons/2.1.0/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.1.0/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.1.0/js/buttons.print.min.js"></script>


<script>
    $(document).ready( function () {
        $('#pendingjobsTable').DataTable({
            "order": [[ 0, "desc" ]],
            dom: 'Bfrtip',
            buttons: [
                // 'copy', 'csv', 'excel', 'pdf', 'print'
                'print', 'excel', 'pdf'
            ]
        });
    } );
</script>



</body>
</html>