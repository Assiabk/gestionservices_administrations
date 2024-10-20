<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo "POST request received.";
} else {
    echo "This endpoint only accepts POST requests.";
}
?>
