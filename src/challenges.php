<?php

/**
 * @return array<int, array{id: string, slug: string, title: string, description: string, focus: string, starter_code: string, context_code: string, expected_output: string}>
 */
function getChallenges(): array
{
    $jsonPath = __DIR__ . '/challenges.json';
    if (!is_file($jsonPath)) {
        return [];
    }
    $content = file_get_contents($jsonPath);
    return json_decode($content, true) ?: [];
}

function getChallengeById(string $id): ?array
{
    foreach (getChallenges() as $challenge) {
        if ($challenge['id'] === $id) {
            return $challenge;
        }
    }

    return null;
}

function getChallengeBySlug(string $slug): ?array
{
    foreach (getChallenges() as $challenge) {
        if ($challenge['slug'] === $slug) {
            return $challenge;
        }
    }

    return null;
}
