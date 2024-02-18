<!DOCTYPE html>
<html>
    <meta charset="UTF-8">
    <title>Image Upload Form</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="https://www.w3schools.com/lib/w3.js"></script>
    <script src="https://www.w3schools.com/lib/w3codecolor.js"></script>
    <!-- W3css -->
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
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
    <!-- W3css Menu with ajax Container active and hover -->
    <script src="https://www.w3schools.com/lib/w3.js"></script>
    <div class="w3-bar w3-black">
        <a href="index.php" class="w3-bar-item w3-button">Home</a>
        <a href="information.php" class="w3-bar-item w3-button">Information</a>
        <a href="index10.php" class="w3-bar-item w3-button">Image Upload</a>
        <a href="index12.php" class="w3-bar-item w3-button">Pagination</a>
    </div>
    <div class="w3-container">
        <h2>Image Upload Form</h2>
        <form action="upload.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="image">Choose Image</label>
                <input type="file" class="form-control-file" id="image" name="image">
            </div>
            <button type="submit" class="btn btn-primary" name="submit">Upload Image</button>
        </form>
    </div>
    <div id="results" class="container">
        <?php
        // Include the database configuration file
        include 'dbConfig.php';

        // Get images from the database
        $query = $db->query("SELECT file_name FROM images ORDER BY uploaded_on DESC");

        if($query->num_rows > 0){
            while($row = $query->fetch_assoc()){
                $imageURL = 'uploads/'.$row["file_name"];
        ?>
            <img src="<?php echo $imageURL; ?>" alt="" />
        <?php }
        }else{ ?>
            <p>No image(s) found...</p>
        <?php } ?>
    </div>
    <div class="container">
<?php
// Database connection
$db = new PDO('mysql:host=localhost;dbname=test', 'username', 'password');

// Get the page number from the URL, or default to 1 if no page number is provided
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Set the number of results to display per page with user input
$resultsPerPage = function () {
    if (isset($_GET['resultsPerPage'])) {
        return (int)$_GET['resultsPerPage'];
    }
    return 10;
};

// Calculate the offset for the SQL query
$offset = ($page - 1) * $resultsPerPage;

// Get the search term from the URL
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Prepare the SQL query
$stmt = $db->prepare("SELECT * FROM table WHERE column LIKE :search LIMIT :offset, :resultsPerPage");
$stmt->bindValue(':search', '%'.$search.'%', PDO::PARAM_STR);
$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
$stmt->bindParam(':resultsPerPage', $resultsPerPage, PDO::PARAM_INT);

// Execute the query
$stmt->execute();

// Fetch the results
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Display the results
foreach ($results as $result) {
    echo $result['column'];
}

// Calculate the total number of pages
$totalResults = $db->query("SELECT COUNT(*) FROM table WHERE column LIKE '%".$search."%'")->fetchColumn();
$totalPages = ceil($totalResults / $resultsPerPage);

// Display the pagination links
for ($i = 1; $i <= $totalPages; $i++) {
    echo "<a href='?page=$i&search=$search'>$i</a> ";
}
?>
    </div>
    <script>
        // W3css Color Picker
        w3CodeColor();

        // W3css Ajax
        w3.includeHTML();

        // W3css Sidebar
        function w3_open() {
            document.getElementById("mySidebar").style.display = "block";
        }
        function w3_close() {
            document.getElementById("mySidebar").style.display = "none";
        }

        // W3css Pagination
        function w3_show_nav(name) {
            var i, x;
            x = document.getElementsByClassName("w3-show");
            for (i = 0; i < x.length; i++) {
                x[i].style.display = "none";
            }
            document.getElementById(name).style.display = "block";
        }

        // W3css Accordion
        function myFunction(id) {
            var x = document.getElementById(id);
            if (x.className.indexOf("w3-show") == -1) {
                x.className += " w3-show";
            } else {
                x.className = x.className.replace(" w3-show", "");
            }
        }

        // W3css Tabs
        function openCity(evt, cityName) {
            var i, x, tablinks;
            x = document.getElementsByClassName("city");
            for (i = 0; i < x.length; i++) {
                x[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tablink");
            for (i = 0; i < x.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" w3-border-red", "");
            }
            document.getElementById(cityName).style.display = "block";
            evt.currentTarget.firstElementChild.className += " w3-border-red";
        }

        // W3css Slideshow
        var slideIndex = 1;
        showDivs(slideIndex);
        function plusDivs(n) {
            showDivs(slideIndex += n);
        }
        function currentDiv(n) {
            showDivs(slideIndex = n);
        }
        function showDivs(n) {
            var i;
            var x = document.getElementsByClassName("mySlides");
            var dots = document.getElementsByClassName("demodots");
            if (n > x.length) {slideIndex = 1}
            if (n < 1) {slideIndex = x.length}
            for (i = 0; i < x.length; i++) {
                x[i].style.display = "none";
            }
            for (i = 0; i < dots.length; i++) {
                dots[i].className = dots[i].className.replace(" w3-white", "");
            }
            x[slideIndex-1].style.display = "block";
            dots[slideIndex-1].className += " w3-white";
        }

        // W3css Google Map
        function myMap() {
            myCenter = new google.maps.LatLng(41.878114, -87.629798);
            var mapOptions = {
                center: myCenter,
                zoom: 12, scrollwheel: false, draggable: false,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };
            var map = new google.maps.Map(document.getElementById("googleMap"), mapOptions);

            var marker = new google.maps.Marker({
                position: myCenter,
            });
            marker.setMap(map);
        }

        // W3css Google AI
        function onSignIn(googleUser) {
            var profile = googleUser.getBasicProfile();
            document.getElementById("googleAI").innerHTML = 'Hello ' + profile.getName();
        }

        // screen recording
        var mediaRecorder;
        var recordedBlobs;

        document.getElementById('start').addEventListener('click', () => {
            navigator.mediaDevices.getUserMedia({video: true})
                .then(handleSuccess, handleFailure);
        });

        document.getElementById('stop').addEventListener('click', () => {
            mediaRecorder.stop();
        });

        function handleSuccess(stream) {
            var options = {mimeType: 'video/webm;codecs=vp9'};
            recordedBlobs = [];
            mediaRecorder = new MediaRecorder(stream, options);
            mediaRecorder.ondataavailable = handleDataAvailable;
            mediaRecorder.onstop = handleStop;
            mediaRecorder.start();
        }

        function handleDataAvailable(event) {
            if (event.data && event.data.size > 0) {
                recordedBlobs.push(event.data);
            }
        }

        function handleStop(event) {
            var superBuffer = new Blob(recordedBlobs, {type: 'video/webm'});
            document.getElementById

('recorded').src = window.URL.createObjectURL(superBuffer);
        }

        function handleFailure(err) {
            console.log('getUserMedia() failed: ', err);
        }

        // W3css Video Capture With Login
        function openForm() {
            document.getElementById("myForm").style.display = "block";
        }

        function closeForm() {
            document.getElementById("myForm").style.display = "none";
        }

        // W3css Video Capture
        var video = document.querySelector("#videoElement");

        if (navigator.mediaDevices.getUserMedia) {
            navigator.mediaDevices.getUserMedia({ video: true })
                .then(function (stream) {
                    video.srcObject = stream;
                })
                .catch(function (err0r) {
                    console.log("Something went wrong!");
                });
        }

        // W3css Video Capture With Login
        function openForm() {
            document.getElementById("myForm").style.display = "block";
        }

        function closeForm() {
            document.getElementById("myForm").style.display = "none";
        }

        // php video upload
        function uploadVideo() {
            var video = document.getElementById('video');
            var videoFormData = new FormData();
            videoFormData.append('video', video.files[0]);

            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'upload.php', true);
            xhr.onload = function () {
                if (xhr.status === 200) {
                    alert('Video uploaded successfully');
                } else {
                    alert('Video upload failed');
                }
            };
            xhr.send(videoFormData);
        }
    </script>

</body>
</html>