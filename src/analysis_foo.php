<?php
ini_set("memory_limit", "10240M");

/**
* Analysis function for a example function
*
* @param int $size: Size of the numbers to be multiplied
* @return float Returns the execution time
*/
function analyse_foo($size) {
   $time_start = microtime(true); // Set start time for measurement
   foo($size); // Execute function
   $time_end = microtime(true); // Set end time for measurement
   return $time_end - $time_start; // Calculate execution time
}
?>