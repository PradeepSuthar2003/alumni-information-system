<?php
    include 'connection.php';

    if(isset($_POST['sign_btn'])){
        $name = $_POST['txt_username'];
        $email = $_POST['txt_email'];
        $pass = sha1($_POST['txt_password']);
        $msg = "";
        $user_exists = "";
        
        if(!(empty($name) || empty($email) || empty($pass))){

            $sql_check = "select email from users where email = '{$email}'";
            $result_check = mysqli_query($conn,$sql_check);
            if(mysqli_num_rows($result_check) > 0){
                $user_exists = '<div class="alert alert-danger d-flex align-items-center" role="alert">
                    <div>
                        Email Already Exists
                    </div>
                </div>';
            }else{
                $sql = "insert into users (email,username,password,role) values('{$email}','{$name}','{$pass}',0)";
                $result = mysqli_query($conn,$sql);
        
                if($result){
                    $user_exists = '<div class="alert alert-success d-flex align-items-center" role="alert">
                    <div>
                        Signup Successfully
                    </div>
                </div>';
                }
            }
        }else{
            $msg = "All Field Required";
        }
    }

    if(isset($_POST['log_btn'])){
        $email = $_POST['txt_email'];
        $pass = sha1($_POST['txt_password']);
        $msg2 = "";
        if(!(empty($email) || empty($pass))){
            $sql2 = "select * from users where email = '{$email}' and password = '{$pass}'";
            $result2 = mysqli_query($conn,$sql2);
        
            if(mysqli_num_rows($result2) > 0){
                $row = mysqli_fetch_assoc($result2);
                if(($row['role']) == 1){
                    $_SESSION['admin_name'] = $row['username'];
                    header("location: ./admin/index.php");
                }else{
                    $_SESSION['user_id'] = $row['u_id'];
                    $_SESSION['username'] = $row['username'];
                }
            }else{
                $msg2 = "Invaild Email or Password";
            }
        }else{
            $msg2 = "All Field Required";
        }
}

    if(isset($_POST['register_btn']) && isset($_FILES['image'])){

        $sql5 = "select * from alumni where u_id = {$_SESSION['user_id']}";
        $result5 = mysqli_query($conn,$sql5);
        $msg = "";
        $alert = "";
        $msg3 = "";
        if(mysqli_num_rows($result5) > 0){
           $alert = '<div class="alert alert-success d-flex align-items-center" role="alert">
            <div>
              User Already Exists
            </div>
          </div>';
        }else{

            $name = $_POST['txt_name'];
            $email = $_POST['txt_email'];
            $mobile = $_POST['txt_mobile'];
            $cur_organization = $_POST['txt_cur_organization'];
            $pro_type = $_POST['pro_type'];
            $pro_domain = $_POST['pro_domain'];
            $total_exp = $_POST['total_exp'];
            $message = $_POST['txt_message'];
            $pass_year = $_POST['txt_passyear'];
            $course = $_POST['txt_course'];
            
            $sql_cy = "select * from courses";
            $result_cy = mysqli_query($conn,$sql_cy);

            if(mysqli_num_rows($result_cy) > 0){
                while($row_cy = mysqli_fetch_assoc($result_cy)){
                    if(($row_cy['c_id']) == ($course)){
                        $inp_year = $_POST['txt_passyear'];
                        $inp_course = $row_cy['c_name'];
                        $start_year = $row_cy['year_started'];
                        $duration = $row_cy['course_duration'];
                    }
                }
                
                $end_year = $start_year + $duration;
                $cur_year = date('Y');
    
            if($end_year <= $inp_year && $inp_year <= $cur_year){
                if(!(empty($name) || empty($email) || empty($mobile) || empty($cur_organization) 
                || empty($pro_type) || empty($pro_domain) || empty($total_exp) || empty($message) || 
                empty($pass_year) || empty($course))){
                    $tmp_name = $_FILES['image']['tmp_name'];
                    $filename = $_FILES['image']['name'];
                    move_uploaded_file($tmp_name,"./admin/uploads/".$filename);
            
    
    
                    $sql4 = "insert into alumni (u_id,name,email,mobile_number,
                    current_organization,profession_type,profession_domain,
                    total_exp,message,photograph,course,passout_year,is_approved) values(
                        {$_SESSION['user_id']},'{$name}','{$email}','{$mobile}','{$cur_organization}',{$pro_type},
                        {$pro_domain},{$total_exp},'{$message}',
                        '{$filename}',{$course},'{$pass_year}',0          
                    )";
    
                    $result4 = mysqli_query($conn,$sql4);
            
                    if($result4){
                        $alert = "";
                    }
                }else{
                $msg3 = "All Field Required";
                }
            }else{
                $alert= '<div class="alert alert-success d-flex align-items-center" role="alert">
                <div>
                    Enter vaild passyear
                </div>
                </div>';
            }
        }
    }
}else{
        $msg3 = "Select Image"; 
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Document</title>
    <style>
    .user_profile {
        background-color: transparent;
        border: none;
        color: white;
    }
    </style>
</head>

<body>


    <!--Register form-->
    <?php if(isset($_SESSION['user_id'])){ ?>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
        <div class="modal fade" id="registerModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Alumni Register</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label">Name :</label>
                            <input type="text" class="form-control" id="recipient-name" placeholder="Enter name"
                                name="txt_name"
                                value="<?php if(isset($_POST['register_btn'])) echo $_POST['txt_name']; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label">Email :</label>
                            <input type="email" class="form-control" id="recipient-name" placeholder="Enter email"
                                name="txt_email"
                                value="<?php if(isset($_POST['register_btn'])) echo $_POST['txt_email']; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label">Mobile :</label>
                            <input type="number" class="form-control" id="recipient-name" placeholder="Enter mobile"
                                name="txt_mobile"
                                value="<?php if(isset($_POST['register_btn'])) echo $_POST['txt_mobile']; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label">Current Organization :</label>
                            <input type="text" class="form-control" id="recipient-name"
                                placeholder="Current Organization " name="txt_cur_organization"
                                value="<?php if(isset($_POST['register_btn'])) echo $_POST['txt_cur_organization']; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label">Professional Type :</label>
                            <select name="pro_type">
                                <?php
                            
                                $sql6 = "select * from profession_type";
                                $result6 = mysqli_query($conn,$sql6);

                                if(mysqli_num_rows($result6) > 0){
                                    while($row6 = mysqli_fetch_assoc($result6)){
                            ?>
                                <option value="<?php echo $row6['pt_id']; ?>"><?php echo $row6['pro_type']; ?></option>
                                <?php
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label">Professional Domain :</label>
                            <select name="pro_domain">
                                <?php
                            
                                $sql7 = "select * from profession_domain";
                                $result7 = mysqli_query($conn,$sql7);

                                if(mysqli_num_rows($result7) > 0){
                                    while($row7 = mysqli_fetch_assoc($result7)){
                            ?>
                                <option value="<?php echo $row7['pd_id']; ?>"><?php echo $row7['pro_domain']; ?>
                                </option>
                                <?php
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label">Total Exp :</label>
                            <input type="number" class="form-control" id="recipient-name" placeholder="Enter Exp"
                                name="total_exp"
                                value="<?php if(isset($_POST['register_btn'])) echo $_POST['total_exp']; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label">Some Message
                                :</label>
                            <textarea name="txt_message" cols="60" rows="5" style="resize:none;">
                            <?php if(isset($_POST['register_btn'])) echo $_POST['txt_message']; ?>
                        </textarea>
                        </div>
                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label">Photograph :</label>
                            <input type="file" name="image" />
                        </div>
                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label">Course :</label>
                            <select name="txt_course">
                                <?php 
                                    $sql3 = "select * from courses";
                                    $result3 = mysqli_query($conn,$sql3);

                                    if(mysqli_num_rows($result3) > 0){
                                        while($row1 = mysqli_fetch_assoc($result3)){
                                            echo "<option value='{$row1['c_id']}'>{$row1['c_name']}</option>";
                                        }
                                    }
                            ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label">Pass Out Year :</label>
                            <input type="text" class="form-control" id="recipient-name" placeholder="Enter passing Year"
                                name="txt_passyear"
                                value="<?php if(isset($_POST['register_btn'])) echo $_POST['txt_passyear']; ?>">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <h6><?php if(isset($_POST['register_btn'])) echo $msg3; ?></h6>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" name="register_btn">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <?php } ?>

    <!--Signup Model-->
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <div class="modal fade" id="signupModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Alumni Signup</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label">Username :</label>
                            <input type="text" class="form-control" id="recipient-name" placeholder="Enter username"
                                name="txt_username"
                                value="<?php if(isset($_POST['sign_btn'])) echo $_POST['txt_username']; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label">Email :</label>
                            <input type="email" class="form-control" id="recipient-name" placeholder="Enter email"
                                name="txt_email"
                                value="<?php if(isset($_POST['sign_btn'])) echo $_POST['txt_email']; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label">Password :</label>
                            <input type="password" class="form-control" id="recipient-email"
                                placeholder="Enter password" name="txt_password"
                                value="<?php if(isset($_POST['sign_btn'])) echo $_POST['txt_password']; ?>">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <h6><?php if(isset($_POST['sign_btn'])) echo $msg; ?></h6>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" data-bs-toggle="modal"
                            data-bs-target="#exampleModal" data-bs-dismiss="modal">Login</button>
                        <button type="submit" class="btn btn-primary" name="sign_btn">Signup</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!--Login Model-->

    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Alumni Login</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label">Email :</label>
                            <input type="email" class="form-control" id="recipient-name" placeholder="Enter email"
                                name="txt_email"
                                value="<?php if(isset($_POST['log_btn'])) echo $_POST['txt_email']; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label">Password :</label>
                            <input type="password" class="form-control" id="recipient-email"
                                placeholder="Enter password" name="txt_password"
                                value="<?php if(isset($_POST['log_btn'])) echo $_POST['txt_password']; ?>">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <h6><?php if(isset($_POST['log_btn'])) echo $msg2; ?></h6>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#signupModel" data-bs-dismiss="modal">Signup</button>
                        <button type="submit" class="btn btn-primary" name="log_btn">Login</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!--Navbar-->

    <header class="p-3 bg-dark text-white">
        <div class="container">
            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
                    <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap">
                        <use xlink:href="#bootstrap"></use>
                    </svg>
                </a>

                <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                    <li><a href="./index.php" class="nav-link px-2 text-secondary">Home</a></li>
                    <li><a href="./about.php" class="nav-link px-2 text-white">About</a></li>
                </ul>

                <div class="text-end">
                    <?php if(isset($_SESSION['user_id'])) {
                        echo '<button type="button" class="btn btn-warning" data-bs-toggle="modal"
                        data-bs-target="#registerModel">Register Alumni</button>';
                    }else{
                        echo '<button type="button" class="btn btn-warning" data-bs-toggle="modal"
                        data-bs-target="#loginModal">Register Alumni</button>';
                    }
                    ?>

                    <?php 
                    if(isset($_SESSION['user_id'])){
                    ?>
                    <a href="delete.php"><button type="button" class="btn btn-outline-light me-2">Logout</button></a>
                    <a href="profile.php">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"
                            class="bi bi-person-circle" viewBox="0 0 16 16">
                            <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                            <path fill-rule="evenodd"
                                d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z" />
                        </svg>
                    </a>
                    <button type="button" class="user_profile">
                        <h6>Hello, <?php echo $_SESSION['username']; ?></h6>
                    </button>
                    <?php } ?>
                </div>
            </div>
        </div>
    </header>

    <?php if(isset($_POST['register_btn'])) echo $alert;?>
    <?php if(isset($_POST['sign_btn'])) echo $user_exists;?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>

</html>