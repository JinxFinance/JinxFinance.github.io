<?php
// Check if Trader extension is loaded
if (!extension_loaded('trader')) {
    die("Trader extension is not loaded.\n");
    }

    // Load data from file
    $data = file_get_contents('.dji.txt');
    $rows = explode("\n", $data);
    $closePrices = array_map('floatval', $rows);

    // Calculate technical indicators
    $sma = trader_sma($closePrices, 10);
    $ema = trader_ema($closePrices, 10);
    $macd = trader_macd($closePrices, 12, 26, 9);
    $rsi = trader_rsi($closePrices, 14);
    // $adx = trader_adx($closePrices, 14);
    // $cci = trader_cci($closePrices, 20);
    // $atr = trader_atr($closePrices, 14);
    $bbands = trader_bbands($closePrices, 20);
    $stoch = trader_stoch($closePrices, $closePrices, $closePrices, 14);
    // $willr = trader_willr($closePrices, $closePrices, $closePrices, 14);


    // Print results
    print_r($sma);
    print_r($ema);
    print_r($macd);
    print_r($rsi);
    // print_r($adx);
    // print_r($cci);
    // print_r($atr);
    print_r($bbands);
    print_r($stoch);
    // print_r($willr);
    ?>

    <!-- Include React CDN -->
    <script src="https://unpkg.com/react/umd/react.development.js"></script>
    <script src="https://unpkg.com/react-dom/umd/react-dom.development.js"></script>

    <!-- Create a container for the tables -->
    <div id="tables-container"></div>

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

                    <h2>BBands</h2>
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

                    <h2>Stoch</h2>
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

        // Get the container element
        const container = document.getElementById('tables-container');

        // Render the component
        ReactDOM.render(
            <ResultsTables
                sma={<?php echo json_encode($sma); ?>}
                ema={<?php echo json_encode($ema); ?>}
                macd={<?php echo json_encode($macd); ?>}
                rsi={<?php echo json_encode($rsi); ?>}
                bbands={<?php echo json_encode($bbands); ?>}
                stoch={<?php echo json_encode($stoch); ?>}
            />,
            container
        );
    </script>

    <?php
    class Node {
        // ...
    }

    class DoublyLinkedList extends SplDoublyLinkedList {
        // ...
    }

    $list = new DoublyLinkedList();
    // $list->create(19.99, '2022-01-01 00:00:00');
    // $list->read();
    // $list->update('2022-01-01 00:00:00', 29.99, '2022-01-02 00:00:00');
    // $list->delete('2022-01-02 00:00:00');
?>

<?php
	class Node {
			public $price;
			public $datetime;

			public function __construct($price, $datetime) {
					$this->price = $price;
					$this->datetime = $datetime;
			}
	}

	class DoublyLinkedList extends SplDoublyLinkedList {
			private $pdo;

			public function __construct() {
					$this->pdo = new PDO('sqlite:my_database.db');
					$this->pdo->exec("CREATE TABLE IF NOT EXISTS my_table (price REAL, datetime TEXT);");
			}

			public function create($price, $datetime) {
					$this->push(new Node($price, $datetime));
					$stmt = $this->pdo->prepare("INSERT INTO my_table (price, datetime) VALUES (?, ?);");
					$stmt->execute([$price, $datetime]);
			}

			public function read() {
					foreach($this as $node) {
							echo "Price: {$node->price}, Datetime: {$node->datetime}\n";
					}
			}

			public function update($oldDatetime, $newPrice, $newDatetime) {
					foreach($this as $node) {
							if($node->datetime == $oldDatetime) {
									$node->price = $newPrice;
									$node->datetime = $newDatetime;
							}
					}
					$stmt = $this->pdo->prepare("UPDATE my_table SET price = ?, datetime = ? WHERE datetime = ?;");
					$stmt->execute([$newPrice, $newDatetime, $oldDatetime]);
			}

			public function delete($datetime) {
					foreach($this as $key => $node) {
							if($node->datetime == $datetime) {
									$this->offsetUnset($key);
							}
					}
					$stmt = $this->pdo->prepare("DELETE FROM my_table WHERE datetime = ?;");
					$stmt->execute([$datetime]);
			}
	}

	$list = new DoublyLinkedList();
	// $list->create(19.99, '2022-01-01 00:00:00');
	// $list->read();
	// $list->update('2022-01-01 00:00:00', 29.99, '2022-01-02 00:00:00');
	// $list->delete('2022-01-02 00:00:00');
?>
