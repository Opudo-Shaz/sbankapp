<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
?>
<?php
    include '../components/Navigation__Bar.php';
    // ===========Condition==============
    if(!isset($_SESSION['IS_LOGGIN'])){
        echo "<script>window.location='Login.php?type=n'</script>";
    }
    
    // ========X===Condition===x=========

    //=========== Variable Declreation ==========
        $name = "";
        $gender = "";
        $birthday = "";
        $email = "";
        $phone_no = "";
        $state = "";
        $district = "";
        $city = "";
        $pin_code = "";
        $designation = "";
        $salary = "";

        $checked_id = "";
        $employee_id	 = "";

        $msg = "";
        $msg_get ="";

        $option = "";
        $id = "";

        $disabled = "";
    //======X=== Variable Declreation ===X========

    //============For Other Functionality=========
        if(isset($_GET['id']) && $_GET['id'] != "" && isset($_GET['option']) && $_GET['option']!=""){
            $id = mysqli_escape_string($con,$_GET['id']);
            $option = mysqli_escape_string($con,$_GET['option']);
        }

        //==========View Profile Functionality===============
            if($option == 'view'){
                $disabled = "disabled";
            }else{
                $disabled = "";
            }

            if($option == 'view' || $option == 'edit'){
                $res = mysqli_fetch_assoc(mysqli_query($con,"SELECT * FROM employee WHERE id = '$id'"));

               if ($res !== null) {
                //$res = mysqli_fetch_assoc(mysqli_query($con,"SELECT * FROM employee WHERE employe_id = '$employee_id'"));

                $employee_id	 = $res["employe_id"];
                $name = $res["name"];
                $gender = $res["gender"];
                $birthday = $res["birthday"];
                $email = $res["email_id"];
                $phone_no = $res["phone_no"];
                $state = $res["state"];
                $district = $res["district"];
                $city = $res["city"];
                $pin_code = $res["pin_code"];
                $designation = $res["designation"];
                $salary = $res["salary"];
            }else{
                // ==========Genrate Id Number===========
                    $sql_id = mysqli_query($con,"SELECT id FROM employee ORDER BY id DESC LIMIT 1");
                    $checked_id = mysqli_fetch_assoc($sql_id);

                    if(mysqli_num_rows($sql_id)>0){
                        $prives_id = $checked_id['id'];
                        $get_id = str_replace("EM", "", $prives_id);
                        $id_incrase = $get_id+1;
                        $get_id_string = str_pad($id_incrase, 5,0, STR_PAD_LEFT);

                        $employee_id = "EM".$get_id_string;
                    }else{
                        $employee_id = "EM00001";
                    }
                // ======X===Genrate Id Number===X=======
              }  }
        //========X==View Profile Functionality==X=============
    //=========X===For Other Functionality===X======

    // ============Get Massege Here===========
        if(isset($_GET["msg"]) && $_GET["msg"] != ""){
            $msg_get = mysqli_escape_string($con,$_GET["msg"]);
            if($msg_get == "msg"){
                $msg = "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                    <h4 class='alert-heading'>Well done!</h4>
                    <strong>Employee Detailes Added Successfully</strong>
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";
            }
        }
    // =========X===Get Massege Here===X=======

    // ========= Send Records Functionality ========
        if(isset($_POST['add_employee'])){
            //$employee_id = mysqli_escape_string($con,$_POST['employe_id']);
            $name = mysqli_escape_string($con,$_POST['name']);
            $gender = mysqli_escape_string($con,$_POST['gender']);
            $birthday = mysqli_escape_string($con,$_POST['birthday']);
            $email = mysqli_escape_string($con,$_POST['email']);
            $phone_no = mysqli_escape_string($con,$_POST['number']);
            $state = mysqli_escape_string($con,$_POST['state']);
            $district = mysqli_escape_string($con,$_POST['district']);
            $city = mysqli_escape_string($con,$_POST['city']);
            $pin_code =mysqli_escape_string($con,$_POST['pin_code']);
            $employee_id = $employee_id;
            $designation = mysqli_escape_string($con,$_POST['designation']);
            $salary = mysqli_escape_string($con,$_POST['salary']);

            if($option == ''){
                mysqli_query($con,"INSERT  INTO employee (employe_id,name,gender,email_id,birthday,phone_no,state,district,city,pin_code,designation,salary) VALUES ('$employee_id','$name','$gender','$email','$birthday','$phone_no','$state','$district','$city','$pin_code','$designation','$salary')");

                mysqli_query($con,"INSERT INTO users (usename,password,type) VALUES ('$employee_id','$phone_no',1)");
    
                echo "<script>window.location='New__Employee.php?type=n&msg=msg'</script>";
            }else{
                mysqli_query($con,"UPDATE employee SET employe_id='$employee_id',name='$name',gender='$gender',email_id='$email',birthday='$birthday',phone_no='$phone_no',state='$state',district='$district',city='$city',pin_code='$pin_code',designation='$designation',salary='$salary' WHERE id = $id");

                mysqli_query($con,"UPDATE users SET usename='$employee_id',password='$phone_no',type='1' WHERE username = '$employee_id'");

                echo "<script>window.location='Employees_Detailes.php?type=n&msg=msg'</script>";
            }
        }
    // ======X=== Send Records Functionality ===X===
?>
    <!-- ------------Employee Form---------------- -->
        <?php include '../components/User_Name.php' ?>
        <?php echo $msg;?>
        <div class="container" id="add_page">
            <div class="row text-center">
                <?php 
                    if($option == 'view'){
                        echo "
                            <h2>View Employee Detailes</h2>
                            <p><span class='text-primary'>$name</span> Detailes Here...</p>
                        ";
                    }else if ($option == 'edit'){
                        echo "
                            <h2>Edit Employee Details</h2>
                            <p><span class='text-primary'>$name</span> Edit Detailes Here...</p>
                        ";
                    }else{
                        echo "
                            <h2>Add Employee</h2>
                            <p>Add Employee Details Here</p>
                        ";
                    }
                ?>
            </div>
            <form method="post" action="" class="row g-3 mt-2 mb-2">
                <div class="col-md-4">
                    <label for="inputAddress" class="form-label">Employee Id</label>
                    <input type="text" class="form-control text-primary" id="inputAddress" name="employee_id" required>
                </div>
                <div class="col-md-4">
                    <label for="inputAddress" class="form-label">Designation</label>
                    <input <?php echo $disabled; ?> type="text" class="form-control" value="<?php echo $designation ?>" id="inputAddress" name="designation" required>
                </div>
                <div class="col-md-4">
                    <label for="inputAddress" class="form-label">Salary</label>
                    <input <?php echo $disabled; ?> type="text" value="<?php echo $salary ?>" class="form-control" id="inputAddress" name="salary" required>
                </div>
                <div class="col-md-6">
                    <label for="inputEmail4" class="form-label">Employee Name</label>
                    <input <?php echo $disabled; ?> type="text" value="<?php echo $name ?>" name="name" class="form-control" id="inputEmail4" required>
                </div>
                <div class="col-md-6">
                    <label for="inputPassword4" class="form-label">Email Id</label>
                    <input <?php echo $disabled; ?> type="email" value="<?php echo $email ?>" class="form-control" name="email" id="inputPassword4" required>
                </div>
                <div class="col-md-4">
                    <label for="inputEmail4" class="form-label">Gender</label>
                    <select <?php echo $disabled; ?> name="gender" id="inputState" class="form-select" required>
                            <?php 
                                if($option == 'view'){
                                    echo "<option value= '$gender' selected>$gender</option>";
                                }else if($option == 'edit'){
                                    echo "
                                    <option value= '$gender' selected>$gender</option>
                                    <option value='Male'>Male</option>
                                    <option value='Female'>Female</option>";
                                }else{
                                    echo "
                                        <option value= '' selected>Select Gender</option>
                                        <option value='Male'>Male</option>
                                        <option value='Female'>Female</option>
                                    ";
                                }   
                            ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="inputEmail4" class="form-label">Phone Number</label>
                    <input <?php echo $disabled; ?> type="text" value="<?php echo $phone_no ?>" class="form-control" name="number" id="inputPassword4" required>
                </div>
                <div class="col-md-4">
                    <label for="inputEmail4" class="form-label">Birth Date</label>
                    <input <?php echo $disabled; ?>
                        <?php if($option == 'view' || $option == 'edit'){
                                echo 'type=text';
                            }else{
                                echo 'type=date';
                            } 
                        ?> value="<?php echo $birthday ?>"  class="form-control" name="birthday" id="inputPassword4" required>
                </div>
                <div class="col-md-6">
                    <label for="inputEmail4" class="form-label">State</label>
                    <input <?php echo $disabled; ?> type="text" value="<?php echo $state ?>" class="form-control" name="state" id="inputPassword4" required>
                </div>
                <div class="col-md-6">
                    <label for="inputPassword4" class="form-label">District</label>
                    <input <?php echo $disabled; ?> type="text" value="<?php echo $district ?>" class="form-control" name="district" id="inputPassword4" required>
                </div>
                <div class="col-md-6">
                    <label for="inputAddress" class="form-label">City</label>
                    <input <?php echo $disabled; ?> type="text" value="<?php echo $city ?>" class="form-control" id="inputAddress" name="city" required>
                </div>
                <div class="col-md-6">
                    <label for="inputAddress" class="form-label">Pin Code</label>
                    <input <?php echo $disabled; ?> type="text" value="<?php echo $pin_code ?>" class="form-control" id="inputAddress" name="pin_code" required>
                </div>
                <?php if($option == 'view'){ ?>

                <?php }else{ ?>
                    <div class="col-12 text-center">
                        <button type="submit" name="add_employee" class="btn btn-primary">
                            <?php
                                if($option == 'edit'){
                                    echo 'Edit Employee Detailes';
                                }else{
                                    echo 'Add Employee';
                                }
                            ?>
                        </button>
                    </div>
                <?php } ?>
            </form>
        </div>
    <!-- ---------X---Employee Form---X------------- -->
<?php
    include '../components/Footer.php';
?>