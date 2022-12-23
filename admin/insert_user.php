<?php
    session_start();

    if(!isset($_SESSION['admin_name'])){
        header("location: ../index.php");
    }else{
        include './base.php';
        include '../connection.php';
    ?>

<?php
    
        if(isset($_POST['ins_btn'])){
            $name = $_POST['txt_username'];
            $email = $_POST['txt_email'];
            $pass = sha1($_POST['txt_password']);
            $role = $_POST['role'];

            if(!(empty($name) && empty($email) && empty($pass) && empty($role))){
                $sql = "insert into users (email,username,password,role) values('{$email}','{$name}','{$pass}',{$role})";
                $result = mysqli_query($conn,$sql);

                if($result){
                    echo '<div class="alert alert-success" role="alert">
                    New User Created
                    </div>';
                }
            }else{
                echo '<div class="alert alert-success" role="alert">
                All Field Requried
                </div>';
            }
        }
    ?>
<!--Signup Model-->
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Alumni Signup</h5>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="recipient-name" class="col-form-label">Username :</label>
                    <input type="text" class="form-control" id="recipient-name" placeholder="Enter username"
                        name="txt_username">
                </div>
                <div class="mb-3">
                    <label for="recipient-name" class="col-form-label">Email :</label>
                    <input type="email" class="form-control" id="recipient-name" placeholder="Enter email"
                        name="txt_email">
                </div>
                <div class="mb-3">
                    <label for="recipient-name" class="col-form-label">Role :</label>
                    <select name="role">
                        <option selected value='0'>Normal</option>
                        <option value='1'>Admin</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="recipient-name" class="col-form-label">Password :</label>
                    <input type="password" class="form-control" id="recipient-email" placeholder="Enter password"
                        name="txt_password">
                </div>
            </div>
            <div class="modal-footer">
                <a href="./users.php"><button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">Close</button>
                </a>
                <button type="submit" class="btn btn-primary" name="ins_btn">Insert</button>
            </div>
        </div>
    </div>
</form>
<?php
    }
?>