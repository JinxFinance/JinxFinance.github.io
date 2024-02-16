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
