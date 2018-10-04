<?php
    if( $_SERVER['REQUEST_METHOD']=='GET' && isset( $_GET['ajax'] ) ){

        $dbhost =   'localhost';
        $dbuser =   'prayaasc'; 
        $dbpwd  =   '******'; 
        $dbname =   'prayaasc_adems';
        $db     =   new mysqli( $dbhost, $dbuser, $dbpwd, $dbname );

        $places=array();

        $sql    =   'select * from location;';

        $res    =   $db->query( $sql );
        if( $res ) while( $rs=$res->fetch_object() ) $places[]=array( 'latitude'=>$rs->lat, 'longitude'=>$rs->lon, 'pressure'=>$rs->pres, 'humidity'=>$rs->humi, 'temperature'=>$rs->temp, 'pollution'=>$rs->pm);
        $db->close();

        header( 'Content-Type: application/json' );
        echo json_encode( $places,JSON_FORCE_OBJECT );
        exit();
    }
?>
<!doctype html>
<html>
    <head>
        <meta charset='utf-8'/>
        <title>Location Map</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
        <script src='https://maps.google.com/maps/api/js' type='text/javascript'></script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBZAc4S-VQUPv0Brq2M3YAkWnu__R3MLXs&callback=myMap"></script>
        
        <script type='text/javascript'>
            (function(){

                var map,marker,latlng,bounds,infowin;
                /* initial locations for map */
                var _lat=28.7041;
                var _lng=77.1025;

                var getacara=0; /* What should this be? is it a function, a variable ???*/

                function showMap(){
                    /* set the default initial location */
                    latlng={ lat: _lat, lng: _lng };

                    bounds = new google.maps.LatLngBounds();
                    infowin = new google.maps.InfoWindow();

                    /* invoke the map */
                    map = new google.maps.Map( document.getElementById('map'), {
                       center:latlng,
                       zoom: 10
                    });

                    /* show the initial marker */
                    marker = new google.maps.Marker({
                       position:latlng,
                       map: map,
                       title: ''
                    });
                    bounds.extend( marker.position );


                    /* I think you can use the jQuery like this within the showMap function? */
                    $.ajax({
                        /* 
                            I'm using the same page for the db results but you would 
                            change the below to point to your php script ~ namely
                            phpmobile/getlanglong.php
                        */
                        url: document.location.href,/*'phpmobile/getlanglong.php'*/
                        data: { 'id': getacara, 'ajax':true },
                        dataType: 'json',
                        success: function( data, status ){
                            $.each( data, function( i,item ){
                                /* add a marker for each location in response data */ 
                                addMarker( item.latitude, item.longitude, "<ul><li>Latitude= "+item.latitude+"&#176;N<li>Longitude= "+item.longitude+"&#176;W<li>Pressure= "+item.pressure+"mB<li>Humidity= "+item.humidity+"%<li>Temperature= "+item.temperature+"&#176;C</ul>");
                            });
                        },
                        error: function(){
                            output.text('There was an error loading the data.');
                        }
                    });                 
                }

                /* simple function just to add a new marker */
                function addMarker(lat,lng,title){
                    marker = new google.maps.Marker({/* Cast the returned data as floats using parseFloat() */
                       position:{ lat:parseFloat( lat ), lng:parseFloat( lng ) },
                       map:map,
                       title:title
                    });

                    google.maps.event.addListener( marker, 'click', function(event){
                        infowin.setContent(this.title);
                        infowin.open(map,this);
                        infowin.setPosition(this.position);
                    }.bind( marker ));

                    bounds.extend( marker.position );
                    map.fitBounds( bounds );
                }


                document.addEventListener( 'DOMContentLoaded', showMap, false );
            }());
        </script>
        <style>
            html, html body, #map{ height:100%; width:100%; padding:0; margin:0; }
        </style>
    </head>
    <body>
        <div id='map'></div>
    </body>
</html>