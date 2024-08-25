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
    'temperature' => 0.0,
    'top_p' => 0.0,
    'presence_penalty' => 0.0,
    'frequency_penalty' => 0.0,
    'messages' => [
        ['role' => 'system', 'content' => "
        Referencing Marshall Rosenberg's Non-Violent Communication (NVC) principles 
        The user (Jackal) input was:
        >>>
        $text
        <<<
        Assign a score from 0 to 100% on how complaint the user input is with NVC principles.
        If 100% - Congratulate the user
        If less than 100% - bulletpoint the reasons why citing specific examples
        Also provide serveral alternative responses that are more complaint with NVC principles
        including options for formal, informal, causual, and professional settings."],
    ],
]);

$response = $result->choices[0]->message->content;
echo json_encode(['response' => $response]);
