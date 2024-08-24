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
        ['role' => 'system', 'content' => "
        Referencing Marshall Rosenberg's Non-Violent Communication (NVC) principles...
        The user (Jackal) input was:
        >>>
        $text
        <<<
        Do not reply to the user (respond) we are seeking a translation of the above text into Giraffe language.
        Translate the user's message into Giraffe language (non judgmental, empathetic, and compassionate).
        Be sure to include observation(s), feeling(s), need(s), and request(s).
        Send the rephrased message back only."],
    ],
]);

$response = $result->choices[0]->message->content;
echo json_encode(['response' => $response]);
