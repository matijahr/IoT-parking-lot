<!DOCTYPE html>
<html lang="en">

<?php
require_once 'connect.php'
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/OperatorWebsiteStyle.css">
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- http://localhost/Web%20Programiranje/IoT%20projekt/OperatorWebsite.php -->
    <title>Operator website</title>
</head>

<body>


<div id="grid-container-element">

    <div id="parent" class="grid-child-element">
    <iframe src="http://192.168.135.10/"></iframe>
        <button id="P1" class="button">P1</button>
        <button id="P4" class="button">P4</button>
        <button id="P2" class="button">P2</button>
        <button id="P5" class="button">P5</button>
        <button id="P3" class="button">P3</button>
        <button id="P6" class="button">P6</button>
    </div>

    <div id="container_table" class="grid-child-element">
        <table id="parking_table">
            <thead>
                <tr>
                    <th><h1>Parking spot</h1></th>
                    <th><h1>Available</h1></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="park_number">P1</td>
                    <td id="1" class="free">Yes</td>
                </tr>

                <tr>
                    <td class="park_number">P2</td>
                    <td id="2" class="free">Yes</td>
                </tr>
                
                <tr>
                    <td class="park_number">P3</td>
                    <td id="3" class="free">Yes</td>
                </tr>

                <tr>
                    <td class="park_number" >P4</td>
                    <td id="4" class="free">Yes</td>
                </tr>

                <tr>
                    <td class="park_number">P5</td>
                    <td id="5"class="free">Yes</td>
                </tr>

                <tr>
                    <td class="park_number">P6</td>
                    <td id="6" class="free">Yes</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>


</body>


<script>

    $(document).ready(function() {
            $.ajax({
                url: "getDatabaseData.php",
                type: "POST",
                success: function(jsonList) {
                    data = JSON.parse(jsonList);
                    //console.log(data);

                    //copy database data to array
                    for (i = 0; i < data.length; i++) {
                        index=i+1;
                        var y = document.getElementById(index);
                        if (data[i] == true) {
                            PARKING_SPOT_STATUS[i] = true;
                            y.classList.add("occupied");
                            y.innerHTML="No"
                        
                        } else {
                            PARKING_SPOT_STATUS[i] = false;
                            y.classList.remove("occupied");
                            y.innerHTML="Yes"

                        }
                    }
                },
                async: false
            });
        });


    // Create WebSocket connection.
    const socket = new WebSocket('ws://localhost:5000');
    const PARKING_SPOT_STATUS = [];
    const spot= [];

    //get data from database on page load
   
    // https://github.com/Vuka951/tutorial-code/blob/master/py-websockets/clients/index.html
    // Connection opened
    socket.addEventListener('open', function(event) {
        console.log('Connected to the WS Server!')
    });

    // Connection closed
    socket.addEventListener('close', function(event) {
        console.log('Disconnected from the WS Server!')
    });

    // Listen for messages
    socket.addEventListener('message', function(event) {
        //console.log('Message from server ', event.data);
        console.log(event.data);
    });

    // Send a msg to the websocket
    function sendMsg() {
        socket.send(JSON.stringify(PARKING_SPOT_STATUS));
    }

   // Change PARKING_SPOT_STATUS array on btn press
   $("button").click(function(e) {
        e.preventDefault();
        if (this.id == 'P1') {
            console.log("Button P1 pressed");
            PARKING_SPOT_STATUS[0] = !PARKING_SPOT_STATUS[0];
        } else if (this.id == 'P2') {
            console.log("Button P2 pressed");
            PARKING_SPOT_STATUS[1] = !PARKING_SPOT_STATUS[1];
        } else if (this.id == 'P3') {
            console.log("Button P3 pressed");
            PARKING_SPOT_STATUS[2] = !PARKING_SPOT_STATUS[2];
        } else if (this.id == 'P4') {
            console.log("Button P4 pressed");
            PARKING_SPOT_STATUS[3] = !PARKING_SPOT_STATUS[3];
        } else if (this.id == 'P5') {
            console.log("Button P5 pressed");
            PARKING_SPOT_STATUS[4] = !PARKING_SPOT_STATUS[4];
        } else if (this.id == 'P6') {
            console.log("Button P6 pressed");
            PARKING_SPOT_STATUS[5] = !PARKING_SPOT_STATUS[5];
        }
        console.log(PARKING_SPOT_STATUS);
        sendMsg.apply(this, PARKING_SPOT_STATUS);
        for (i = 0; i < PARKING_SPOT_STATUS.length; i++) {
            index=i+1;
            var y = document.getElementById(index);
            if ( PARKING_SPOT_STATUS[i] == true) {
                spot[i] = 1;
                y.classList.add("occupied");
                y.innerHTML="No"

            } else {
                spot[i] = 0;
                y.classList.remove("occupied");
                y.innerHTML="Yes"
            }
        }

        $.ajax({
            url: "UpdateDatabaseData.php",
            type: "POST",
            data: {
                spot: spot
            },
            success: function(msg) {
                console.log(msg);
            },
            async: false
        });
    });
</script>

</html>