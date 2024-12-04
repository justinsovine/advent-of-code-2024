<?php

/**
 * Day 3 - Part 1
 *
 * ...
 *
 */

function read_input_file($input_file) : array
{
    // Open file
    $fp = @fopen($input_file, "r");
    if (!$fp) {
        die("Error: Unable to open file " . $input_file. "\n");
    }

    // Extract each line of memory into an array of strings
    $memory = [];
    while (($buffer = fgets($fp)) !== false) {
        $memory[] = $buffer;
    }

    // Check if EOF and close file
    if (!feof($fp)) {
        die("Error: unexpected fgets() fail\n");
    }
    fclose($fp);

    return $memory;
}

function extract_functions($corrupted_memory) : array
{
    $match_list = [];
    foreach ($corrupted_memory as $line) {
        preg_match_all(MATCH_MUL_DO_OR_DONT, $line, $match_list[]);
    }
    return $match_list;
}

function extract_and_multiply($match_list) : int
{
    // This triple foreach is heinous, I know
    $result = 0;
    $do = true;
    foreach ($match_list as $matches) {
        foreach ($matches as $operations) {
            foreach ($operations as $operation) {
                if ($operation == "don't()") {
                    $do = false;
                } elseif ($operation == "do()") {
                    $do = true;
                } else {
                    if (!$do) { continue; }
                    preg_match_all(MATCH_XY, $operation, $xy);
                    $num = explode(',', $xy[0][0]);
                    $result += $num[0] * $num[1];
                }
            }
        }
    }
    return $result;
}

const MATCH_MUL = '#mul\([0-9]+\,[0-9]+\)#'; // Matches mul(x,y)
const MATCH_XY = '#[0-9]+\,[0-9]+#'; // Matches x,y
const MATCH_MUL_DO_OR_DONT = "#mul\([0-9]+\,[0-9]+\)|do\(\)|don't\(\)#"; // Matches mul(), do(), or don't()

// Reads the input file into an array of strings
$corrupted_memory = read_input_file(__DIR__ . "/input.txt");

// Extract the correct mul(x,y) codes
$match_list = extract_functions($corrupted_memory);

// Multiply results
$result = extract_and_multiply($match_list);

echo "Result: " . $result . "\n";

/**
 * Day 3 - Part 2
 *
 * ...
 *
 */