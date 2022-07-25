<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/UserWebsiteStyle.css">
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <title>User website</title>
    <!-- http://localhost/Web%20Programiranje/IoT%20projekt/UserWebsite.php -->
</head>

<body>
    <div id="parking-box" class="center">
        <table id="parking-lot" cellpadding="1">
            <tr>
                <td class="parking-spot top-parking-spot free ">P1</td>
                <td class="parking-spot top-parking-spot free">P2</td>
                <td class="parking-spot top-parking-spot free">P3</td>
            </tr>

            <tr>
                <td class="road" colspan="3">
                    <hr class="dashed">
                </td>
            </tr>

            <tr>
                <td class="parking-spot bottom-parking-spot free">P4</td>
                <td class="parking-spot bottom-parking-spot free">P5</td>
                <td class="parking-spot bottom-parking-spot free">P6</td>
            </tr>
        </table>
    </div>
</body>

<script>
    // Create WebSocket connection.
    const socket = new WebSocket('ws://localhost:5000');
    const PARKING_SPOT_STATUS = [];

    // get data from db on page load
    $(document).ready(function() {
        $.ajax({
            url: "getDatabaseData.php",
            type: "POST",
            success: function(jsonList) {
                data = JSON.parse(jsonList);

                for (i = 0; i < data.length; i++) {
                    if (data[i] == true) {
                        PARKING_SPOT_STATUS[i] = true;
                    } else {
                        PARKING_SPOT_STATUS[i] = false;
                    }
                }
                changeBackground();
            },
            async: false
        });
    });

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
        //store data from Operator website
        socketData = JSON.parse(event.data);
        
        for (i = 0; i < socketData.length; i++) {
            PARKING_SPOT_STATUS[i] = socketData[i];
        }

        changeBackground();
    });

    function changeBackground() {
        var table = document.getElementById("parking-lot");
        
        console.log("changeBackgorund: " + PARKING_SPOT_STATUS);

        for (i = 0; i < PARKING_SPOT_STATUS.length; i++) {
            //Parking spot 1
            if (i == 0 && PARKING_SPOT_STATUS[i] == false) {
                table.rows[0].cells[0].classList.remove("occupied");
            } else if (i == 0 && PARKING_SPOT_STATUS[i] == true) {
                table.rows[0].cells[0].classList.add("occupied");
            }

            //Parking spot 2
            if (i == 1 && PARKING_SPOT_STATUS[i] == false) {
                table.rows[0].cells[1].classList.remove("occupied");
            } else if (i == 1 && PARKING_SPOT_STATUS[i] == true) {
                table.rows[0].cells[1].classList.add("occupied");
            }

            //Parking spot 3
            if (i == 2 && PARKING_SPOT_STATUS[i] == false) {
                table.rows[0].cells[2].classList.remove("occupied");
            } else if (i == 2 && PARKING_SPOT_STATUS[i] == true) {
                table.rows[0].cells[2].classList.add("occupied");
            }

            //Parking spot 4
            if (i == 3 && PARKING_SPOT_STATUS[i] == false) {
                table.rows[2].cells[0].classList.remove("occupied");
            } else if (i == 3 && PARKING_SPOT_STATUS[i] == true) {
                table.rows[2].cells[0].classList.add("occupied");
            }

            //Parking spot 5
            if (i == 4 && PARKING_SPOT_STATUS[i] == false) {
                table.rows[2].cells[1].classList.remove("occupied");
            } else if (i == 4 && PARKING_SPOT_STATUS[i] == true) {
                table.rows[2].cells[1].classList.add("occupied");
            }

            //Parking spot 6
            if (i == 5 && PARKING_SPOT_STATUS[i] == false) {
                table.rows[2].cells[2].classList.remove("occupied");
            } else if (i == 5 && PARKING_SPOT_STATUS[i] == true) {
                table.rows[2].cells[2].classList.add("occupied");
            }
        }
    }

</script>

</html>