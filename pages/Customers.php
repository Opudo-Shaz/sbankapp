<?php
   include '../components/Navigation__Bar.php';

   // Check session variable for login
   if (!isset($_SESSION['IS_LOGGIN'])) {
       echo "<script>window.location='Login.php?type=n'</script>";
   }

   $msg = '';

   // Display success message if set
   if (isset($_GET["msg"])) {
       $msg_get = mysqli_real_escape_string($con, $_GET["msg"]);
       if ($msg_get == "msg") {
           $msg = "<div class='alert alert-success alert-dismissible fade show' role='alert'>
               <h4 class='alert-heading'>Well done!</h4>
               <strong>Customer Details Edited Successfully</strong>
               <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
           </div>";
       }
   }

   // Delete functionality
   if (isset($_GET['id']) && $_GET['id'] != "" && isset($_GET['option']) && $_GET['option'] != "") {
       $id = mysqli_real_escape_string($con, $_GET['id']);
       $option = mysqli_real_escape_string($con, $_GET['option']);

       if ($option == 'delete') {
           $customer_id = mysqli_real_escape_string($con, $_POST['delete']);
           $response = [];

           $query = "SELECT * FROM customer WHERE id = '$customer_id'";
           $result = mysqli_query($con, $query);

           if (mysqli_num_rows($result) > 0) {
               $query = "DELETE FROM customer WHERE id='$customer_id'";
               $query_run = mysqli_query($con, $query);

               if ($query_run) {
                   $response['status'] = 'OK';
                   $response['desc'] = 'Customer deleted Successfully';
                   echo "<script>window.location='Customers.php?type=n'</script>";
               }
           } else {
               $response['status'] = 'ERR';
               $response['desc'] = 'User not found';
               echo "<script>window.location='Customers.php?type=n'</script>";
           }
       }
       
       echo json_encode($response);
   }

   // Get all customer records
   $sql = mysqli_query($con, "SELECT * FROM customer ORDER BY id DESC");
?>
    <!-- Display Customer Table -->
        <?php include '../components/User_Name.php' ?>
        <?php echo $msg;?>
        <div class="container" id="display_record">
            <div class="row text-center">
                <h2>All Customers</h2>
                <p>All Customers Details Here</p>
            </div>
            <div class="table-responsive mt-2">
                <table class="table table-striped table-hover table-bordered">
                    <thead>
                        <tr>
                            <th width="15%" scope="col">Account Number</th>
                            <th width="15%" scope="col">ID Number</th>
                            <th width="10%" scope="col">Account Balance</th>
                            <th width="20%" scope="col">Name</th>
                            <th width="10%" scope="col">Gender</th>
                            <th width="10%" scope="col">Created</th>
                            <th width="10%" scope="col">Transaction</th>
                            <th width="10%" scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            while ($row = mysqli_fetch_assoc($sql)){
                        ?>
                            <tr>
                                <th scope="row" class="text-primary"><?php echo $row['account_no']; ?></th>
                                <th scope="row" class="text-success"><?php echo  $row['id_number']; ?></th>
                                <td><?php echo $row['acount_balance']?> &#8377;</td>
                                <td><?php echo $row['name']?></td>
                                <td><?php echo $row['gender']?></td>
                                <td><?php 
                                        $dateStr=strtotime($row['created_date']);
                                        echo date('d-m-Y',$dateStr);
                                    ?></td>
                                <td>
                                    <a href="All__Transction__History.php?type=n&id=<?php echo $row['account_no']; ?>"><button class="btn btn-primary">Transactions</button></a>
                                </td>
                                <td class="d-flex justify-content-around">
                                    <a href="pages/New__Customer.php?type=n&id=<?php echo $row['account_no']?>&option=view"><i class="far fa-eye text-primary"></i></a>
                                    <a href="pages/New__Customer.php?type=n&id=<?php echo $row['account_no']?>&option=edit"><i class="fas fa-pen text-success"></i></a>
                                    <a href="?type=n&id=<?php echo $row['account_no']?>&option=delete"><i class="fas fa-trash text-danger"></i></a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    <!--X- Display Customer Table -X-->
<?php
    
    include '../components/Footer.php';
    
?>