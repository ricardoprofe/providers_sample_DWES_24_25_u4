<?php
session_start();

if (isset($_SESSION['provider'])) {
    $provider = $_SESSION['provider'];
    echo "<p>Name: " . $provider['name'] . "</p>";
    echo "<p>Email: " . $provider['email'] . "</p>";
    echo "<p>CIF: " . $provider['cif'] . "</p>";
} else {
    echo "<p>No provider data</p>";
}

session_destroy();