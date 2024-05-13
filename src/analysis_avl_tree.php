<?php
ini_set("memory_limit", "10240M");

/**
* Analysis function for the AVL tree
*
* @param int $size: Size of the array for the AVL tree
* @return float Returns the execution time
*/
function analyse_avl_tree($size) {
   $avl_tree = new AVLTree(); // Create AVL tree
   $avl_array = range(1, $size); // Create array for AVL insertion

   $time_start = microtime(true); // Set start time for measurement
   $avl_tree->insert_array($avl_array); // Execute function

   $time_end = microtime(true); // Set end time for measurement
   return $time_end - $time_start; // Calculate execution time
}
?>