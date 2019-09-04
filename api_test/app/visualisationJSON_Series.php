<?php

header('Content-type: application/json');

$json = file_get_contents("data_series.json");
$parsed_json = json_decode($json, true);

var_dump($parsed_json);