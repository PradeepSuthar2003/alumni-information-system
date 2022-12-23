<?php 
session_start();
include 'base.php'; 
?>
<!--Content-->

<div class="container marketing my-5">
    <h2 class="my-5">All Alumni</h2>

    <hr class="featurette-divider">

    <?php

    if(isset($_GET['page'])){
        $page = $_GET['page'];
    }else{
        $page = 1;
    }

    $limit = 3;
    $offset = ($page-1)*$limit;

    $sql8 = "select * from alumni join courses on alumni.course = courses.c_id 
    join profession_type on profession_type.pt_id = alumni.profession_type 
    join profession_domain on profession_domain.pd_id = alumni.profession_domain 
    where alumni.is_approved = 1 order by alumni.a_id desc limit $offset,$limit";
    $result8 = mysqli_query($conn,$sql8);
    $j=1;

    if(mysqli_num_rows($result8) > 0){
        while($row8 = mysqli_fetch_assoc($result8)){
            if(($j%2) == 0){
?>
    <div class="row featurette my-5">
        <div class="col-md-7">
            <h2 class="featurette-heading"><?php echo $row8['name']; ?> <span class="text-muted"></span></h2>
            <p><?php echo $row8['message']; ?></p>
            <p class="lead">Currently Organization : <?php echo $row8['current_organization']; ?></p>
            <p class="lead">Profession Type : <?php echo $row8['pro_type']; ?></p>
            <p class="lead">Profession Domain : <?php echo $row8['pro_domain']; ?></p>
            <p class="lead">Collage Passout Year : <?php echo $row8['passout_year']; ?></p>
        </div>
        <div class="col-md-5">
            <img src="./admin/uploads/<?php echo $row8['photograph']; ?>" alt="Image Unavailable"
                style="border-radius:10px;" width="200" heigth="180" />
        </div>
        <?php if(isset($_SESSION['user_id'])){
                    if($row8['u_id'] == $_SESSION['user_id']){
                        echo '
                        <a href="profile.php"><button type="submit" class="btn btn-primary my-5" 
                        name="register_btn">Edit</button></a>
                        ';
                    }
        }?>
    </div>

    <hr class="featurette-divider">
    <?php }else {?>



    <div class="row featurette">
        <div class="col-md-7 order-md-2">
            <h2 class="featurette-heading"><?php echo $row8['name']; ?> <span class="text-muted"></span></h2>
            <p><?php echo $row8['message']; ?></p>
            <p class="lead">Currently Organization : <?php echo $row8['current_organization']; ?></p>
            <p class="lead">Profession Type : <?php echo $row8['pro_type']; ?></p>
            <p class="lead">Profession Domain : <?php echo $row8['pro_domain']; ?></p>
            <p class="lead">Collage Passout Year : <?php echo $row8['passout_year']; ?></p>
        </div>
        <div class="col-md-5 order-md-1">
            <img src="./admin/uploads/<?php echo $row8['photograph']; ?>" alt="Image Unavailable"
                style="border-radius:10px;" width="200" heigth="180" />
        </div>
        <?php if(isset($_SESSION['user_id'])){
                    if($row8['u_id'] == $_SESSION['user_id']){
                        echo '
                        <a href="profile.php"><button type="submit" class="btn btn-primary my-5" 
                        name="register_btn">Edit</button></a>
                        ';
                    }
        }?>
    </div>

    <hr class="featurette-divider">
    <?php }
        $j++;
    ?>
    <?php
         }
        }
    ?>
    <!--Pagination-->
    <nav aria-label="Page navigation example">
        <ul class="pagination">
            <?php
                if($page > 1){
                    echo '<li class="page-item"><a class="page-link" href="index.php?page='.($page - 1).'">Previous</a></li>';
                }
            ?>
            <?php
                $sql10 = "select * from alumni where is_approved = 1";
                $result10 = mysqli_query($conn,$sql10); 
                $no_record = mysqli_num_rows($result10);
                $pages = ceil($no_record / 3);
                for($i=1;$i<=$pages;$i++){
                    if($page == $i){
                        $active = "active";
                    }else{
                        $active = "";
                    }
                    echo "<li class='page-item {$active}'><a class='page-link' href='index.php?page={$i}'>{$i}</a></li>";
                }
            ?>
            <?php
                if($page < $pages){
                    echo '<li class="page-item"><a class="page-link" href="index.php?page='.($page + 1).'">Next</a></li>';
                }
            ?>
        </ul>
    </nav>

</div>