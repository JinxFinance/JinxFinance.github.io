<?php
// Connect to the database
$db = new PDO('mysql:host=localhost;dbname=testdb;charset=utf8', 'username', 'password');

// Query the database
$query = $db->query('SELECT * FROM products');

// Fetch the results
$products = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Product Display Page</title>
</head>
<body>
    <h1>Products</h1>
    <?php foreach ($products as $product): ?>
        <div>
            <h2><?php echo htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8'); ?></h2>
            <p><?php echo htmlspecialchars($product['description'], ENT_QUOTES, 'UTF-8'); ?></p>
            <p><?php echo htmlspecialchars($product['price'], ENT_QUOTES, 'UTF-8'); ?></p>
        </div>
    <?php endforeach; ?>
</body>
</html>
