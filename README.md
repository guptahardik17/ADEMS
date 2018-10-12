--------------------------------------------------------------------------------------------------
       ADEMS - Absolute Distributed Environment Monitoring System
--------------------------------------------------------------------------------------------------

-----
How actually it works?
-----

1) All the sensors connected through the Arduino board are sensing the data and sending to the server database.

2) Then the maps are plotted by fetching the data from the database.

NOTE: ALL THE DATA WE HAVE USED ARE DUMMY DATA.

-----
Source Code Files:
-----

1) ademshv2.ino contains the code for sensing and sending the data to the server.

2) locationmap.php contains the code for fetch the data from the database and plot a Location Map using Google Maps.

3) connect.php contains the code for fetching the data from the database and encode to json format.

2) heatmap.php contains the code for plotting a Heat Map(in terms of Pollution values) using Google Maps.


-----
Visit Webpage to see maps: https://prayaascorps.com/adems/
-----
