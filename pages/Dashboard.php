<?php
    include '../components/Navigation__Bar.php';
    // ===========Condition==============
        if(!isset($_SESSION['IS_LOGGIN'])){
            header('Location:Login.php?type=n');
        }
        if($_SESSION['ROLE'] != 0){
            header('Location:Customers.php?type=n');
        }
    // ========X===Condition===x=========

    // ===========All Dashboard==========
    $sql = mysqli_query($con,"SELECT * FROM customer");
    $total_customers = mysqli_num_rows($sql);

    $sql_em = mysqli_query($con,"SELECT * FROM employee");
    $total_employees = mysqli_num_rows($sql_em);
    if($total_employees < 10){
        $total_employees = '0'.$total_employees;
    }

    $balance = mysqli_query($con,"SELECT SUM(acount_balance) AS value_sum FROM customer");
    $total = mysqli_fetch_assoc($balance);

    /*New queries for total deposits, withdrawals, and transfers
    
    $deposits_query = mysqli_query($con, "SELECT SUM(amount) AS total_deposits FROM deposits");
    $total_deposits = mysqli_fetch_assoc($deposits_query)['total_deposits'];

    $withdrawals_query = mysqli_query($con, "SELECT SUM(amount) AS total_withdrawals FROM withdrawals");
    $total_withdrawals = mysqli_fetch_assoc($withdrawals_query)['total_withdrawals'];

    $transfers_query = mysqli_query($con, "SELECT SUM(amount) AS total_transfers FROM transfers");
    $total_transfers = mysqli_fetch_assoc($transfers_query)['total_transfers'];
    // =========X==All Dashboard==X========*/

    ?>
    <!-- -----------Dashboard------------ -->
    <?php include '../components/User_Name.php' ?>
    <div class="container mt-5">
        <div class="row">
            <div class="col-xl-4">
                <div class="card text-dark bg-light mb-3" style="max-width: 18rem;">
                    <div class="card-body text-center">
                        <h4 class="card-title text-uppercase text-primary">Total Customers</h4>
                        <h1 class="card-text text-success"><?php echo $total_customers; ?></h1>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="card text-dark bg-light mb-3" style="max-width: 18rem;">
                    <div class="card-body text-center">
                        <h4 class="card-title text-uppercase text-primary">Total Employees</h4>
                        <h1 class="card-text text-success"><?php echo $total_employees; ?></h1>
                    </div>
                </div>
            </div>

            <div class="col-xl-4">
                <div class="card text-dark bg-light mb-3" style="max-width: 18rem;">
                    <div class="card-body text-center">
                        <h4 class="card-title text-uppercase text-primary">Total Bank Balance</h4>
                        <h1 class="card-text text-success"><?php echo  $total['value_sum'];  ?> &#8377;</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- -----------Dashboard------------ -->

<?php
    include '../components/Footer.php';
?>