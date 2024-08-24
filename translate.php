<?php
$input = json_decode(file_get_contents('php://input'), true);
$text = $input['text'] ?? null;
header('Content-Type: application/json');
if (!$text) die(json_encode(['response' => 'Input Text is required!']));
require_once('vendor/autoload.php');
$openai_key = getenv('OPENAI_API_KEY') ?: die(json_encode(['response' => 'OpenAI API Key is required!']));
echo json_encode(['response' => strtoupper($text)]);
