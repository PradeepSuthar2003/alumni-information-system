<?php
    session_start();
    
    if(!isset($_SESSION['admin_name'])){
        header("location: ../index.php");
    }else{
        include '../connection.php';
        include './base.php';
    ?>

<div class="container my-5">
    <a href="insert_user.php"><button type="submit" class="btn btn-success btn-sm" name="insert_btn"
            style="font-size:8px;">Insert</button>
    </a>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Username</th>
                <th scope="col">Email</th>
                <th scope="col">Password</th>
                <th scope="col">Role</th>
                <th scope="col">Date</th>
                <th scope="col">Operation</th>
            </tr>
        </thead>
        <tbody>

            <?php
        
            $sql = "select * from users";
            $result = mysqli_query($conn,$sql);

            if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_assoc($result)){
                    ?>
            <tr>
                <td><?php echo $row['u_id']; ?></td>
                <td><?php echo $row['username']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['password']; ?></td>
                <td>
                    <?php
                        if($row['role'] == 1){
                            echo 'Admin';
                        }else{
                            echo 'Normal';
                        } 
                    ?>
                </td>
                <td><?php echo $row['date']; ?></td>
                <td>
                    <a href="delete_user.php?id=<?php echo $row['u_id']; ?>"><button type="submit"
                            class="btn btn-danger btn-sm" name="delete_btn" style="font-size:8px;">Delete</button>
                    </a>
                </td>
            </tr>
            <?php
                    }
                }
            ?>
        </tbody>
    </table>
</div>

<?php
    }
?>