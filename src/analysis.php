<?php
ini_set("memory_limit", "10240M");

/**
* Runtime Analysis: This script performs a performance analysis of various algorithms.
*
* Functions:
* - analyse($target_time, $deviation_time, $number_of_n_values, $repetitions, $n_start_size, $step_size, $type):
*   Starts the runtime analysis with the specified parameters.
*   @param float $target_time: Target time in seconds
*   @param float $deviation_time: Allowed positive and negative deviation from the target time
*   @param int $number_of_n_values: Number of n values to be determined
*   @param int $repetitions: Number of runs for each n value
*   @param int $n_start_size: Starting size of n (recommended for target time of 30 sec.: Matrix multiplication: 665; AVL tree: 1550000; Graph coloring: 13900)
*   @param int $step_size: Size of the steps for each run (recommended for target time of 30 sec.: Matrix multiplication: 1; AVL tree: 2000; Graph coloring: 20)
*   @param string $type: The type of algorithm: "matrix multiplication", "avl-tree" or "graph coloring"
*   @return void
*
* - determine_size($target_time, $deviation_time, $number_of_n_values, $n_start_size, $step_size, $type):
*   Determines the sizes of the n values that can be achieved within the target time.
*   @param float $target_time: Target time in seconds
*   @param float $deviation_time: Allowed positive and negative deviation from the target time
*   @param int $number_of_n_values: Number of n values to be determined
*   @param int $n_start_size: Starting size of n
*   @param int $step_size: Size of the steps for each run
*   @param string $type: The type of algorithm: "matrix multiplication", "avl-tree" or "graph coloring"
*   @return array Array with the determined sizes of the n values
*
* - run_repetitions($number_of_n_values, $n_sizes, $repetitions, $type): Performs the specified number of repetitions for each n value.
*   @param int $number_of_n_values: Number of n values to be determined
*   @param array $n_sizes: Sizes of the n values
*   @param int $repetitions: Number of runs for each n value
*   @param string $type: The type of algorithm: "matrix multiplication", "avl-tree" or "graph coloring"
*   @return array Array with the execution times of the repetitions and the average times
*
* - display_runtime_analysis($target_time, $deviation_time, $number_of_n_values, $repetitions, $n_start_size, $step_size, $type, $n_sizes, $average_execution_times, $total_execution_times):
*   Displays a performance analysis table with the results of the analysis.
*   @param float $target_time: Target time in seconds
*   @param float $deviation_time: Allowed positive and negative deviation from the target time
*   @param int $number_of_n_values: Number of n values to be determined
*   @param int $repetitions: Number of runs for each n value
*   @param int $n_start_size: Starting size of n
*   @param int $step_size: Size of the steps for each run
*   @param string $type: The type of algorithm: "matrix multiplication", "avl-tree" or "graph coloring"
*   @param array $n_sizes: Sizes of the n values
*   @param array $average_execution_times: Average times for each n value
*   @param array $total_execution_times: Execution times of all repetitions
*   @return void
*/

// Analysis function
function analyse($target_time, $deviation_time, $number_of_n_values, $repetitions, $n_start_size, $step_size, $type) {
   echo "Started analysis for $type. Target time: $target_time seconds. Derivations: $deviation_time. Number of n-values: $number_of_n_values. Repetitions: $repetitions. n-start size: $n_start_size. Step-size: $step_size." . PHP_EOL;

   $n_sizes = determine_size($target_time, $deviation_time, $number_of_n_values, $n_start_size, $step_size, $type);
   list($total_execution_times, $average_execution_times) = run_repetitions($number_of_n_values, $n_sizes, $repetitions, $type);
   display_runtime_analysis($target_time, $deviation_time, $number_of_n_values, $repetitions, $n_start_size, $step_size, $type, $n_sizes, $average_execution_times, $total_execution_times);
}

// Determination of n values
function determine_size($target_time, $deviation_time, $number_of_n_values, $n_start_size, $step_size, $type) {
   $n_sizes = array(); // Array to store the determined sizes

   // Loop for the number of values to be determined
   for ($k = 0; $k < $number_of_n_values; $k++) {
       $size = $n_start_size; // Starting size of n

       // Adjust the size until the operation falls within the target time
       while (true) {
           if ($type == "matrix multiplication") {
               $execution_time = analyse_matrix_multiplication($size);
           } elseif ($type == "avl-tree") {
               $execution_time = analyse_avl_tree($size);
           } elseif ($type == "graph coloring") {
               $execution_time = analyse_graph_coloring($size);
           } else {
               trigger_error("Type unknown.", E_USER_ERROR);
           }

           echo "Execution time for a $type of the size $size $execution_time seconds" . PHP_EOL;

           // Check if the execution time falls within the target range
           if ($execution_time >= $target_time - $deviation_time && $execution_time <= $target_time + $deviation_time) {
               break; // Exit the loop if the target time is reached
           } elseif ($execution_time < $target_time - $deviation_time) {
               $size += $step_size; // Increase the size if the execution time is too low
           } else {
               $size -= $step_size; // Decrease the size if the execution time is too high
           }
       }

       // Store the found size
       echo "n-size in target time found! Execution time for a $type of size $size: $execution_time seconds" . PHP_EOL;
       $n_sizes[] = $size;
   }

   return $n_sizes; // Return the array with the determined sizes
}

// Repetition of the calculation for each n value
function run_repetitions($number_of_n_values, $n_sizes, $repetitions, $type) {
   $total_execution_times = array(); // Array to store the execution times for all runs
   $average_execution_times = array(); // Array to store the average times for each n value

   // Runs of operations for each determined size
   for ($k = 0; $k < $number_of_n_values; $k++) {
       $size = $n_sizes[$k];
       $repetition_execution_times = array(); // Array to store the execution times for the current repetition

       // Runs with the determined size to calculate an average
       for ($i = 0; $i < $repetitions; $i++) {
           if ($type == "matrix multiplication") {
               $execution_time = analyse_matrix_multiplication($size);
           } elseif ($type == "avl-tree") {
               $execution_time = analyse_avl_tree($size);
           } elseif ($type == "graph coloring") {
               $execution_time = analyse_graph_coloring($size);
           }
           $repetition_execution_times[] = $execution_time; // Add execution time to the list of repetitions

        }
        
        // Calculate and store the average time
        $average_execution_time = array_sum($repetition_execution_times) / count($repetition_execution_times);
        $average_execution_times[] = $average_execution_time;
        
        $total_execution_times[] = $repetition_execution_times; // Add the execution times of the current repetition to the list of runs
    }
 
    return array($total_execution_times, $average_execution_times); // Return the array with the execution times of the runs and the average times of the runs
}
 
// Output the results as a table
function display_runtime_analysis($target_time, $deviation_time, $number_of_n_values, $repetitions, $n_start_size, $step_size, $type, $n_sizes, $average_execution_times, $total_execution_times) {
    
    // Information about the analysis
    echo PHP_EOL;
    echo "Runtime analysis for $type" . PHP_EOL;
    echo "Target Time: " . number_format($target_time, 4) . " seconds with " . number_format($deviation_time, 4) . " derivation" . PHP_EOL;
    echo "Number of values to be determined: $number_of_n_values" . PHP_EOL;
    echo "Number of iterations for each determined value: $repetitions" . PHP_EOL;
    echo "Start size of n: $n_start_size" . PHP_EOL;
    echo "Step size: $step_size" . PHP_EOL;
    echo PHP_EOL;
    
    echo str_pad("Nr.", 10) . str_pad("n", 15) . str_pad("Average", 30) . "Repetitions" . PHP_EOL; // Headers
    echo str_repeat("-", 150) . PHP_EOL; // Separator line
    
    // Output the values
    for ($k = 0; $k < $number_of_n_values; $k++) {
        echo str_pad(($k + 1), 10) . str_pad($n_sizes[$k], 15) . str_pad(number_format($average_execution_times[$k], 6) . " seconds", 30);
        
        // Output the individual execution times of the runs
        foreach ($total_execution_times[$k] as $run_time) {
            echo number_format($run_time, 2) . str_pad(" sec.", 7);
        }
        
        echo PHP_EOL;
    }
    
    echo str_repeat("-", 150) . PHP_EOL; // Separator line
    
    // Calculate the average n size, based on the average
    $total_n_size = array_sum($n_sizes);
    $average_n_size = $total_n_size / $number_of_n_values;
    echo "Average n-Size: $average_n_size" . PHP_EOL;
}
?>