#!/usr/bin/env php
<?php

declare(strict_types=1);

$jsonPath = __DIR__ . '/../src/challenges.json';

function printHelp(): void
{
    echo "PHP Challenge Creator CLI\n";
    echo "Usage:\n";
    echo "  Interactive:\n";
    echo "    php bin/add-challenge.php --interactive\n";
    echo "  Manual:\n";
    echo "    php bin/add-challenge.php --title=\"Reverse a String\" --desc=\"Reverse the given string\" --focus=\"string manipulation\" --starter=\"\$str = 'hello';\" --expected=\"olleh\"\n";
    echo "  LLM Generated:\n";
    echo "    php bin/add-challenge.php --prompt=\"array filtering based on key length\"\n";
    echo "  JSON Import:\n";
    echo "    php bin/add-challenge.php --json='{\"title\":\"Title\"...}'\n";
}

function ask(string $question, string $default = ''): string
{
    $prompt = $default !== '' ? "$question [$default]: " : "$question: ";
    echo $prompt;
    $input = trim(fgets(STDIN));
    return $input === '' ? $default : $input;
}

function askMultiline(string $question): string
{
    echo "$question (Enter ctrl+D or an empty line with '.' to finish):\n";
    $lines = [];
    while (true) {
        $line = fgets(STDIN);
        if ($line === false) {
            break;
        }
        $trimmed = trim($line);
        if ($trimmed === '.') {
            break;
        }
        $lines[] = rtrim($line, "\r\n");
    }
    return implode("\n", $lines);
}

// Parse args
$opts = getopt('', [
    'interactive',
    'title::',
    'desc::',
    'focus::',
    'starter::',
    'context::',
    'expected::',
    'prompt::',
    'json::',
    'help'
]);

if (isset($opts['help'])) {
    printHelp();
    exit(0);
}

$challenge = null;

if (isset($opts['prompt'])) {
    $promptText = trim((string)$opts['prompt']);
    $geminiKey = getenv('GEMINI_API_KEY');
    $openaiKey = getenv('OPENAI_API_KEY');

    if (!$geminiKey && !$openaiKey) {
        echo "Error: To use LLM generation, set GEMINI_API_KEY or OPENAI_API_KEY env variables.\n";
        echo "Defaulting to manual interactive mode...\n\n";
        $opts['interactive'] = true;
    } else {
        echo "Generating challenge using LLM for prompt: \"$promptText\"...\n";
        $systemPrompt = "You are an AI generating high-quality PHP programming workouts / challenges for developers to practice coding from memory/chops without references.\n" .
            "Generate a coding challenge based on this prompt: \"$promptText\".\n" .
            "The output must be a single valid JSON object containing exactly these keys:\n" .
            "{\n" .
            "  \"title\": \"Short, descriptive title of the challenge\",\n" .
            "  \"description\": \"Detailed description of the task, starting variable context, formatting requirements, and expected outcome.\",\n" .
            "  \"focus\": \"PHP functions, key constructs, array filters, etc. being tested\",\n" .
            "  \"starter_code\": \"PHP starter code containing starter variables or inputs. Do not include <?php. Avoid helper solutions.\",\n" .
            "  \"context_code\": \"Optional context code run helper functions or variables, run BEFORE starter code (hidden from user). Usually empty.\",\n" .
            "  \"expected_output\": \"The EXACT output (stdout) printed by the correct solution when it is run.\"\n" .
            "}\n" .
            "Ensure the output satisfies PHP syntax, and the expected_output matches the output of a correct solution.";

        $jsonStr = '';
        if ($geminiKey) {
            $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=" . $geminiKey;
            $payload = [
                'contents' => [
                    ['parts' => [['text' => $systemPrompt]]]
                ],
                'generationConfig' => [
                    'responseMimeType' => 'application/json'
                ]
            ];
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
            $response = curl_exec($ch);
            curl_close($ch);

            if ($response) {
                $resData = json_decode($response, true);
                $jsonStr = $resData['candidates'][0]['content']['parts'][0]['text'] ?? '';
            }
        } elseif ($openaiKey) {
            $url = "https://api.openai.com/v1/chat/completions";
            $payload = [
                'model' => 'gpt-4o-mini',
                'messages' => [
                    ['role' => 'user', 'content' => $systemPrompt]
                ],
                'response_format' => ['type' => 'json_object']
            ];
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $openaiKey
            ]);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
            $response = curl_exec($ch);
            curl_close($ch);

            if ($response) {
                $resData = json_decode($response, true);
                $jsonStr = $resData['choices'][0]['message']['content'] ?? '';
            }
        }

        if ($jsonStr !== '') {
            $challenge = json_decode($jsonStr, true);
            if (!$challenge || !isset($challenge['title'], $challenge['description'], $challenge['expected_output'])) {
                echo "Error: LLM generated invalid JSON structure: $jsonStr\n";
                $challenge = null;
            } else {
                echo "LLM Successfully generated: " . $challenge['title'] . "\n";
            }
        } else {
            echo "Error: LLM API request failed or returned empty response.\n";
        }
    }
}

if (isset($opts['json'])) {
    $rawJson = trim((string)$opts['json']);
    if (is_file($rawJson)) {
        $rawJson = file_get_contents($rawJson);
    }
    $challenge = json_decode($rawJson, true);
    if (!$challenge) {
        echo "Error: Invalid JSON input.\n";
        exit(1);
    }
}

if ($challenge === null && !isset($opts['interactive']) && isset($opts['title'])) {
    $challenge = [
        'title' => $opts['title'],
        'description' => $opts['desc'] ?? '',
        'focus' => $opts['focus'] ?? '',
        'starter_code' => $opts['starter'] ?? '',
        'context_code' => $opts['context'] ?? '',
        'expected_output' => $opts['expected'] ?? '',
    ];
}

if ($challenge === null || isset($opts['interactive'])) {
    echo "Entering Interactive Challenge Creation Mode\n";
    $challenge = [
        'title' => ask("Challenge Title", $challenge['title'] ?? ''),
        'description' => askMultiline("Description", $challenge['description'] ?? ''),
        'focus' => ask("Focus areas / topics", $challenge['focus'] ?? ''),
        'starter_code' => askMultiline("Starter code", $challenge['starter_code'] ?? ''),
        'context_code' => askMultiline("Context code (optional)", $challenge['context_code'] ?? ''),
        'expected_output' => askMultiline("Expected Output (printed)", $challenge['expected_output'] ?? ''),
    ];
}

// Basic validation
if (empty($challenge['title'])) {
    echo "Error: Challenge Title is required.\n";
    exit(1);
}

// Generate slug
$slug = strtolower(trim((string)preg_replace('/[^A-Za-z0-9-]+/', '-', $challenge['title']), '-'));
$challenge['slug'] = $slug;

// Find next ID
$challenges = [];
if (is_file($jsonPath)) {
    $challenges = json_decode(file_get_contents($jsonPath), true) ?: [];
}

$maxId = 0;
foreach ($challenges as $c) {
    if (isset($c['id']) && is_numeric($c['id'])) {
        $maxId = max($maxId, (int)$c['id']);
    }
    if (isset($c['slug']) && $c['slug'] === $slug) {
        echo "Error: Challenge with slug '$slug' already exists.\n";
        exit(1);
    }
}

$nextId = sprintf("%03d", $maxId + 1);
$challenge['id'] = $nextId;

// Rearrange keys for nice formatting
$finalChallenge = [
    'id' => $challenge['id'],
    'slug' => $challenge['slug'],
    'title' => $challenge['title'],
    'description' => $challenge['description'],
    'focus' => $challenge['focus'],
    'starter_code' => $challenge['starter_code'],
    'context_code' => $challenge['context_code'],
    'expected_output' => $challenge['expected_output'],
];

$challenges[] = $finalChallenge;

if (file_put_contents($jsonPath, json_encode($challenges, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)) !== false) {
    echo "\nSuccess! Added challenge ID: {$finalChallenge['id']}, Title: '{$finalChallenge['title']}', Slug: '{$finalChallenge['slug']}'\n";
} else {
    echo "Error: Failed to write to challenges.json.\n";
    exit(1);
}
