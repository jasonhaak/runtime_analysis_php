<?php
ini_set("memory_limit", "10240M");

/**
 * Graph Coloring
 *
 * Functions:
 *
 * - generate_complete_adjacency_matrix($size): Generates a complete adjacency matrix for a graph of size $size.
 *   @param int $size: Size of the graph
 *   @return array Two-dimensional matrix representing the fully connected graph
 *
 * - assignment_validation($node, $color, $adjacency_matrix, $assignments): Checks the validity of a color assignment for a node.
 *   @param int $node: Node to be checked
 *   @param int $color: Color to be assigned to the node
 *   @param array $adjacency_matrix: Adjacency matrix of the graph
 *   @param array $assignments: Current color assignments of the nodes
 *   @return bool True if the color assignment is valid, otherwise false
 *
 * - get_min_color($node, $adjacency_matrix, $assignments): Determines the minimum color that can be assigned to a node.
 *   @param int $node: Node to be considered
 *   @param array $adjacency_matrix: Adjacency matrix of the graph
 *   @param array $assignments: Current color assignments of the nodes
 *   @return int Minimum color for the node
 *
 * - graph_coloring($node, $adjacency_matrix, $assignments, $max_number_of_colors): Performs the graph coloring.
 *   @param int $node: Node to be colored
 *   @param array $adjacency_matrix: Adjacency matrix of the graph
 *   @param array $assignments: Current color assignments of the nodes
 *   @param int $max_number_of_colors: Maximum number of colors that can be used in the graph
 *   @return array|null: Final color assignment of the nodes or null if no valid coloring is found
 *
 * - print_graph_coloring($assignments): Prints the node color assignments.
 *   @param array|null $assignments: Color assignments of the nodes or null if no valid coloring is found
 *   @return void
 */

// Generating a complete adjacency matrix
function generate_complete_adjacency_matrix($size) {
    $adjacency_matrix = array_fill(0, $size, array_fill(0, $size, 1));

    // Set the diagonal to 0
    for ($i = 0; $i < $size; $i++) {
        $adjacency_matrix[$i][$i] = 0;
    }

    return $adjacency_matrix;
}

// Checking the validity of the color assignment for a node
function assignment_validation($node, $color, $adjacency_matrix, $assignments)
{
    // Check if adjacent nodes of $node exist with the same $color
    for ($i = 0; $i < $node; $i++) {
        if ($adjacency_matrix[$node][$i] && $assignments[$i] == $color) {
            return false;
        }
    }
    return true;
}

// Determining the number of minimum colors
function get_min_color($node, $adjacency_matrix, $assignments)
{
    $number_of_nodes = count($adjacency_matrix);
    $used_colors = array_fill(0, $number_of_nodes + 1, false); // Array for used colors

    // Iterating over all adjacent nodes to check if a color has already been used
    for ($i = 0; $i < $node; $i++) {
        if ($adjacency_matrix[$node][$i]) {
            $used_colors[$assignments[$i]] = true;
        }
    }

    // Setting the minimum color
    $min_color = 1;
    while ($used_colors[$min_color]) {
        $min_color++;
    }
    return $min_color;
}

// Graph coloring
function graph_coloring($node, $adjacency_matrix, $assignments, $max_number_of_colors)
{
    $number_of_nodes = count($adjacency_matrix);
    $final_assignment = null;

    // Check if all nodes have been colored; termination condition of recursive calls
    if ($node == $number_of_nodes) {
        $final_assignment = $assignments;
        return $final_assignment;
    }

    $min_color = get_min_color($node, $adjacency_matrix, $assignments); // Smallest available color

    // Coloring with validation
    for ($color = $min_color; $color <= $max_number_of_colors; $color++) {
        
        // Checking the possibility of color assignment
        if (assignment_validation($node, $color, $adjacency_matrix, $assignments)) {
            $assignments[$node] = $color; // Coloring the $node with the $color from the for loop
            $final_assignment = graph_coloring($node + 1, $adjacency_matrix, $assignments, max($max_number_of_colors, $color)); // Recursive call of the next $node upon successful coloring
            if ($final_assignment !== null) {
                return $final_assignment; // Returning the final coloring of the recursion (or null if none found)
            }
            $assignments[$node] = 0; // Backtracking
        }
    }

    return $final_assignment; // Returning the final coloring (or null if none found)
}

// Printing the node coloring
function display_graph_coloring($assignments)
{
    if ($assignments !== null) {
        $number_of_nodes = count($assignments);
        echo "Graph Coloring:" . PHP_EOL;
        for ($i = 0; $i < $number_of_nodes; $i++) {
            echo "Node " . ($i + 1) . ": Color " . $assignments[$i] . PHP_EOL;
        }
    } else {
        echo "No valid node colouring found." . PHP_EOL;
    }
}
?>