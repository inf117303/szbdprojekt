<?php
header("Content-Type: application/json");

$temperatura = rand(20,25) + rand(0,9) / 10;
$wilgotnosc = rand(60,70);
$cisnienie = rand(1010,1020);
$czas = date("Y-m-d H:i:s");


// Collect what you need in the $data variable.
$data = array('temperature' => $temperatura, 'humidity' => $wilgotnosc, 'pressure' => $cisnienie, 'time' => $czas);
$json = json_encode($data);

if ($json === false) {
    // Avoid echo of empty string (which is invalid JSON), and
    // JSONify the error message instead:
    $json = json_encode(array("jsonError", json_last_error_msg()));
    if ($json === false) {
        // This should not happen, but we go all the way now:
        $json = '{"jsonError": "unknown"}';
    }
    // Set HTTP response status code to: 500 - Internal Server Error
    http_response_code(500);
}
echo $json;
?>