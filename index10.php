<!DOCTYPE html>
<html>
<head>
    <title>Image Upload Form</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .container {
            margin-top: 100px;
        }
        #results {
            margin-top: 50px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid black;
        }

        th, td {
            padding: 15px;
            text-align: left;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        label {
            display: block;
            margin: 10px 0;
        }

        input[type="file"] {
            display: none;
        }

        .form-control-file {
            width: 100%;
        }

        .btn-primary {
            margin-top: 10px;
            background-color: #00539B;
            color: #FFFFFF;
        }

        .btn-primary:hover {
            background-color: #FFFFFF;
            color: #00539B;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Image Upload Form</h2>
    <form action="upload.php" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="image">Choose Image</label>
            <input type="file" class="form-control-file" id="image" name="image">
        </div>
        <button type="submit" class="btn btn-primary">Upload Image</button>
    </form>

    <div id="results">
        <h2>Uploaded Images</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Image</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Connect to MySQL
                $mysqli = new mysqli("localhost", "username", "password", "database");

                // Check connection
                if ($mysqli->connect_errno) {
                    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
                    exit();
                }

                // Fetch images from MySQL
                $query = "SELECT id, image FROM images";
                $result = $mysqli->query($query);

                // Display images in a table
                while ($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>' . $row['id'] . '</td>';
                    echo '<td><img src="' . $row['image'] . '" width="100"></td>';
                    echo '</tr>';
                }

                // Close the MySQL connection
                $mysqli->close();
                ?>
            </tbody>
        </table>
    </div>
</div>
<?php
// Path: upload.php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the file is uploaded without errors
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
        $allowedTypes = array("image/jpeg", "image/png", "image/gif");
        $fileType = $_FILES["image"]["type"];

        // Check if the file type is allowed
        if (in_array($fileType, $allowedTypes)) {
            $fileName = $_FILES["image"]["name"];
            $fileTemp = $_FILES["image"]["tmp_name"];
            $fileSize = $_FILES["image"]["size"];

            // Check if the file size is less than 5MB
            if ($fileSize <= 5242880) {
                // Move the uploaded file to the uploads directory
                $uploadDir = "uploads/";
                $uploadPath = $uploadDir . $fileName;
                move_uploaded_file($fileTemp, $uploadPath);

                // Connect to MySQL
                $mysqli = new mysqli("localhost", "username", "password", "database");

                // Check connection
                if ($mysqli->connect_errno) {
                    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
                    exit();
                }

                // Insert the uploaded image into the images table
                $query = "INSERT INTO images (image) VALUES ('$uploadPath')";
                $mysqli->query($query);

                // Close the MySQL connection
                $mysqli->close();

                // Redirect to the image upload form
                header("Location: index10.php");
                exit();
            } else {
                echo "The file size is too large. Please upload a file less than 5MB.";
            }
        } else {
            echo "The file type is not allowed. Please upload a JPEG, PNG, or GIF file.";
        }
    } else {
        echo "The file was not uploaded. Please try again.";
    }
}

// Assuming you have the JSON data stored in a variable called $jsonData
$jsonData = '...'; // Replace with your actual JSON data

// Decode the JSON data
$data = json_decode($jsonData, true);

// Connect to MySQL
$mysqli = new mysqli("localhost", "username", "password", "database");

// Check connection
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}

// Insert data into MySQL
foreach ($data as $item) {
    $name = $mysqli->real_escape_string($item['name']);
    $image = $mysqli->real_escape_string($item['image']);

    $query = "INSERT INTO images (name, image) VALUES ('$name', '$image')";
    $mysqli->query($query);
}

// Close the MySQL connection
$mysqli->close();

// Fetch images from MySQL
$mysqli = new mysqli("localhost", "username", "password", "database");
$query = "SELECT image FROM images";
$result = $mysqli->query($query);

// Store fetched images in an array
$images = array();
while ($row = $result->fetch_assoc()) {
    $images[] = $row['image'];
}

// Display the images in a React CDN image grid with Bootstrap or W3.CSS
echo '<div class="container">';
echo '<div class="row">';
foreach ($images as $image) {
    echo '<div class="col-md-4">';
    echo '<img src="' . $image . '" class="img-fluid" alt="Image">';
    echo '</div>';
}
echo '</div>';
echo '</div>';

// Display a slideshow on the right
echo '<div class="slideshow">';
// Slideshow code goes here
echo '</div>';

// Display an iframe on the left with toggle buttons
echo '<div class="iframe-container">';
echo '<iframe src="..." frameborder="0" allowfullscreen></iframe>';
echo '<button id="toggleButton1">Toggle Button 1</button>';
echo '<button id="toggleButton2">Toggle Button 2</button>';
echo '</div>';

// Display a popup window with a searchable YouTube iframe
echo '<div class="popup">';
echo '<input type="text" id="searchInput" placeholder="Search YouTube">';
echo '<iframe src="..." frameborder="0" allowfullscreen></iframe>';
echo '</div>';


// Close the MySQL connection
$mysqli->close();
?>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    // JavaScript code goes here
    // ...

    // Example: Toggle the visibility of the iframe
    $('#toggleButton1').click(function() {
        $('.iframe-container iframe').toggle();
    });

    // Example: Search YouTube videos
    $('#searchInput').on('input', function() {
        var searchQuery = $(this).val();
        // Perform a search and update the YouTube iframe
    });

    // ...

    // Example: Toggle the visibility of the popup
    $('#toggleButton2').click(function() {
        $('.popup').toggle('slow', 'swing', function() {
            // Animation complete
        };
    });

    // ...

    // Example: Perform a search and update the YouTube iframe
    $('#searchInput').on('input', function() {
        var searchQuery = $(this).val();
        // Perform a search and update the YouTube iframe
        var iframe = $('.popup iframe');
        iframe.attr('src', 'https://www.youtube.com/embed?search=' + searchQuery);
        
        // Reload the iframe to update the search results
        iframe.attr('src', iframe.attr('src'));

        // ...
    });


</script>

</body>
</html>