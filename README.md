# IoT-parking-lot

A parking lot made using ESP-32 cam module that provides a video stream for the operators website. 
On the operators website an operator can update the parking spot satus that is then updated in the MySQL database.
ESP-32 cam module is used so that the operator can see the change in the parking spot status.

On the user website a ground plan of the parking lot is displayed. On the page load a SQL querry is done to get the parking spot sastus and on every change made on the operators webpage the parking spot status is updated using websockets. 
