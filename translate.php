<?php
$input = json_decode(file_get_contents('php://input'), true);
$text = $input['text'] ?? null;
header('Content-Type: application/json');
if (!$text) die(json_encode(['response' => 'Input Text is required!']));
require_once('vendor/autoload.php');
$openai_key = getenv('OPENAI_API_KEY') ?: die(json_encode(['response' => 'OpenAI API Key is required!']));
$client = OpenAI::client($openai_key);

$result = $client->chat()->create([
    'model' => 'gpt-4o-2024-08-06',
    'messages' => [
        ['role' => 'user', 'content' => $text],
        ['role' => 'system', 'content' => 'Translate the above user text from Jackal Language to Giraffe Language (per Marshall Rosenbergs Non-Violent Communication (NVC) principles).'],
    ],
]);

$response = $result->choices[0]->message->content;
echo json_encode(['response' => $response]);
