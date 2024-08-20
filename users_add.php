<?php


include("includes/config.php");
include("includes/functions.php");
include("includes/database.php");
include("includes/aside.php");
secure();

if (isset($_POST["username"])) {
    try {
        if ($stm = $connect->prepare("INSERT INTO users (username, email, password, active) VALUES (?, ?, ?, ?)")) {
            $hashed = SHA1($_POST['password']);
            $stm->bind_param('ssss', $_POST['username'], $_POST['email'], $hashed, $_POST['active']);
            $stm->execute();
            
            set_message('A new user ' . $_POST["username"] . ' has been added.');
            header('Location: users.php');
            $stm->close();
            die();
        } else {
            throw new Exception('Could not prepare statement.');
        }
    } catch (mysqli_sql_exception $e) {
        // Check for a duplicate entry error
        if ($e->getCode() == 1062) {
            set_message('Error: The email address is already in use.');
        } else {
            set_message('Error: ' . $e->getMessage());
        }
        header('Location: users.php');
        die();
    } catch (Exception $e) {
        set_message('Error: ' . $e->getMessage());
        header('Location: users.php');
        die();
    }


}
?>
<div class="container mt-5" style="padding-top: 100px; ">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h1 class="display-1">Add User</h1>


            <form method="post">
                <!-- Username input -->
                <div data-mdb-input-init class="form-outline mb-4">
                    <input type="username" id="username" name="username" class="form-control" />
                    <label class="form-label" for="username">Username</label>
                </div>

                <!-- Email input -->
                <div data-mdb-input-init class="form-outline mb-4">
                    <input type="email" id="email" name="email" class="form-control" />
                    <label class="form-label" for="email">Email address</label>
                </div>

                <!-- Password input -->
                <div data-mdb-input-init class="form-outline mb-4">
                    <input type="password" id="password" name="password" class="form-control" />
                    <label class="form-label" for="password">Password</label>
                </div>

                <!-- Active Select -->
                <div data-mdb-input-init class="form-outline  mb-4">
                    <select name="active" id="active" class="form-select">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>

                

                <!-- Submit button -->
                <button data-mdb-ripple-init type="submit" class="btn btn-primary btn-block">Add User</button>
            </form>
        </div>

    </div>
</div>

<?php
include("includes/footer.php");
?>