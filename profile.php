<?php
    session_start();
    
    if(!isset($_SESSION['user_id'])){
        header("location: ./index.php");
    }else{
        include './base.php';

        if(isset($_POST['edit_btn'])){
            $tmp_name = $_FILES['image']['tmp_name'];
            $filename = $_FILES['image']['name'];
                if(move_uploaded_file($tmp_name,"./admin/uploads/".$filename)){
                    $photograph = $filename;
                }else{
                    $photograph = $_POST['photograph'];
                }

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

                    $sql7 = "update alumni set name='{$name}',email = '{$email}',mobile_number = '{$mobile}',
                    current_organization = '{$cur_organization}',
                    profession_type = {$pro_type},profession_domain = {$pro_domain},total_exp = {$total_exp},
                    message = '{$message}',photograph='{$photograph}',passout_year = '{$pass_year}',
                    course = '{$course}',is_approved = 0 where u_id = {$_SESSION['user_id']}";

                    $result7 = mysqli_query($conn,$sql7);

                    if(!$result7){
                        echo "error";
                    }
                }else{
                    echo '<div class="alert alert-success d-flex align-items-center" role="alert">
                    <div>
                        All Field Required
                    </div>
                    </div>';
                    } 
                }else{
                    echo '<div class="alert alert-danger d-flex align-items-center" role="alert">
                    <div>
                        Enter vaild passyear
                    </div>
                    </div>';
                }
                
            }
        }
    }

    if(isset($_SESSION['user_id'])){
        $sql6 = "select * from alumni where is_approved = 1 and u_id = {$_SESSION['user_id']}";
        $result6 = mysqli_query($conn,$sql6);

        if(mysqli_num_rows($result6) > 0){
            $row6 = mysqli_fetch_assoc($result6);
    ?>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
    <div class="container my-5">
        <div class="col-lg-4">
            <img src="./admin/uploads/<?php echo $row6['photograph']; ?>"
                style="border-radius:50%; width:250px; height:250px;" />
            <div class="mb-3">
                <label for="recipient-name" class="col-form-label">Name :</label>
                <input type="text" class="form-control" id="recipient-name" placeholder="Enter name" name="txt_name"
                    value="<?php echo $row6['name']; ?>">
            </div>
            <div class="mb-3">
                <label for="recipient-name" class="col-form-label">Email :</label>
                <input type="email" class="form-control" id="recipient-name" placeholder="Enter email" name="txt_email"
                    value="<?php echo $row6['email']; ?>">
            </div>
            <div class="mb-3">
                <label for="recipient-name" class="col-form-label">Mobile :</label>
                <input type="number" class="form-control" id="recipient-name" placeholder="Enter mobile"
                    name="txt_mobile" value="<?php echo $row6['mobile_number']; ?>">
            </div>
            <div class="mb-3">
                <label for="recipient-name" class="col-form-label">Current Organization :</label>
                <input type="text" class="form-control" id="recipient-name" placeholder="Current Organization "
                    name="txt_cur_organization" value="<?php echo $row6['current_organization']; ?>">
            </div>
            <div class="mb-3">
                <label for="recipient-name" class="col-form-label">Professional Type :</label>
                <select name="pro_type">
                    <?php
                            
                                $sql_pt = "select * from profession_type";
                                $result_pt = mysqli_query($conn,$sql_pt);

                                if(mysqli_num_rows($result6) > 0){
                                    while($row_pt = mysqli_fetch_assoc($result_pt)){
                                        if($row6['profession_type'] == $row_pt['pt_id']){
                                            $active = "selected";
                                        }else{
                                            $active = "";
                                        }
                            ?>
                    <option <?php echo $active; ?> value="<?php echo $row_pt['pt_id']; ?>">
                        <?php echo $row_pt['pro_type']; ?></option>
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
                            
                                $sql_pd = "select * from profession_domain";
                                $result_pd = mysqli_query($conn,$sql_pd);

                                if(mysqli_num_rows($result7) > 0){
                                    while($row_pd = mysqli_fetch_assoc($result_pd)){
                                        if($row6['profession_domain'] == $row_pd['pd_id']){
                                            $active = "selected";
                                        }else{
                                            $active = "";
                                        }
                            ?>
                    <option <?php echo $active; ?> value="<?php echo $row_pd['pd_id']; ?>">
                        <?php echo $row_pd['pro_domain']; ?>
                    </option>
                    <?php
                                        }
                                    }
                                ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="recipient-name" class="col-form-label">Total Exp :</label>
                <input type="number" class="form-control" id="recipient-name" placeholder="Enter Exp" name="total_exp"
                    value="<?php echo $row6['total_exp']; ?>">
            </div>
            <div class="mb-3">
                <label for="recipient-name" class="col-form-label">Some Message
                    :</label>
                <textarea name="txt_message" cols="60" rows="5" style="resize:none;">
                <?php echo $row6['message']; ?>
                </textarea>
            </div>
            <div class="mb-3">
                <label for="recipient-name" class="col-form-label">Photograph :</label>
                <input type="file" name="image" />
                <input type="hidden" name="photograph" value="<?php echo $row6['photograph']; ?>" />
            </div>
            <div class="mb-3">
                <label for="recipient-name" class="col-form-label">Course :</label>
                <select name="txt_course">
                    <?php 
                                if(isset($_SESSION['user_id'])){
                                    $sql3 = "select * from courses";
                                    $result3 = mysqli_query($conn,$sql3);
                                    if(mysqli_num_rows($result3) > 0){
                                        while($row1 = mysqli_fetch_assoc($result3)){
                                            if($row6['course'] == $row1['c_id']){
                                                $active = "selected";
                                            }else{
                                                $active = "";
                                            }
                                            echo "<option $active value='{$row1['c_id']}'>{$row1['c_name']}</option>";
                                        }
                                    }
                                }
                            ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="recipient-name" class="col-form-label">Pass Out Year :</label>
                <input type="text" class="form-control" id="recipient-name" placeholder="Enter passing Year"
                    name="txt_passyear" value="<?php echo $row6['passout_year']; ?>">
            </div>
            <button type="submit" class="btn btn-primary" name="edit_btn">Edit</button>
        </div>
</form>
</div>
<?php
    }else{
        $sql9 = "select * from alumni where is_approved = 0 and u_id = {$_SESSION['user_id']}";
        $result9 = mysqli_query($conn,$sql9);

        if(mysqli_num_rows($result9) > 0){
            echo '<div class="alert alert-success d-flex align-items-center" role="alert">
            <svg class="bi flex-shrink-0 me-2" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
            <div>
                Your request has been send, Wait for response
            </div>
          </div>';
        }else{
            echo '<div class="alert alert-success d-flex align-items-center" role="alert">
            <svg class="bi flex-shrink-0 me-2" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
            <div>
                <h6>Name : '.$_SESSION['username'].'</h6>
                <h6>Password : ******** </h6>
                Click button to register - 
                <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                data-bs-target="#registerModel">Register Alumni</button>
            </div>
          </div>';
        }
    }
}
?>