<?php
ini_set("memory_limit", "10240M");

/**
* Analysis function for graph coloring
*
* @param int $size: Size of the adjacency matrix/set of nodes for graph coloring
* @return float Returns the execution time
*/
function analyse_graph_coloring($size) {
   $adjacency_matrix = generate_complete_adjacency_matrix($size); // Create complete adjacency matrix
   $assignments = array_fill(0, $size, 0); // Create array for color assignments

   $time_start = microtime(true); // Set start time for measurement
   graph_coloring(0, $adjacency_matrix, $assignments, $size); // Execute function
   $time_end = microtime(true); // Set end time for measurement
   return $time_end - $time_start; // Calculate execution time
}
?>
