<?php

/**
 * Day 1 - Part 1
 *
 * Pair and sort both lists smallest-to-smallest.
 * Calculate the absolute difference for each pair.
 * Sum all differences to find the total distance.
 */

function read_input_file($input_file) : array
{
    // Open file
    $fp = @fopen($input_file, "r");
    if (!$fp) {
        die("Error: Unable to open file " . $input_file. "\n");
    }

    // Split lines and assign to respective lists
    $list_1 = []; $list_2 = [];
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

    return [$list_1, $list_2];
}

function calculate_total_distance($list_1, $list_2) : int
{
    // Sort lists ascending
    sort($list_1, SORT_NUMERIC);
    sort($list_2, SORT_NUMERIC);

    // Calculate absolute distance between each line and add to total distance
    $total_distance = 0;
    for ($i = 0; $i < count($list_1); $i++) {
        $total_distance += abs($list_1[$i] - $list_2[$i]);
    }

    return $total_distance;
}


// Reads and parses the input file into two separate lists
[$list_1, $list_2] = read_input_file('test_input.txt');

// Sorts both lists and calculates the total distance
$total_distance = calculate_total_distance($list_1, $list_2);

// Display results
echo "Total distance: $total_distance\n";

/**
 * Day 1 - Part 2
 *
 * For each number in the left list, count how many times it appears in the right list.
 * Multiply the number by its count and sum these values to get the similarity score.
 */

function calculate_similarity_score($list_1, $list_2) : int
{
    // Calculate individual similarity scores against list_2
    // Note: Sorting is 0(n log n), and counting matches with array_filter is 0(n^2) in the worst case.
    // To-do: Optimize match counting using hash maps
    $similarity_score = 0;
    for ($i = 0; $i < count($list_1); $i++) {
        // Take $i of list_1 and iterate over each value in list_2, passing them to
        // the callback function, then count number of matches.
        $l1_value = $list_1[$i];
        $l2_matches = count(array_filter($list_2, function($x) use ($l1_value) {
            return $x === $l1_value;
        }));

        // Total the individual similarity score
        $similarity_score += $l1_value * $l2_matches;
    }
    return $similarity_score;
}

// Counts occurrences of each value from $list_1 in $list_2 and calculates the similarity score
$similarity_score = calculate_similarity_score($list_1, $list_2);

// Display results
echo "Similarity score: $similarity_score\n";