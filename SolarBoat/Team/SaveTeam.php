<?php

function SaveTeam($data)
{
    $fileName = "Team.json";
    $file = fopen($fileName,"wa+");
    fwrite($file, $data);
    fclose($file);
}

$data = $_POST["Years"];
SaveTeam($data);




