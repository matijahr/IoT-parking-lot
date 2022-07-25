<?php
require_once 'connect.php';


if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $sql = "SELECT * FROM smartparkinglot;";

    $query = $conn->prepare($sql);
    $query->execute();

    if ($query->rowCount() == 0) {
        echo ("Nothing like that in database.");
    } else {
        // convert from object to associative field
        $query->setFetchMode(PDO::FETCH_ASSOC);

        foreach ($query as $row) {
            // store parking spot state in array
            $parking_spot = array(
                $row["P1"],
                $row["P2"],
                $row["P3"],
                $row["P4"],
                $row["P5"],
                $row["P6"]
            );
        }

        unset($conn);
    }

    echo json_encode($parking_spot);
} else {
    echo ("Error!");
}
