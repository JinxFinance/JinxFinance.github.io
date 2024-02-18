<?php
// Check if Trader extension is available
if (!function_exists('trader_stdev')) {
    die('Trader extension is not available');
}

// Path to the .dji.txt file
$file = '.dji.txt';

// Read the file
$lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

// Parse the data
$data = [];
foreach ($lines as $line) {
    $parts = explode(',', $line);
    $data[] = end($parts); // Assuming the value we're interested in is the last one on each line
}

// Calculate standard deviation
$stdev = trader_stdev($data);

// Display the result
?>
<!DOCTYPE html>
<html>
<head>
    <title>Trader Stdev Example</title>
</head>
<body>
    <h1>Standard Deviation</h1>
    <p><?php echo $stdev[0]; ?></p>
</body>
</html>
