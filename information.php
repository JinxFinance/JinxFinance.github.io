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

        .btn-primary:active {
            background-color: #4CAF50;
        }

        .btn-primary:focus {
            background-color: #4CAF50;
        }

        .btn-primary:active:focus {
            background-color: #4CAF50;
        }

        .btn-primary:hover:focus {
            background-color: #4CAF50;
        }

        .btn-primary:hover:active {
            background-color: #4CAF50;
        }

        .btn-primary:hover:active:focus {
            background-color: #4CAF50;
        }

        .btn-primary:focus:active {
            background-color: #4CAF50;
        }

        .btn-primary:focus:hover {
            background-color: #4CAF50;
        }

        .btn-primary:focus:hover:active {
            background-color: #4CAF50;
        }

        .btn-primary:focus:active:hover {
            background-color: #00539B;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://unpkg.com/react/umd/react.development.js"></script>
    <script src="https://unpkg.com/react-dom/umd/react-dom.development.js"></script>
    <script src="https://unpkg.com/react-datagrid/dist/react-datagrid.js"></script>
    <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
    <script src="https://unpkg.com/plotly.js-dist@1.58.4/dist/plotly.js"></script>
    <script src="https://unpkg.com/react/umd/react.production.min.js"></script>
    </head>
    <body>
    <h1>Trader Extension</h1>
    <h2>Results</h2>
    <div id="tables-container"></div>

    <php?
    // Include the necessary libraries and dependencies
    require_once 'vendor/autoload.php';

    use Plotly\Plotly;
    use Plotly\Trace\Trace;
    use React\Datagrid\Datagrid;
    use React\Datagrid\DataSource\ArrayDataSource;

    // Get the results of the trader extension's 10 most common functions
    $traderResults = getTraderResults();
    
    // Perform pagination on the results
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $perPage = 10;
    $totalResults = count($traderResults);
    $totalPages = ceil($totalResults / $perPage);
    $offset = ($page - 1) * $perPage;
    $paginatedResults = array_slice($traderResults, $offset, $perPage);

    // Display the paginated results using React CDN tables
    $datagrid = new Datagrid();
    $datagrid->setDataSource(new ArrayDataSource($paginatedResults));
    $datagrid->addColumn('function', 'Function');
    $datagrid->addColumn('result', 'Result');
    $datagrid->render();

    // Display the search form
    echo '<form action="" method="GET">';
    echo '<input type="text" name="search" placeholder="Search">';
    echo '<input type="submit" value="Search">';
    echo '</form>';

    // Perform other calculations and update the results based on the search query

    // Display the Plotly chart with the results
    $chartData = getChartData($traderResults);
    $trace = new Trace($chartData);
    $plotly = new Plotly('YOUR_PLOTLY_USERNAME', 'YOUR_PLOTLY_API_KEY');
    $plotly->plot($trace);

    // Function to get the results of the trader extension's 10 most common functions

    <script>
        $(document).ready(function() {
            $('#image').change(function() {
                var i = $(this).prev('label').clone();
                var file = $('#image')[0].files[0].name;
                $(this).prev('label').text(file);
            });
        });
    </script>
    <!-- Create a React component for the tables -->
    <script>
        // Define the component
        function ResultsTables({ sma, ema, macd, rsi, bbands, stoch }) {
            return (
                <div>
                    <h2>SMA</h2>
                    <table>
                        {/* Render the sma data */}
                        <tbody>
                            {sma.map((value, index) => (
                                <tr key={index}>
                                    <td>{value}</td>
                                </tr>
                            ))}
                        </tbody>
                    </table>
                    <h2>EMA</h2>
                    <table>
                        {/* Render the ema data */}
                        <tbody>
                            {ema.map((value, index) => (
                                <tr key={index}>
                                    <td>{value}</td>
                                </tr>
                            ))}
                        </tbody>
                    </table>
                    <h2>MACD</h2>
                    <table>
                        {/* Render the macd data */}
                        <tbody>
                            {macd.map((value, index) => (
                                <tr key={index}>
                                    <td>{value}</td>
                                </tr>
                            ))}
                        </tbody>
                    </table>
                    <h2>RSI</h2>
                    <table>
                        {/* Render the rsi data */}
                        <tbody>
                            {rsi.map((value, index) => (
                                <tr key={index}>
                                    <td>{value}</td>
                                </tr>
                            ))}
                        </tbody>
                    </table>
                    <h2>BBANDS</h2>
                    <table>
                        {/* Render the bbands data */}
                        <tbody>
                            {bbands.map((value, index) => (
                                <tr key={index}>
                                    <td>{value}</td>
                                </tr>
                            ))}
                        </tbody>
                    </table>
                    <h2>STOCH</h2>
                    <table>
                        {/* Render the stoch data */}
                        <tbody>
                            {stoch.map((value, index) => (
                                <tr key={index}>
                                    <td>{value}</td>
                                </tr>
                            ))}
                        </tbody>
                    </table>
                </div>
            );
        }
        // Get the data from the server
        // if the there is no data, get the data from .dji.txt
        var data = <?php echo json_encode($data); ?>;
        if (data === null) {
            data = <?php echo json_encode($data2); ?>;
        }

    </script>
    <div class="container">
        <div id="results"></div>
        <script>
            // Render the component with the data
            ReactDOM.render(
                <ResultsTables
                    sma={data.sma}
                    ema={data.ema}
                    macd={data.macd}
                    rsi={data.rsi}
                    bbands={data.bbands}
                    stoch={data.stoch}
                />,
                document.getElementById('results')
            );
        </script>
        <h2>Image Upload Form</h2>
        <form action="upload.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="image">Select Image:</label>
                <input type="file" class="form-control-file" id="image" name="image">
            </div>
            <button type="submit" class="btn btn-primary">Upload</button>
        </form>
    </div>
</body>
</html>