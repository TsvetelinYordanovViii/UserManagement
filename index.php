<?php
include "PurePHP/UserManagement.php";

$usersDb = UserManagement::connect("localhost", "usermanagement", "root", "");
$message = array("", "", "", "");

if (isset($_POST["add-user"])){
    $message[0] = UserManagement::addUser($_POST["username"], $_POST["email"], $_POST["role"]);
}
else if (isset($_POST["update-user"])){
    $message[1] = UserManagement::updateUser($_POST["username"], $_POST["email"], $_POST["role"], $_POST["id"]);
}
else if (isset($_POST["find-user"])){
    $message[2] = UserManagement::findUser($_POST["id"]);
}
else if (isset($_POST["delete-user"])){
    $message[3] = UserManagement::deleteUser($_POST["id"]);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="Styles/Styles.css">
    <title>User Management</title>
</head>
<body>

    <div class="container d-flex flex-row align-items-center justify-content-center flex-wrap">
        <form class="m-5 d-flex flex-column align-items-center" id="add" action="" method="post">
            <input class="form-control mb-2" name="username" type="text" placeholder="Username">
            <input class="form-control mb-2" name="email" type="email" placeholder="Email">
            <input class="form-control mb-2" name="role" type="text" placeholder="Role">
            <input class="submit-btn form-control" name="add-user" type="submit" value="Add User">
            
            <label class="mt-1" for=""><?php echo $message[0] ?></label>
        </form>
        <form class="m-5 d-flex flex-column align-items-center" id="update" action="" method="post">
            <input class="form-control mb-2" name="username" type="text" placeholder="Username">
            <input class="form-control mb-2" name="email" type="email" placeholder="Email">
            <input class="form-control mb-2" name="role" type="text" placeholder="Role">
            <input class="form-control mb-2" name="id" type="number" placeholder="ID">
            <input class="submit-btn form-control" name="update-user" type="submit" value="Add User">

            <label class="mt-1" for=""><?php echo $message[1] ?></label>
        </form>
        
        <form class="m-5 d-flex flex-column align-items-center" id="search" action="" method="post">
            <input class="form-control mb-2" name="id" type="number" placeholder="ID">
            <input class="submit-btn form-control" name="find-user" type="submit" value="Search User">

            <label class="mt-1" for=""><?php echo $message[2] ?></label>
        </form>

        <form class="m-5 d-flex flex-column align-items-center" id="delete" action=""  method="post">
            <input class="form-control mb-2" name="id" type="number" placeholder="ID">
            <input class="submit-btn form-control" name="delete-user" type="submit" value="Delete User">
            
            <label class="mt-1" for=""><?php echo $message[3] ?></label>
        </form>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>
</html>