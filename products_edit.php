<?php

include("includes/config.php");
include("includes/functions.php");
include("includes/database.php");
include("includes/aside.php");
secure();

if (isset($_POST['name'])) {
    $image = $_FILES['image_url']['name'];
    $folder = 'Images/';
    $imagePath = $folder . basename($image);

    if (move_uploaded_file($_FILES['image_url']['tmp_name'], $imagePath)) {
        if ($stm = $connect->prepare("UPDATE products SET name = ?, price = ?, quantity = ?, size = ?, category_id = ?, image_url = ? WHERE id = ?")) {
            $stm->bind_param('sdisssi', $_POST['name'], $_POST['price'], $_POST['quantity'], $_POST['size'], $_POST['category_id'], $imagePath, $_GET['id']);
            $stm->execute();

            $stm->close();
            set_message('Product ID ' . $_GET['id'] . ' has been successfully edited.');
            header('Location: products.php');
            exit();
        } else {
            echo 'Could not prepare product update statement';
        }
    } else {
        echo 'File upload failed';
    }
}

if (isset($_GET['id'])) {
    if ($stm = $connect->prepare('SELECT * FROM products WHERE id = ?')) {
        $stm->bind_param('i', $_GET['id']);
        $stm->execute();

        $result = $stm->get_result();
        $product = $result->fetch_assoc();

        if ($product) {
            ?>

            <div class="container mt-5">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <h1 class="display-1">Edit Product</h1>

                        <form method="post" enctype="multipart/form-data">
                            <!-- Name input -->
                            <div class="form-outline mb-4">
                                <label class="form-label" for="name">Name</label>
                                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" class="form-control" required />
                            </div>

                            <!-- Price input -->
                            <div class="form-outline mb-4">
                                <label class="form-label" for="price">Price (R)</label>
                                <input type="number" id="price" name="price" value="<?php echo htmlspecialchars($product['price']); ?>" class="form-control" required />
                            </div>

                            <!-- Quantity input -->
                            <div class="form-outline mb-4">
                                <label class="form-label" for="quantity">Quantity</label>
                                <input type="number" id="quantity" name="quantity" value="<?php echo htmlspecialchars($product['quantity']); ?>" class="form-control" required />
                            </div>

                            <!-- Size input -->
                            <div class="form-outline mb-4">
                                <label class="form-label" for="size">Size</label>
                                <input type="text" id="size" name="size" value="<?php echo htmlspecialchars($product['size']); ?>" class="form-control" required />
                            </div>

                            <!-- Image input -->
                            <div class="form-outline mb-4">
                                <label class="form-label" for="image_url">Image</label>
                                <input type="file" id="image_url" name="image_url" class="form-control" />
                                <p>Current Image: <?php echo htmlspecialchars($product['image_url']); ?></p>
                            </div>

                            <!-- Category input -->
                            <div class="form-outline mb-4">
                                <label class="form-label" for="category_id">Category Id</label>
                                <select class="form-select" id="category_id" name="category_id" required>
                                    <option value="1" <?php if ($product['category_id'] == 1) echo 'selected'; ?>>Dress</option>
                                    <option value="2" <?php if ($product['category_id'] == 2) echo 'selected'; ?>>Accessories</option>
                                    <option value="3" <?php if ($product['category_id'] == 3) echo 'selected'; ?>>Bags</option>
                                    <option value="4" <?php if ($product['category_id'] == 4) echo 'selected'; ?>>Covers</option>
                                </select>
                            </div>

                            <!-- Submit button -->
                            <button type="submit" class="btn btn-primary btn-block">Update Product</button>
                        </form>
                    </div>
                </div>
            </div>

            <?php
        } else {
            echo 'Product not found';
        }

        $stm->close();
    } else {
        echo 'Could not prepare statement';
    }
} else {
    echo 'No product selected';
}

include("includes/footer.php");
?>
