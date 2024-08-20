<?php

include("includes/config.php");
include("includes/aside.php");
include("includes/functions.php");
include("includes/database.php");
secure();

// Initialize user count variable
$user_count = 0;
$product_counts = [];
$category_ids = [];

// Count users
$stm = $connect->prepare("SELECT COUNT(id) AS 'Count' FROM users");
$stm->execute();
$stm->bind_result($user_count);
$stm->fetch();
$stm->close();

// Count products by category
$stm = $connect->prepare("SELECT category_id, COUNT(id) AS 'Count' FROM products GROUP BY category_id");
$stm->execute();
$stm->bind_result($category_id, $count);

while ($stm->fetch()) {
    $category_ids[] = $category_id;
    $product_counts[] = $count;
}

$stm->close();

?>
<div class="container mt-5" style="padding-top:50px; overflow-x: hidden; margin-left: 18rem; ">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h1 class="display-1 text-black" style="font-weight: 500;">Dashboard</h1>
            <div class="grid row gap-2 mt-4">
                <div class="card text-bg-dark mb-3" style="max-width: 100%; padding:20px;">
                    <div class="card-body">
                        <h5 class="card-title">Something Soon</h5>
                        <p class="card-text">Coming Soon</p>
                    </div>
                </div>
                <a href="users.php" class="card text-bg-dark mb-3"  style="text-decoration: none; max-width: 48%; padding:20px;">
                <div >
                    <div class="card-body">
                        <h5 class="card-title">Users</h5>
                        <canvas id="userChart"></canvas>
                    </div>
                </div>
                </a>
                <a href="products.php" class="card text-bg-dark mb-3"  style="text-decoration: none; max-width: 50.3%; padding:20px;">
                    <div >
                    <div class="card-body">
                        <h5 class="card-title">Products</h5>
                        <canvas id="productsChart"></canvas>
                    </div>
                    </div>
                </a>
                
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Users Chart
    const ctx = document.getElementById('userChart').getContext('2d');
    const userChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Users'], // Labels for your data
            datasets: [{
                label: 'Number of Users',
                data: [<?php echo $user_count; ?>], // PHP variable with user count
                backgroundColor: '##0000',
                borderColor: '#fefefe',
                borderWidth: 1
            }]
        },
    });

    // Products Chart
    const ctx1 = document.getElementById('productsChart').getContext('2d');
    const productsChart = new Chart(ctx1, {
        type: 'bar', // Changed to 'bar' to better represent categories
        data: {
            labels: <?php echo json_encode($category_ids); ?>, // Category IDs
            datasets: [{
                label: 'Number of Products per Category',
                data: <?php echo json_encode($product_counts); ?>, // Product counts per category
                backgroundColor: '##0000',
                borderColor: '#fefefe',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

<?php
include("includes/footer.php");
?>
