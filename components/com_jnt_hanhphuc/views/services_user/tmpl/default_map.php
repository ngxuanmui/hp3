<?php

$tmpAdd = JRequest::getString('address');

$address = base64_decode($tmpAdd);

$geocodeURL = "http://maps.google.com/maps/api/geocode/json?address=" . $address . "&sensor=false&region=VN";

$ch = curl_init($geocodeURL);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$result = curl_exec($ch);

$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

curl_close($ch);

if ($httpCode == 200) {
	$geocode = json_decode($result);

	$lat = $geocode->results[0]->geometry->location->lat;
	$lng = $geocode->results[0]->geometry->location->lng;
}
else
{
	$lat = 0;
	$lng = 0;
}

$arr['lat'] = $lat;
$arr['lng'] = $lng;

echo json_encode($arr); 

exit();

?>