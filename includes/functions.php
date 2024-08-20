<?php 

function secure() {
    if (!isset($_SESSION["id"])) {
        set_message("Please login first to view this page");
        header("Location: index.php");
        die();
    }
}


?>