<?php

$connect = mysqli_connect("mysql.db.mdbgo.com","driticore_afrodivacms","Dhl@min1","driticore_afrodivacms");

if (mysqli_connect_errno()) {
    exit("Failed to connect to MYSQL: " . mysqli_connect_error());

}