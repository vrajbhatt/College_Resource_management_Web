<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="images/favicon.png">
    <title>Upload_department_timetable</title>
    <link rel="stylesheet" href="uploadnotice.css">
</head>
<?php
require "department.php";
include "navbar_faculty.php";
// session_start();
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $file_name = $_FILES['pdf']['name'];
    $tempname = $_FILES['pdf']['tmp_name'];
    $heading=$_POST['heading'];
    $folder = 'department_timetable_pdf/' . $file_name;

    $query = "INSERT INTO department_timetable  VALUES (NULL,'$file_name','{$_SESSION['branch_faculty']}','$heading')";


    $result = mysqli_query($connection, $query);

    if (move_uploaded_file($tempname, $folder)) {
        // echo "department timetable pdf uploaded successfully";
        header("location:upload_department_timetable.php");
    } else {
        echo "department timetable pdf not uploaded";
    }
} else {
    // echo "method is not post";
}



?>



<body>
    <div class="container">
    <h2 class="nheading">Department Timetable</h2>
    
    <form action="upload_department_timetable.php" method="post" enctype="multipart/form-data" class="choosedocument">
        <input type="file" name="pdf">
        <input type="text" name="heading" placeholder="Title Of Document " required>
        <input type="submit" value="Upload pdf">
    </form>
    <div class="tabled">
    <table>
            <thead>
                <tr>
                    <th class="udocument">Uploaded documents</th>
                    <th>Delete</th>
                </tr>
            </thead>
        <?php
        // session_start();
      $sql_pdf = "SELECT * FROM department_timetable WHERE branch='{$_SESSION['branch_faculty']}'";


        $result_pdf = mysqli_query($connection, $sql_pdf);

        while ($row = mysqli_fetch_assoc($result_pdf)) {
            ?>
             <tbody>
<tr>
    <td> <a href="department_timetable_pdf/<?php echo $row['file'] ?>" target="_blank"><?php echo $row['heading'] ?></a></td>
    <td>
    <form action="delete_department_timetable.php" method="post">
                <input type="hidden" name="pdf_id" value="<?php echo $row['id']; ?>">
                <input type="hidden" name="pdf_name" value="<?php echo $row['file']; ?>">
                <input type="submit" value="Delete" class="deletebtn">
            </form>

    </td>
</tr>

           
            
        <?php } ?>
        </tbody>
</table>
    </div>
    </div>
</body>

</html>
<?php  
if(!isset($_SESSION['login_success_faculty']))
{
header("location:login_faculty.php");
}

?>


   
  