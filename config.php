<?php
ini_set("memory_limit", "10240M");

/**
* Configuration file: Main function to perform the analysis for a specific algorithm
*
* @param float $target_time: Target time in seconds
* @param float $deviation_time: Allowed positive and negative deviation from the target time
* @param int $number_of_n_values: Number of n values to be determined
* @param int $repetitions: Number of runs for each n value
* @param int $n_start_size: Starting size of n (recommended for target time of 30 sec.: Matrix multiplication: 665; AVL tree: 1550000; Graph coloring: 13900)
* @param int $step_size: Size of the steps for each run (recommended for target time of 30 sec.: Matrix multiplication: 1; AVL tree: 2000; Graph coloring: 50)
* @param string $type: The type of algorithm: "matrix multiplication", "avl-tree" or "graph coloring"
* @return void
*/

require __DIR__ . "/src/analysis.php";
require __DIR__ . "/src/avl_tree.php";
require __DIR__ . "/src/graph_coloring.php";
require __DIR__ . "/src/matrix_multiplication.php";
require __DIR__ . "/src/analysis_avl_tree.php";
require __DIR__ . "/src/analysis_graph_coloring.php";
require __DIR__ . "/src/analysis_matrix_multiplication.php";

$target_time = 0.1;
$deviation_time = 0.01;
$number_of_n_values = 5;
$repetitions = 5;
$n_start_size = 100;
$step_size = 1;
$type = "matrix multiplication";

$n_sizes = array(); // Array to store the determined matrix sizes
$average_execution_times = array(); // Array to store the average execution times
$total_execution_times = array(); // Array to store all execution times of the runs

analyse($target_time, $deviation_time, $number_of_n_values, $repetitions, $n_start_size, $step_size, $type); // Analysis function
?>