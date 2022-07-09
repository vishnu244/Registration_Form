<?php
session_start();

$host = "localhost";
$user = "root";
$username = "";
$password = "";
$mobilenumber = "";
$email = "";
$address = "";
$DataBase = "crud";

$id = 0;
$edit_state = false;

$con = mysqli_connect($host,$user,$password,$DataBase);

if (isset($_POST['save'])){
    $username = $_POST['UserName'];
    $password = $_POST['Password'];
    $email = $_POST['Email'];
    $mobilenumber = $_POST['MobileNumber'];
    $address = $_POST['Address'];

    $query = "insert into info (UserName,Password,Email,MobileNumber,Address) values ('$username','$password','$email','$mobilenumber','$address')";
    mysqli_query($con,$query);
    $_SESSION['message'] = "Data Saved";
    //header('location: index.php');
}

//delete records
if (isset($_GET['delete'])){
    $id = $_GET['delete'];

    $query = "delete from info where Id = $id";
    mysqli_query($con,$query);
    $_SESSION['message'] = "Data Deleted";
}

//updating records
if(isset($_POST['update'])){
    $username = ($_POST['UserName']);
    $password = ($_POST['Password']);
    $email = ($_POST['Email']);
    $mobilenumber = ($_POST['MobileNumber']);
    $address = ($_POST['Address']);
    $id = ($_POST['Id']);

    $query = "update info set UserName = '$username', Password = '$password', email = '$email', MobileNumber = '$mobilenumber', Address = '$address' where Id = $id" ;
    mysqli_query($con,$query);
    $_SESSION['message'] = "Data Updataed";
    //header('location: index.php');
}

//retrive records
$result = mysqli_query($con,"select * from info");
?>

<?php 
//fetch the records to be updated

if (isset($_GET['edit'])){
    $id = $_GET['edit'];
    $edit_state = true;
    $rec = mysqli_query($con, "select * from info where Id = $id");
    $record = mysqli_fetch_array($rec);
    $username = $record['UserName'];
    $password = $record['Password'];
    $email = $record['Email'];
    $mobilenumber = $record['MobileNumber'];
    $address = $record['Address'];
    $id = $record['Id'];
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>  CRUD Operations </title>
    <link rel = 'stylesheet' type="text/css" href="style.css">
</head>
<body>

<?php if (isset($_SESSION['message'])): ?>
            <div class = 'message' > 
                <?php 
                    echo $_SESSION['message'];
                    unset($_SESSION['message']);
                ?>
            </div>

<?php endif ?>



    <form action = "index.php" method = "POST">
    <input type = "hidden" name ="Id" value = "<?php echo $id; ?>" >
        <div class = "input-group">
            <label> User Name </label>
            <input type = "text" Name="UserName" placeholder = "UserName" value = "<?php echo $username; ?>" > <br><br>
        </div>
        <div class = "input-group">
            <label> Password </label>
            <input type = "Password" Name="Password" placeholder = "Password" value = "<?php echo $password; ?>"> <br><br>
        </div>
        <div class = "input-group">
            <label> Email </label>
            <input type = "Email" Name="Email" placeholder = "Email" value = "<?php echo $email; ?>" > <br><br>
        </div>
        <div class = "input-group">
            <label> MobileNumber </label>
            <input type = "num" Name = "MobileNumber" placeholder = "Mobile Number" value = "<?php echo $mobilenumber; ?>" > <br><br>
        </div>
        <div class = "input-group">
            <label> Address </label>
            <input type = "text" Name = "Address" placeholder = "Address" value = "<?php echo $address; ?>" > <br><br>
        </div>
        
        <div class = "input-group">
            <?php if ($edit_state == false): ?>
                <button type = "Submit" name = "save" class = "btn"> Save </button>           
            <?php else: ?>
                <button type = "Submit" name = "update" class = "btn"> Update </button>           
            <?php endif ?>


        </div>
    </form>

    

    <table>
        <thead>
            <tr>                
                <th> UserName </th>
                <th> Password </th>
                <th> EmailID </th>
                <th> MobileNumber </th>
                <th> Address </th>       
                <th colspan = "2"> Action </th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = mysqli_fetch_array($result)) { ?>
            <tr>
                <td><?php echo $row['UserName'] ?></td>
                <td><?php echo $row['Password'] ?></td>
                <td><?php echo $row['Email'] ?></td>
                <td><?php echo $row['MobileNumber'] ?></td>
                <td><?php echo $row['Address'] ?></td>
                <td><a class = "edit_btn" href = "index.php?edit=<?php echo $row['Id']; ?>" > Edit </a></td>
                <td><a class = "del_btn" href = "index.php?delete=<?php echo $row['Id']; ?>" > Delete </a></td>
            </tr>
            <?php } ?>

           
            
        </tbody>    
    </table>
</body>
</html>