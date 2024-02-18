<?php
// Check if Trader extension is loaded
if (!extension_loaded('trader')) {
    die("Trader extension is not loaded.\n");
    }

    // Load data from file
    $data = file_get_contents('~/.jinx.txt');
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

<?php
// Check if the file exists
if (!file_exists('~/.dji.txt')) {
    die('~/.dji.txt does not exist.');
}

// Read the file
$fileContent = file_get_contents('~/.dji.txt');

// Convert the file content to an array
$data = explode("\n", trim($fileContent));

// Create a new doubly linked list
$dll = new SplDoublyLinkedList();

// Add the data to the doubly linked list
foreach ($data as $value) {
    $dll->push($value);
}

// Connect to the database
$db = new PDO('mysql:host=localhost;dbname=test', 'username', 'password');

// Prepare the SQL statement
$stmt = $db->prepare('INSERT INTO DJI (value) VALUES (:value)');

// Iterate through the doubly linked list
for ($dll->rewind(); $dll->valid(); $dll->next()) {
    // Bind the value to the SQL statement
    $stmt->bindValue(':value', $dll->current());

    // Execute the SQL statement
    $stmt->execute();
}
?>
