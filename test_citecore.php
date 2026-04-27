<?php
/**
 * Test script for CiteCore
 * Proves that Pinecone's built-in Inference API converts text to vectors and stores them.
 */

require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/config/app.php';
require_once __DIR__ . '/core/CiteCore.php';

$brain = new CiteCore();

echo "1. Storing knowledge...\n";
$brain->store('fact_1', 'Generative Engine Optimization (GEO) focuses on answer-first formatting designed for LLMs.', ['category' => 'seo']);
$brain->store('fact_2', 'Worthycite tracks backlink indexation status daily for Pro users.', ['category' => 'product']);
$brain->store('fact_3', 'Dofollow links pass SEO juice, while Nofollow links do not directly impact rankings.', ['category' => 'seo']);
echo "Done storing 3 facts.\n\n";

echo "2. Querying knowledge... (Checking: 'What is GEO?')\n";
$response = $brain->query('What is GEO?', 2);

if (!empty($response['results'])) {
    foreach ($response['results'] as $i => $match) {
        $score = round($match['score'] * 100, 1);
        echo "Match " . ($i + 1) . " ($score% match):\n";
        echo "- " . $match['text'] . "\n\n";
    }
} else {
    echo "No results or error: " . print_r($response, true) . "\n";
}

echo "3. Index Stats:\n";
print_r($brain->stats());
