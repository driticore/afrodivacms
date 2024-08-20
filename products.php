<?php


include("includes/config.php");
include("includes/aside.php");
include("includes/functions.php");
include("includes/database.php");
secure();


if (isset($_GET['delete'])) {
    if ($stm = $connect ->prepare("DELETE FROM products WHERE id = ? ")) {
        $stm ->bind_param('i' , $_GET['delete']);
        $stm -> execute();

         // Reset auto-increment if you want to start over
         $resetStm = $connect->prepare("ALTER TABLE products AUTO_INCREMENT = 1");
         $resetStm->execute();
         $resetStm->close();

        set_message('The products ' . $_GET['delete'] . ' has been deleted.');
        header('Location: products.php');
        $stm->close();
        die();

    } else {
        echo 'Could not prepare statement';
    }


}
if ($stm = $connect->prepare("SELECT * FROM products")) {
    $stm->execute();

    $result = $stm->get_result();
 

    if ($result ->num_rows > 0) {


        ?>
        <div class="container mt-5" style="padding-top:50px;  margin-left:10rem;">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <h1 class="display-1 mb-md-5 text-black" style="font-weight: 500;">Product <br>Management</h1>
                    <table class="table table-responsive table-striped table-hover border-black table-dark">
                        <tr>
                            <th class="text-white">Id</th>
                            <th class="text-white">Name</th>
                            <th class="text-white">Price</th>
                            <th class="text-white">Size</th>
                            <th class="text-white">Quantity</th>
                            <th class="text-white">Category Id</th>
                            <th class="text-white">Image URL</th>
                            <th class="text-white">Date Added</th>
                            <th class="text-white">Date Updated</th>
                            <th class="text-white">Edit | Delete</th>
                        </tr>

                        <?php while( $record = mysqli_fetch_assoc($result) ){ ?>
                            <tr>
                                <td class="text-white"><?php echo $record['id']; ?></td>
                                <td class="text-white"><?php echo $record['name']; ?></td>
                                <td class="text-white"><?php echo $record['price']; ?></td>
                                <td class="text-white"><?php echo $record['size']; ?></td>
                                <td class="text-white"><?php echo $record['quantity']; ?></td>
                                <td class="text-white"><?php echo $record['category_id']; ?></td>
                                <td class="text-white"><?php echo $record['image_url']; ?></td>
                                <td class="text-white"><?php echo $record['date']; ?></td>
                                <td class="text-white"><?php echo $record['added']; ?></td>
                                <td>
                                    <a href="products_edit.php?id=<?php echo $record['id']; ?>">Edit</a> | 
                                    <a href="products.php?delete=<?php echo $record['id']; ?>">Delete</a> | 
                                </td>
                            </tr>
                        
                        <?php } ?>
                    </table>
                    
                    <div style="margin-top: 50px; margin-bottom: 50px; margin-left: 5px;">
                        <a href="products_add.php" style="border-radius:10px; padding:10px; text-decoration:none ; color: white; background-color: black;">Add new product</a>
                    </div>
                </div>
                
            </div>
        </div>

        <?php
    }else{
        echo '<a href="products_add.php">Add new product</a>';

        echo'<br>';
        echo ("No products found");
    }

    
    $stm->close();
} else {
    echo 'Could not prepare statement';
}
include("includes/footer.php");
?>