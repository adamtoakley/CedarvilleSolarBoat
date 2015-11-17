<?php

$fileName = $_POST["filename"];
move_uploaded_file($_FILES["memberphoto"]["tmp_name"], dirname(__FILE__)."../.."."/Content/images/".$fileName);