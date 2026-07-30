<?php

require_once __DIR__ . '/challenges.php';

/**
 * @return array<int, array{id: string, title: string, path: string, summary: string, focus: string, slug: string}>
 */
function getExerciseCatalog(): array
{
    $catalog = [];
    foreach (getChallenges() as $challenge) {
        $catalog[] = [
            'id' => $challenge['id'],
            'title' => $challenge['title'],
            'path' => 'exercises/' . $challenge['id'] . '/task.php',
            'summary' => strlen($challenge['description']) > 80 ? substr($challenge['description'], 0, 77) . '...' : $challenge['description'],
            'focus' => $challenge['focus'],
            'slug' => $challenge['slug']
        ];
    }
    return $catalog;
}

function getExerciseById(string $id): ?array
{
    foreach (getExerciseCatalog() as $exercise) {
        if ($exercise['id'] === $id) {
            return $exercise;
        }
    }

    return null;
}

function buildExerciseHref(string $id): string
{
    return '/exercises/' . $id;
}
