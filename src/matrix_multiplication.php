<?php
ini_set("memory_limit", "10240M");

/**
 * Matrix Multiplication
 * 
 * Functions:
 * - multiply_matrices($matrix_1, $matrix_2): Performs matrix multiplication for two given matrices.
 *   @param array $matrix_1: The first matrix as a two-dimensional numerical array
 *   @param array $matrix_2: The second matrix as a two-dimensional numerical array
 *   @return array The result of matrix multiplication as a two-dimensional numerical array
 *
 * - create_matrix($rows, $cols): Creates a matrix with the specified rows and columns and fills it with random values between 1 and 10.
 *   @param int $rows: The number of rows of the matrix to be created
 *   @param int $cols: The number of columns of the matrix to be created
 *   @return array The created matrix as a two-dimensional numerical array
 *
 * - display_matrix($matrix): Displays the specified matrix on the standard output.
 *   @param array $matrix: The matrix to be displayed as a two-dimensional numerical array
 *   @return void
 */

// Matrix multiplication
function multiply_matrices($matrix_1, $matrix_2) {
    $rows_1 = count($matrix_1);
    $cols_1 = count($matrix_1[0]);
    $rows_2 = count($matrix_2);
    $cols_2 = count($matrix_2[0]);

    // Check matrices if the size is suitable for matrix multiplication
    if ($cols_1 != $rows_2 || $cols_2 != $rows_1) {
        trigger_error("Matrix multiplication not possible. The number of columns in matrix 1 must be equal to the number of rows in matrix 2.", E_USER_ERROR);
    }

    // Initialize result matrix
    $result = array_fill(0, $rows_1, array_fill(0, $cols_2, 0));

    // Perform matrix multiplication
    for ($i = 0; $i < $rows_1; $i++) {
        for ($j = 0; $j < $cols_2; $j++) {
            for ($k = 0; $k < $cols_1; $k++) {
                $result[$i][$j] += $matrix_1[$i][$k] * $matrix_2[$k][$j];
            }
        }
    }

    return $result; // Return result
}

// Matrix creation
function create_matrix($rows, $cols) {
    $matrix = array_fill(0, $rows, array_fill(0, $cols, 0)); // Fill matrix with 0s

    // Generate random values for matrix elements
    for ($i = 0; $i < $rows; $i++) {
        for ($j = 0; $j < $cols; $j++) {
            $matrix[$i][$j] = mt_rand(1, 10); // Insert random numbers between 1 and 10
        }
    }

    return $matrix; // Return result
}

// Display matrix
function display_matrix($matrix) {
    $rows = count($matrix);
    $cols = count($matrix[0]);

    echo "Matrix: " . PHP_EOL;
    for ($i = 0; $i < $rows; $i++) {
        for ($j = 0; $j < $cols; $j++) {
            echo $matrix[$i][$j] . " ";
        }
        
        echo PHP_EOL;
    }
}
?>