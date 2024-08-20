<?php

include("includes/config.php");
include("includes/functions.php");
include("includes/database.php");
include("includes/aside.php");
secure();

if (isset($_POST["name"])) {
    $image = $_FILES['image_url']['name'];
    $folder = 'Images/';
    $imagePath = $folder . basename($image);

    try {
        if (move_uploaded_file($_FILES['image_url']['tmp_name'], $imagePath)) {
            $stm = $connect->prepare("INSERT INTO products (name, price, quantity, size, category_id, image_url, date) VALUES (?, ?, ?, ?, ?, ?, ?)");

            // Bind the parameters, matching the placeholders in the SQL statement
            $stm->bind_param('sdissss', $_POST['name'], $_POST['price'], $_POST['quantity'], $_POST['size'], $_POST['category_id'], $imagePath, $_POST['date']);
            $stm->execute();

            set_message('A new product ' . $_POST["name"] . ' has been added on '.  $_POST["date"] .'');
            header('Location: products.php');
            $stm->close();
            die();
        } else {
            throw new Exception('File upload failed.');
        }
    } catch (mysqli_sql_exception $e) {
        if ($e->getCode() == 1062) {
            set_message('Error: The product is already uploaded.');
        } else {
            set_message('Error: ' . $e->getMessage());
        }
        header('Location: products.php');
        die();
    } catch (Exception $e) {
        set_message('Error: ' . $e->getMessage());
        header('Location: products.php');
        die();
    }
}
?>

<div class="container mt-5" style="padding:100px 0 50px 0">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h1 class="display-1 mb-6">Add Product</h1>

            <form method="post" enctype="multipart/form-data">
                <!-- Name input -->
                <div class="form-outline mb-4">
                    <label class="form-label" for="name">Name</label>
                    <input type="text" id="name" name="name" class="form-control" required />
                </div>

                <!-- Price input -->
                <div class="form-outline mb-4">
                    <label class="form-label" for="price">Price</label>
                    <input type="number" id="price" name="price" class="form-control" required />
                </div>

                <!-- Quantity input -->
                <div class="form-outline mb-4">
                    <label class="form-label" for="quantity">Quantity</label>
                    <input type="number" id="quantity" name="quantity" class="form-control" required />
                </div>

                <!-- Size input -->
                <div class="form-outline mb-4">
                    <label class="form-label" for="size">Size</label>
                    <input type="text" id="size" name="size" class="form-control" required />
                </div>

                <!-- Image input -->
                <div class="form-outline mb-4">
                    <label class="form-label" for="image_url">Image</label>
                    <input type="file" id="image_url" name="image_url" class="form-control" required />
                </div>

                <!-- Date input -->
                <div class="form-outline mb-4">
                    <label class="form-label" for="date">Date</label>
                    <input type="date" id="date" name="date" class="form-control" required />
                </div>


                <!-- Category input -->
                <div class="form-outline mb-4">
                    <label class="form-label" for="category_id">Category Id</label>
                    <select class="form-select" id="category_id" name="category_id" required>
                        <option value="1">Dress</option>
                        <option value="2">Accessories</option>
                        <option value="3">Bags</option>
                        <option value="4">Covers</option>
                    </select>
                </div>

                <!-- Submit button -->
                <button type="submit" class="btn btn-primary btn-block">Add Product</button>
            </form>
        </div>
    </div>
</div>

<?php
include("includes/footer.php");
?>
