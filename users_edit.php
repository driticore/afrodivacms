<?php


include("includes/config.php");
include("includes/functions.php");
include("includes/database.php");
include("includes/aside.php");
secure();

if (isset($_POST['username'])) {
    if ($stm = $connect ->prepare("UPDATE users set username = ? , email = ?, active = ? WHERE id = ?")) {
        $stm ->bind_param('sssi' , $_POST['username'], $_POST['email'], $_POST['active'], $_GET['id']);
        $stm -> execute();

        $stm->close();
        
        if(isset($_POST['password'])) {
            if ($stm = $connect ->prepare("UPDATE users set password = ? WHERE id = ?")) {
                $hashed = SHA1($_POST['password']);
                $stm ->bind_param('si' , $hashed, $_GET['id']);
                $stm -> execute();

                $stm->close();
    
                
        
            } else {
                echo 'Could not prepare password update statement';
            }

            set_message('User ID ' . $_GET['id'] . ' has been successfully edited ');
        header('Location: users.php');
        die(); 
    
        }

    } else {
        echo 'Could not prepare user update statement';
    }


}



if (isset($_GET['id'])) {
    if ($stm = $connect->prepare('SELECT * FROM users WHERE id = ?')) {
        $stm->bind_param('i', $_GET['id']);
        $stm->execute();

        $result = $stm->get_result();
        $user = $result->fetch_assoc();

        if ($user){


?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h1 class="display-1">Edit User</h1>


            <form method="post">
                <!-- Username input -->
                <div data-mdb-input-init class="form-outline mb-4">
                    <input type="username" id="username" name="username" value="<?php echo $user['username']; ?>" class="form-control active" />
                    <label class="form-label" for="username">Username</label>
                </div>

                <!-- Email input -->
                <div data-mdb-input-init class="form-outline mb-4">
                    <input type="email" id="email" name="email" value="<?php echo $user['email']; ?>" class="form-control active" />
                    <label class="form-label" for="email">Email address</label>
                </div>

                 <!-- Password input -->
                 <div data-mdb-input-init class="form-outline mb-4">
                    <input type="password" id="password" name="password" class="form-control active" />
                    <label class="form-label" for="password">Password</label>
                </div>

                <!-- Active Select -->
                <div data-mdb-input-init class="form-outline  mb-4">
                    <select name="active" id="active" class="form-select">
                        <option <?php echo ($user['active']) ? "selected" : ""; ?> value="1">Active</option>
                        <option <?php echo ($user['active']) ? "" : "selected"; ?> value="0">Inactive</option>
                    </select>
                </div>

                

                <!-- Submit button -->
                <button data-mdb-ripple-init type="submit" class="btn btn-primary --mdb-black btn-block">Update User</button>
            </form>
        </div>

    </div>
</div>

<?php

            }
            $stm->close();
            die();

        } else {
            echo 'Could not prepare statement';
        }
    } else {
    echo 'No user selected';
    die();
}
include("includes/footer.php");
?>