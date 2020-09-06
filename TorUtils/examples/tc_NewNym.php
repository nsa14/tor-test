<?php

require_once 'common.php'; // using composer

use Dapphp\TorUtils\ControlClient;

$tc = new ControlClient();

try {
    $tc->connect('127.0.0.1', 9150); // connect to 127.0.0.1:9051
    $tc->authenticate(''); // can also use cookie or empty auth
    $tc->signal(ControlClient::SIGNAL_NEWNYM);
    echo "Signal sent - IP changed successfully!\n";
} catch (\Exception $ex) {
    echo "Signal failed: " . $ex->getMessage() . "\n";
}

// /**
//  * Simple example showing how to send a signal to Tor to change your IP address
//  */

// require_once 'common.php';

// use Dapphp\TorUtils\ControlClient;

// $tc = new ControlClient();

// try {
//     $tc->connect('127.0.0.1', 9150); // connect to controller at 127.0.0.1:9051
//     $tc->authenticate("");   // authenticate using hashedcontrolpassword "password"
//     $tc->signal(ControlClient::SIGNAL_NEWNYM); // send signal to change IP

//     echo "Signal sent - IP changed successfully!\n";
// } catch (\Exception $ex) {
//     echo "Signal failed: " . $ex->getMessage() . "\n";
// }
?>