<?php

$uploads_dir = '';

$upload_name = "userfile";

if(is_uploaded_file($_FILES[$upload_name]['tmp_name'])) {
    $tmp_name = $_FILES[$upload_name]["tmp_name"];

    $name = $_FILES[$upload_name]["name"];

    move_uploaded_file($tmp_name, $uploads_dir . basename($name));

    echo "Successful!";
} else {
    echo "Possible file upload attack!\n";
}
