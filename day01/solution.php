<?php

/**
 * Day 1 - Part 1
 *
 * Pair up the smallest number in the left list with the smallest number in the right list
 * Then the second-smallest left number with the second-smallest right number, and so on.
 * Within each pair, figure out how far apart the two numbers are. Add up all the distances.
 * What is the total distance between lists?
 */

$list_1 = [];
$list_2 = [];
$distance_between = [];
$total_distance = 0;

// Open file, split lines, and assign to respective lists
$fp = @fopen("input.txt", "r");
if ($fp) {
    while (($buffer = fgets($fp)) !== false) {
        $line = explode("   ", $buffer);
        $list_1[] = trim($line[0]);
        $list_2[] = trim($line[1]);
    }

    if (!feof($fp)) {
        echo "Error: unexpected fgets() fail\n";
    }

    fclose($fp);
} else {
    echo "Error: unexpected fopen() fail\n";
}

// Sort lists ascending
sort($list_1, SORT_NUMERIC);
sort($list_2, SORT_NUMERIC);

// Calculate absolute distance between each line and store in distance between list
for ($i = 0; $i < count($list_1); $i++) {
    $distance_between[] = abs($list_1[$i] - $list_2[$i]);
    $last_element = end($distance_between);
    //echo $list_1[$i] . " - " . $list_2[$i] . " = " . $last_element . "\n";
}

// Calculate total distance between the left list and the right list
foreach ($distance_between as $distance) {
    $total_distance += $distance;
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
for ($i = 0; $i < count($list_1); $i++) {
    // Take $i of list_1 and iterate over each value in list_2, passing them to the callback function
    // Count number of matches
    $l1_value = $list_1[$i];
    $l2_matches = count(array_filter($list_2, function($x) use ($l1_value) {
        return $x == $l1_value;
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