<?php

include("includes/config.php");
include("includes/aside.php");
include("includes/functions.php");
include("includes/database.php");


if (isset($_SESSION["id"])) {
    header("Location: dashboard.php");
    die();
}

//Get SQL Query (Basically confirm that the user is in the database)
if (isset($_POST["email"])) {
    if ($stm = $connect ->prepare("SELECT * FROM users WHERE email = ? AND password = ? AND active = 1")) {
        $hashed = SHA1($_POST['password']);
        $stm ->bind_param('ss', $_POST['email'], $hashed);
        $stm -> execute();

        $result = $stm -> get_result();
        $user = $result -> fetch_assoc();


        if ($user) {
            $_SESSION['id'] = $user['id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['username'] = $user['username'];

            //TODO give a feedback / welcome Message
            set_message('You have successfully logged in ' . $_SESSION["username"]);
            header("Location: dashboard.php");
            die();
        }
        $stm->close();
    } else {
        echo 'Could not prepare statement';
    }
    
}
?>
<div class="container mt-5" style="padding-top:100px">
    <div class="row justify-content-center">
        <div class="col-md-6">
        <h1 class="display-2 text-black mb-4" style="font-weight: 500;">Login</h1>

            <form method="post">
                <!-- Email input -->
                <div data-bs-input-init class="mb-3">
                    <label class="form-label" for="email">Email address</label>
                    <input type="email" id="email" name="email" class="form-control" />
                </div>

                <!-- Password input -->
                <div data-bs-input-init class="form-outline mb-4">
                    <label class="form-label" for="password">Password</label>
                    <input type="password" id="password" name="password" class="form-control" />
                </div>

                

                <!-- Submit button -->
                <button data-bs-ripple-init type="submit" class="btn text-white btn-block" style="background-color: black; ">Sign in</button>
            </form>
        </div>

    </div>
</div>

<?php
include("includes/footer.php");
?>