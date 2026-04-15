<?php

$products = require __DIR__ . '/../src/Data/products.php';
require __DIR__ . '/../src/Helpers/functions.php';

$keyword = $_GET['keyword'] ?? '';

if (!empty($keyword)) {
    $products = searchProducts($products, $keyword);
}

$totalProducts = count($products);
$totalStock = calculateTotalStock($products);
$inStockProducts = getInStockProducts($products);
$inStockCount = count($inStockProducts);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>

    <style>
        body {
            font-family: Arial;
            background: #f4f6f9;
            margin: 0;
        }

        .header {
            background: #007bff;
            color: white;
            padding: 15px;
            text-align: center;
        }

        .container {
            padding: 20px;
        }

        /* BUTTON */
        .btn {
            text-decoration: none;
            padding: 8px 14px;
            background: #6c757d;
            color: white;
            border-radius: 6px;
        }

        /* SEARCH */
        .search-box {
            margin: 20px 0;
        }

        .search-box input {
            padding: 8px;
            width: 200px;
            border-radius: 6px;
            border: 1px solid #ccc;
        }

        .search-box button {
            padding: 8px 12px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 6px;
        }

        /* STAT CARDS */
        .stats {
            display: flex;
            gap: 20px;
            margin-bottom: 30px;
        }

        .card {
            flex: 1;
            padding: 20px;
            border-radius: 8px;
            color: white;
            text-align: center;
        }

        .blue { background: #007bff; }
        .green { background: #28a745; }
        .orange { background: #ffc107; color: black; }

        /* PRODUCT GRID */
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .product {
            background: white;
            padding: 15px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .product:hover{
            cursor: pointer;
            transform: translate(-2.5px, -2.5px);
            box-shadow: 2.5px 2.5px 0 rgba(0,0,0,0.4);
        }

        .status {
            font-weight: bold;
        }

        .in { color: green; }
        .low { color: orange; }
        .out { color: red; }
    </style>

</head>

<body>

<div class="header">
    <h1>📦 Stationery Dashboard</h1>
</div>

<div class="container">

    <!-- 🔙 RETURN HOME BUTTON -->
    <div style="margin-bottom: 20px;">
        <a href="/index.php" style="
            text-decoration: none;
            padding: 8px 14px;
            background: #6c757d;
            color: white;
            border-radius: 6px;
        ">
            ⬅️ Return Home
        </a>
    </div>

    <!-- SEARCH -->
    <div class="search-box">
        <form method="GET">
            <input 
                type="text" 
                name="keyword" 
                placeholder="🔍 Search product..."
                value="<?php echo htmlspecialchars($keyword); ?>"
            >
            <button type="submit">Search</button>
        </form>
    </div>

    <!-- STATISTICS -->
    <div class="stats">
        <div class="card blue">
            <h3>Total Products</h3>
            <p><?php echo $totalProducts; ?></p>
        </div>

        <div class="card green">
            <h3>Total Stock</h3>
            <p><?php echo $totalStock; ?></p>
        </div>

        <div class="card orange">
            <h3>In Stock</h3>
            <p><?php echo $inStockCount; ?></p>
        </div>
    </div>

    <!-- PRODUCT LIST -->
    <div class="grid">

        <?php foreach ($products as $product): ?>

            <?php 
                $status = getInventoryStatus($product['quantity']);
                $class = $product['quantity'] == 0 ? 'out' : ($product['quantity'] <= 5 ? 'low' : 'in');
            ?>

            <div class="product">
                <h3><?php echo formatProductName($product['name']); ?></h3>
                <p><strong>Category:</strong> <?php echo $product['category']; ?></p>
                <p><strong>Stock:</strong> <?php echo $product['quantity']; ?></p>

                <p class="status <?php echo $class; ?>">
                    <?php echo $status; ?>
                </p>
            </div>

        <?php endforeach; ?>

    </div>

</div>

</body>
</html>
