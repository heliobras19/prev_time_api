<?php
require_once 'mail.php';
function getUser($num, $all = false) {
    $contents = file_get_contents('db.json');
    $json = json_decode($contents, true);
    if ($all) {
       return $json['users'];
    }
    return $json['users'][$num];
}
//print_r($json['users'][0]['cidade']);

function prevTime($city) {
    $headers = array(
        'Content-Type: application/json', 
        'X-RapidAPI-Key: c637aef9c3mshbb663cad08c43edp1c3f15jsncf580c663a91' 
    );
    $ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://weatherapi-com.p.rapidapi.com/forecast.json?q=$city&days=2");
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
	curl_close($ch);      
	return $response;
}



$allUsers = getUser(0, true);

foreach ($allUsers as $key => $user) {
    $data = json_decode(prevTime($user['cidade']));
    $probabilidadeChuva = $data->forecast->forecastday[0]->day->daily_chance_of_rain;
    if ($probabilidadeChuva >= 70) {
        enviarEmail($user['email'], $user['nome'], "Se tiver planos de sair, levar sombrinha a probabilidade de chover hoje é muito alta");
    }
}