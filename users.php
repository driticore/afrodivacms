<?php


include("includes/config.php");
include("includes/aside.php");
include("includes/functions.php");
include("includes/database.php");
secure();


if (isset($_GET['delete'])) {
    if ($stm = $connect ->prepare("DELETE FROM users WHERE id = ? ")) {
        $stm ->bind_param('i' , $_GET['delete']);
        $stm -> execute();

         // Reset auto-increment if you want to start over
         $resetStm = $connect->prepare("ALTER TABLE users AUTO_INCREMENT = 1");
         $resetStm->execute();
         $resetStm->close();

        set_message('User ' . $_GET['delete'] . ' has been deleted.');
        header('Location: users.php');
        $stm->close();
        die();

    } else {
        echo 'Could not prepare statement';
    }


}
if ($stm = $connect->prepare("SELECT * FROM users")) {
    $stm->execute();

    $result = $stm->get_result();
 

    if ($result ->num_rows > 0) {


        ?>
        <div class="container mt-5" style="padding-top:100px; margin-left: 13rem;">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <h1 class="display-1 mb-md-5">User <br>Management</h1>
                    <table class="table table-dark table-striped table-hover">
                        <tr>
                            <th>id</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Edit | Delete</th>
                        </tr>

                        <?php while( $record = mysqli_fetch_assoc($result) ){ ?>
                            <tr>
                                <td><?php echo $record['id']; ?></td>
                                <td><?php echo $record['username']; ?></td>
                                <td><?php echo $record['email']; ?></td>
                                <td><?php echo $record['active']; ?></td>
                                <td>
                                    <a href="users_edit.php?id=<?php echo $record['id']; ?>">Edit</a> | 
                                    <a href="users.php?delete=<?php echo $record['id']; ?>">Delete</a> | 
                                </td>
                            </tr>
                        
                        <?php } ?>
                    </table>

                    <div style="margin-top: 50px; margin-bottom: 50px; margin-left: 5px;">
                        <a href="users_add.php" style="border-radius:10px; padding:10px; text-decoration:none ; color: white; background-color: black;">Add new user</a>
                    </div>
                    
                </div>

            </div>
        </div>

        <?php
    }else{
        echo"No users found";
    }

    
    $stm->close();
} else {
    echo 'Could not prepare statement';
}
include("includes/footer.php");
?>