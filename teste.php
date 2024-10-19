<?php


echo "Latitude: " . $latitude . "<br>";
echo "Longitude: " . $longitude . "<br>";


session_start();
echo "<pre>";
print_r($ip_data);
echo "<br>";
echo "<br>";
print_r($_SESSION);
die;
