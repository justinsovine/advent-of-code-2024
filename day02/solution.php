<?php

/**
 * Day 2 - Part 1
 *
 * Determine the number of safe reports based on these rules:
 * 1. The levels in a report must be entirely increasing or entirely decreasing.
 * 2. The difference between any two adjacent levels must be at least 1 and at most 3.
 */

function read_input_file($input_file) : array
{
    // Open file
    $fp = @fopen($input_file, "r");
    if (!$fp) {
        die("Error: Unable to open file " . $input_file. "\n");
    }

    // Extract reports into multidimensional array and convert values to integers
    $reports = [];
    while (($buffer = fgets($fp)) !== false) {
        $reports[] = array_map('intval', explode(" ", $buffer));
    }

    // Check if EOF and close file
    if (!feof($fp)) {
        die("Error: unexpected fgets() fail\n");
    }
    fclose($fp);

    return $reports;
}

function report_checker($report) : bool
{
    $trend = '';
    for ($i = 0; $i < count($report) - 1; $i++) {
        // Increased in value
        if ($report[$i] > $report[$i + 1]) {
            if ($trend == 'decrease') {
                return false; // Not safe!
            }
            $trend = 'increase';

        // Values match
        } elseif ($report[$i] == $report[$i + 1]) {
            // Did not increase at all
            return false; // Not safe!

        // Decreased in value
        } else {
            // Check if trend changed
            if ($trend == 'increase') {
                return false; // Not safe!
            }
            $trend = 'decrease';
        }

        // Check if value change was greater than 3
        if (abs($report[$i] - $report[$i + 1]) > 3) {
            return false; // Not safe!
        }
    }

    return true; // Safe!
}

// Reads and parses the input file into a multidimensional array of reports
$reports = read_input_file(__DIR__ . "/input.txt");

$total_safe_reports = 0;
foreach ($reports as $report) {
    if (report_checker($report)) {
        $total_safe_reports += 1;
    }
}

echo "Total Safe Reports: $total_safe_reports\n";