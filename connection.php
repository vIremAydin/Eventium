<!--
    Ece Kahraman
    21801879
    CS353-001
    
    PHP file to initialize database connection
 -->

<?php 
    $SERVER = "dijkstra.ug.bcc.bilkent.edu.tr";
    $USER = "ece.kahraman";
    $PASS = "lysYQe1I";
    $DATABASE = "ece_kahraman";

    $connection = new mysqli( $SERVER, $USER, $PASS, $DATABASE );

    if( $connection->connect_error ){
        exit( "Connection Error :" . $connection->connect_errno);
    }
?>