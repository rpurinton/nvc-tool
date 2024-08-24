<?php
$input = json_decode(file_get_contents('php://input'), true);
$text = $input['text'];
sleep(2);
header('Content-Type: application/json');
echo json_encode(['response' => strtoupper($text)]);
