<?php
    include '../components/Navigation__Bar.php';
    
        // if(!isset($_SESSION['IS_LOGGIN'])){
        //     echo "<script>window.location='Login.php?type=n'</script>";
        // }
    
?>


    <?php include '../components/User_Name.php'; ?>
    


<div class="container">
    <div class="row">
        <div class="col-md-6">
            <h2>About Smart Bank</h2>
            <p>Welcome to Smart Bank, a modern online banking management system designed to make your financial life easier. At Smart Bank, we strive to provide secure and convenient banking solutions tailored to your needs.</p>
            <p>Our platform offers a wide range of services, including online account management, fund transfers, bill payments, and much more. With a focus on user experience and security, we aim to be your trusted financial partner.</p>
        </div>
        <div class="col-md-6">
            <img src="../assets/images/home_bg.jpg" class="img-fluid" alt="Smart Bank Image">
        </div>
    </div>
</div>
<?php
    include '../components/Footer.php';
?>