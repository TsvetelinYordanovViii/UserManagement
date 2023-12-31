<?php
include "PurePHP/UserManagement.php";

session_start();

$usersDb = UserManagement::connect("localhost", "usermanagement", "root", "");
$message = array("", "", "", "", "");
$foundUser = new User("", "", "", "");

if (!isset($_SESSION["currentUser"])){
    $_SESSION["currentUser"] = new User("0", "root", "noEmail@abv.bg", "admin");
}

if (isset($_POST["add-user"])){
    $message[0] = UserManagement::addUser($_POST["username"], $_POST["email"], $_POST["role"], $usersDb, $_SESSION["currentUser"]);
}
else if (isset($_POST["update-user"])){
    $message[1] = UserManagement::updateUser($_POST["username"], $_POST["email"], $_POST["role"], $_POST["id"], $usersDb, $_SESSION["currentUser"]);
}
else if (isset($_POST["find-user"])){
    $result = UserManagement::findUser($_POST["id"], $usersDb);
    if (isset($result[1][0]["id"])){
        $foundUser = new User($result[1][0]["id"], $result[1][0]["username"], $result[1][0]["email"],$result[1][0]["role"]);
    }
    
    $message[2] = $result[0];
}
else if (isset($_POST["delete-user"])){
    $message[3] = UserManagement::deleteUser($_POST["id"], $usersDb, $_SESSION["currentUser"]);
}
else if (isset($_POST["mimic-user"])){
    if ($_POST["id"] == 0){
        session_destroy();
    }
    else{
        $result = UserManagement::findUser($_POST["id"], $usersDb);
        if (isset($result[1][0]["id"])){
            $_SESSION["currentUser"] = new User($result[1][0]["id"], $result[1][0]["username"], $result[1][0]["email"],$result[1][0]["role"]);
            $username = $_SESSION["currentUser"]->getUsername();
            $message[4] = "Now mimicking as $username.";
        }
        else{
            $message[4] = "User doesn't exist.";
        }
    }
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
            <input class="form-control mb-2" name="username" type="text" placeholder="Username" value="<?php echo $foundUser->getUsername()?>">
            <input class="form-control mb-2" name="email" type="email" placeholder="Email" value="<?php echo $foundUser->getEmail()?>">
            <input class="form-control mb-2" name="role" type="text" placeholder="Role" value="<?php echo $foundUser->getRole()?>">
            <input class="form-control mb-2" name="id" type="number" placeholder="ID" value="<?php echo $foundUser->getId()?>">
            <input class="submit-btn form-control" name="update-user" type="submit" value="Update User">

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
    </div >
    <div class="container d-flex flex-row align-items-center justify-content-center flex-wrap">
        <form class="m-5 d-flex flex-column align-items-center" id="delete" action=""  method="post">
            <input class="form-control mb-2" name="id" type="number" placeholder="ID">
            <input class="submit-btn form-control" name="mimic-user" type="submit" value="Mimic User">
            
            <label class="mt-1" for=""><?php echo $message[4] ?></label>
        </form>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>
</html>