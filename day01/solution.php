<?php

/**
 * Day 1 - Part 1
 *
 * Pair up the smallest number in the left list with the smallest number in the right list
 * Then the second-smallest left number with the second-smallest right number, and so on.
 * Within each pair, figure out how far apart the two numbers are. Add up all the distances.
 * What is the total distance between lists?
 */

const INPUT_FILE = 'input.txt';
$list_1 = [];
$list_2 = [];
$total_distance = 0;

// Open file
$fp = @fopen(INPUT_FILE, "r");
if (!$fp) {
    die("Error: Unable to open file " . INPUT_FILE. "\n");
}
// Split lines and assign to respective lists
while (($buffer = fgets($fp)) !== false) {
    $line = explode("   ", $buffer);
    $list_1[] = trim($line[0]);
    $list_2[] = trim($line[1]);
}

// Check if EOF and close file
if (!feof($fp)) {
    die("Error: unexpected fgets() fail\n");
}
fclose($fp);

// Sort lists ascending
sort($list_1, SORT_NUMERIC);
sort($list_2, SORT_NUMERIC);

// Calculate absolute distance between each line and add to total distance
for ($i = 0; $i < count($list_1); $i++) {
    $total_distance += abs($list_1[$i] - $list_2[$i]);
}

// Display results
echo "Total distance: $total_distance\n";

/**
 * Day 1 Part 2
 *
 * Calculate similarity score
 */

$similarity_scores = [];
$similarity_score = 0;

// Calculate individual similarity scores against list_2
// Note: Sorting is 0(n log n), and counting matches with array_filter is 0(n^2) in the worst case.
// To-do: Optimize match counting using hash maps
for ($i = 0; $i < count($list_1); $i++) {
    // Take $i of list_1 and iterate over each value in list_2, passing them to
    // the callback function, then count number of matches.
    $l1_value = $list_1[$i];
    $l2_matches = count(array_filter($list_2, function($x) use ($l1_value) {
        return $x === $l1_value;
    }));

    // Calculate individual similarity score
    $similarity_scores[$i] = $l1_value * $l2_matches;
}

// Total similarity scores
foreach ($similarity_scores as $score) {
    $similarity_score += $score;
}

// Display results
echo "Similarity score: $similarity_score\n";