<?php

    include '../connection.php';
    require './mpdf/vendor/autoload.php';
    
    $sql = "select * from alumni join courses on alumni.course = courses.c_id join profession_type on profession_type.pt_id = alumni.profession_type join profession_domain on profession_domain.pd_id = alumni.profession_domain";
    $result = mysqli_query($conn,$sql);

    $data = "<table border='1' cellspacing='0' cellpadding='10'>";
    $data .= "<tr><td colspan='14' align='center'>All Alumnis</td></tr>";
    $data .= "<tr style='overflow:hidden'>
                <th>Aid</th>
                <th>Uid</th>
                <th>Name</th>
                <th>Email</th>
                <th>Mobile</th>
                <th>Current Organization</th>
                <th>Profession Type</th>
                <th>Profession Domain</th>
                <th>Total Exp</th>
                <th>Course</th>
                <th>Passout Year</th>
                <th>Date</th>
              </tr>";
    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_assoc($result)){
            $data.="<tr>
                    <td>{$row['a_id']}</td>
                    <td>{$row['u_id']}</td>
                    <td>{$row['name']}</td>
                    <td>{$row['email']}</td>
                    <td>{$row['mobile_number']}</td>
                    <td>{$row['current_organization']}</td>
                    <td>{$row['pro_type']}</td>
                    <td>{$row['pro_domain']}</td>
                    <td>{$row['total_exp']}</td>
                    <td>{$row['c_name']}</td>
                    <td>{$row['passout_year']}</td>
                    <td>{$row['date']}</td>
                    </tr>";
        }
        $data .= "</table>";
    }else{
        $data = "Data not found";
    }

   $mpdf = new \Mpdf\Mpdf();
   $mpdf->WriteHTML($data);
   $file = time() . '.pdf';
   $mpdf->output($file,'D'); 
    
?>