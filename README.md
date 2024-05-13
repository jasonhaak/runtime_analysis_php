# Runtime Analysis for AVL-Tree-Insertion, Graph Coloring and Matrix Multiplication
This runtime analysis environment allows to analyse the runtime of an AVL tree, graph colouring and matrix multiplication. The runtime environment  can be used independently of the given algorithms.

The following questions can be anwsered with this implemetation: 
1. What problem sizes `n` exist for a runtime of `target_time` seconds when multiplying two `n x n` matrices in PHP?
2. What problem sizes `n` exist for a runtime of `target_time` seconds when successively inserting numbers in the interval `[1, n]` into an AVL tree in PHP?
3. What problem sizes `n` exist for a runtime of `target_time` seconds when graph coloring a complete graph with `n` nodes and `n` colors with backtracking in PHP?

## Installation
The runtime measurement can be started with the file `config.php`.

## Usage and explanation
The runtime measurement is performed by the `analyse` function using time measurement as a basis. For this, the start time before the function begins and the end time after the function is completed are measured in microseconds using `microtime(true)`. These values are subtracted from each other, and the execution time is printed at the end.

```php
$time_start = microtime(true); // Start time for execution measurement
foo(); // Execute function
$time_end = microtime(true); // End time for execution measurement
$execution_time = ($time_end - $time_start); // Calculate execution time
```

The runtime measurement is embedded in the `determine_size` function, which determines the size `n` for a specific target time `$target_time` for a given operation. The function uses a loop to iteratively adjust the preliminary size `n` of the dataset positively or negatively until the operation falls within the execution time. A tolerance range can be set for the target time, defined by specifying the deviation `$derivation_time`. For the start of the execution, a start size `$n_start_size` and the step size `$step_size` for a positive or negative change in the preliminary size `n` can be set. Once the operation falls within the allowed execution time, the size `n` of the dataset is stored in the `$n_sizes` array. The loop continues until the number of `n` values `$number_of_n_values` to be determined is reached. The result of the `determine_size` function is an array `$n_sizes` containing the determined sizes `n`.

To verify the determined sizes `n`, the average time for a number of executions of the operation with the sizes `n` can be calculated. This is made possible by the `run_repetitions` function, which re-executes the operation for the given `n` values in `$n_sizes`. The number of desired executions is passed through the `$repetitions` variable. The function iterates over each determined value `n` in `$n_sizes` and executes the operation `$repetitions` times for this value. For each calculation, the execution time is measured and stored in `$repetition_execution_times`. After the repetitions are completed, the average execution times `$average_execution_times` and the execution times for each repetition `$total_execution_times` are calculated and returned.

The `display_runtime_analysis` function outputs all specified parameters as well as the average execution time and the execution times of all repetitions for each `n` value.

The operation performed in the runtime analysis is determined by the variable `$type`. Accordingly, the function `analyse_matrix_multiplication` is called for matrix multiplication, `analyse_avl_tree` for the AVL tree or the function `analyse_graph_coloring` for graph coloring. The individual functions contain instructions for measuring the respective operation.

In the context of the runtime analysis, a higher amount of working memory was particularly required for graph coloring, which necessitated an adjustment of the working memory limitation. The change in the PHP files was made using the instruction `ini_set("memory_limit", "10240M")`. This instruction increased the standardized size of the working memory in all PHP files used from 2048 megabytes to 10240 megabytes.

### Matrix Multiplication Analysis
The runtime analysis of matrix multiplication is implemented by the `analyse_matrix_multiplication` function. In this function, two matrices of size `n` are created and filled with random numbers between 1 and 10. The time measurement begins before executing the `multiply_matrices($matrix_1, $matrix_2)` function, which multiplies the two matrices together. The time measurement ends after executing this function.

### AVL Tree Analysis
The runtime analysis of the AVL tree is implemented by the `analyse_avl_tree` function. First, a new, empty AVL tree is created. Then, an array with numbers from 1 to `n` is generated. The time measurement starts immediately before executing the `$avl_tree->insert_array($avl_array)` function, which successively fills the AVL tree with the numbers from the array. The time measurement ends after executing this function.

### Graph Coloring Analysis
The `analyse_graph_coloring` function implements the runtime analysis of graph coloring. In this function, an adjacency matrix of size `n` is created, representing the complete graph. Additionally, an array of length `n` is created for color assignments. The `graph_coloring(0, $adjacency_matrix, $assignments, $size)` function colors the individual nodes of the graph from the adjacency matrix. The number of colors corresponds to the size `n` and, therefore, the number of nodes. The time measurement starts immediately before executing this function and ends after its completion.

---
## Version History
### 1.0 (2024-05-13)
- First public release

---
## Author & Licence
This code was written by Jason Haak and is licensed under the MIT licence.

---