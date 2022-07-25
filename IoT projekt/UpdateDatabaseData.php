<?php

require_once 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $parkingSpots = $_POST["spot"];
    
    $P1 = $parkingSpots[0];
    $P2 = $parkingSpots[1];
    $P3 = $parkingSpots[2];
    $P4 = $parkingSpots[3];
    $P5 = $parkingSpots[4];
    $P6 = $parkingSpots[5];

    $sql = "UPDATE smartparkinglot SET P1='$P1', P2='$P2', P3='$P3', P4='$P4', P5='$P5', P6='$P6' WHERE ID=1;";
    
    $query = $conn->prepare($sql);
    $query->execute();
    unset($conn);

    echo ("Success");
} else {
    echo ("Error!");
}
