<?php
ini_set("memory_limit", "10240M");

/**
* Analysis function for matrix multiplication
*
* @param int $size: Size of the matrices for matrix multiplication
* @return float Returns the execution time
*/
function analyse_matrix_multiplication($size) {
   $matrix_1 = create_matrix($size, $size); // Create first matrix
   $matrix_2 = create_matrix($size, $size); // Create second matrix

   $time_start = microtime(true); // Set start time for measurement
   multiply_matrices($matrix_1, $matrix_2); // Execute function

   $time_end = microtime(true); // Set end time for measurement
   return $time_end - $time_start; // Calculate execution time
}
?>