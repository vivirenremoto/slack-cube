<?php

$file = "status.txt";

//print_r($_POST);

if (count($_POST)) {
    file_put_contents($file, $_POST['status']);
}

echo file_get_contents($file);
