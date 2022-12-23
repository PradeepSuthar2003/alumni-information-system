<?php
    session_start();

    if(!isset($_SESSION['admin_name'])){
        header("location: ../index.php");
    }else{
        include './base.php';
        include '../connection.php';
    ?>

<?php

        
    ?>

<!--Signup Model-->
<?php
        
        $id = $_GET['id'];

        $sql = "select * from users where u_id = {$id}";
        $result = mysqli_query($conn,$sql);

        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
                ?>
<form action="update_user.php?id=<?php echo $row['u_id'] ?>" method="POST">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Alumni Signup</h5>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="recipient-name" class="col-form-label">Username :</label>
                    <input type="text" class="form-control" id="recipient-name" placeholder="Enter username"
                        name="txt_username" value="<?php echo $row['username']; ?>">
                </div>
                <div class="mb-3">
                    <label for="recipient-name" class="col-form-label">Email :</label>
                    <input type="email" class="form-control" id="recipient-name" placeholder="Enter email"
                        name="txt_email" value="<?php echo $row['email']; ?>">
                </div>
                <div class="mb-3">
                    <label for="recipient-name" class="col-form-label">Password :</label>
                    <input type="password" class="form-control" id="recipient-email" placeholder="Enter password"
                        name="txt_password" value="<?php echo $row['password']; ?>">
                </div>
            </div>
            <div class="modal-footer">
                <a href="./users.php"><button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">Close</button>
                </a>
                <button type="submit" class="btn btn-primary" name="up_btn">Insert</button>
            </div>
        </div>
    </div>
</form>

<?php
            }
        }
?>
<?php
    }
?>