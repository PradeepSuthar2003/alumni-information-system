<?php
    session_start();

    if(!isset($_SESSION['admin_name'])){
        header("location: ../index.php");
    }else{
        include './base.php';
        include '../connection.php';
    }
?>
<div class="container my-5">
    <table class="table">
        <thead>
            <a href="./print_pdf.php"><button type="button" class="btn btn-secondary"
                    style="font-size:8px;">Report</button></a>
            <tr>
                <th scope="col">Aid</th>
                <th scope="col">Uid</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Mobile</th>
                <th scope="col">Current_Organization</th>
                <th scope="col">Profession Type</th>
                <th scope="col">Profession Domain</th>
                <th scope="col">Total Exp</th>
                <th scope="col">Message</th>
                <th scope="col">Photograph</th>
                <th scope="col">Course</th>
                <th scope="col">Passout Year</th>
                <th scope="col">Status</th>
                <th scope="col">Date</th>
                <th scope="col" colspan="2">Operation</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $sql = "select * from alumni join courses on alumni.course = courses.c_id join profession_type on profession_type.pt_id = alumni.profession_type join profession_domain on profession_domain.pd_id = alumni.profession_domain";
                $result = mysqli_query($conn,$sql);

                if(mysqli_num_rows($result) > 0){
                    while($row = mysqli_fetch_assoc($result)){
            ?>
            <tr>
                <td><?php echo $row['a_id']; ?></td>
                <td><?php echo $row['u_id']; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['mobile_number']; ?></td>
                <td><?php echo $row['current_organization']; ?></td>
                <td><?php echo $row['pro_type']; ?></td>
                <td><?php echo $row['pro_domain']; ?></td>
                <td><?php echo $row['total_exp']; ?></td>
                <td><?php echo $row['message']; ?></td>
                <td><img src="./uploads/<?php echo $row['photograph']; ?>" width="60" heigth="60" /></td>
                <td><?php echo $row['c_name']; ?></td>
                <td><?php echo $row['passout_year']; ?></td>
                <td>
                    <?php 
                    if(($row['is_approved']) == 1)
                        echo 'Approved'; 
                    else
                        echo '<a href="chg_status.php?id='.$row['u_id'].'"><button type="submit" class="btn btn-success btn-sm" name="act_btn" style="font-size:8px;">Approve</button></a>';
                ?>
                </td>
                <td><?php echo $row['date']; ?></td>
                <td>
                    <a href="update.php?id=<?php echo $row['u_id']; ?>"><button type="button"
                            class="btn btn-success btn-sm" name="edit_btn" style="font-size:8px;">Update
                        </button></a>
                </td>
                <td>
                    <a href="delete.php?id=<?php echo $row['u_id']; ?>"><button type="submit"
                            class="btn btn-danger btn-sm" name="delete_btn" style="font-size:8px;">Delete</button></a>
                </td>
            </tr>
            <?php
                    }
                }
            ?>
        </tbody>
    </table>
</div>