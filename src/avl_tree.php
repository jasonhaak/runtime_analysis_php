<?php
ini_set("memory_limit", "10240M");

/**
 * AVL Tree
 * 
 * Classes:
 * - AVLNode: Defines a node in the AVL tree with properties value, left and right subtree, and height.
 * - AVLTree: Implements the AVL tree with methods for insertion and traversing nodes.
 * 
 * Methods:
 * - get_height($node): Returns the height of a node.
 *   @param AVLNode|null $node: Node whose height is to be determined
 *   @return int Height of the node
 *
 * - get_balance($node): Returns the balance (height difference between left and right child) of a node.
 *   @param AVLNode|null $node: Node whose balance is to be determined
 *   @return int Balance of the node
 *
 * - update_height($node): Updates the height of a node based on the heights of its children.
 *   @param AVLNode|null $node: Node whose height is to be updated
 *   @return void
 *
 * - rotate_right($node): Performs a right rotation of a subtree with the specified node as root.
 *   @param AVLNode $node: Node to be rotated
 *   @return AVLNode New root node of the subtree after rotation
 *
 * - rotate_left($node): Performs a left rotation of a subtree with the specified node as root.
 *   @param AVLNode $node: Node to be rotated
 *   @return AVLNode New root node of the subtree after rotation
 *
 * - balance_node($node, $value): Balances a node based on the height difference of its children.
 *   @param AVLNode $node: Node to be balanced
 *   @param int $value: Value inserted into the AVL tree
 *   @return AVLNode Balanced node
 *
 * - insert($value): Inserts a new node with the specified value into the AVL tree.
 *   @param int $value: Value to be inserted into the AVL tree
 *   @return void
 *
 * - insert_recursive($node, $value): Recursive function to insert a new node into the AVL tree.
 *   @param AVLNode|null $node: Current node where the value is to be inserted
 *   @param int $value: Value to be inserted into the AVL tree
 *   @return AVLNode Balanced node with the inserted value
 *
 * - insert_array($array): Inserts a series of values from an array into the AVL tree.
 *   @param array $array: Array containing values to be inserted
 *   @return void
 *
 * - inorder_traversal($node): Performs an in-order traversal of the AVL tree and prints the values.
 *   @param AVLNode|null $node: Node being traversed
 *   @return void
 *
 * - display_avl_tree(): Displays the values in the AVL tree
 *   @return void
 */

class AVLNode {
    public $value;
    public $left; // Left subtree
    public $right; // Right subtree
    public $height; // Height

    // Constructor for creating the node
    function __construct($value) {
        $this->value = $value;
        $this->left = null;
        $this->right = null;
        $this->height = 1;
    }
}

class AVLTree {
    public $root; // Declare root

    // Determine the height of a node
    function get_height($node) {
        if ($node == null) {
            return 0;
        }
        return $node->height;
    }

    // Determine the height difference between the left and right child of a node
    function get_balance($node) {
        if ($node == null) {
            return 0;
        }
        return $this->get_height($node->left) - $this->get_height($node->right);
    }

    // Update the height of a node
    function update_height($node) {
        if ($node == null) {
            return;
        }
        $node->height = max($this->get_height($node->left), $this->get_height($node->right)) + 1;
    }


    // Right rotation of a subtree with the specified node as root
    function rotate_right($node) {
        $left = $node->left;
        $temp = $left->right;

        // Perform rotation
        $left->right = $node;
        $node->left = $temp;

        // Update heights
        $this->update_height($node);
        $this->update_height($left);

        return $left;
    }

    // Left rotation of a subtree with the specified node as root
    function rotate_left($node) {
        $right = $node->right;
        $temp = $right->left;

        // Perform rotation
        $right->left = $node;
        $node->right = $temp;

        // Update heights
        $this->update_height($node);
        $this->update_height($right);

        return $right;
    }

    // Balance a node
    function balance_node($node, $value) {

        // Balance the tree
        $balance = $this->get_balance($node);

        // Case 1: Left Rotation
        if ($balance > 1 && $value < $node->left->value) {
            return $this->rotate_right($node);
        }

        // Case 2: Right Rotation
        if ($balance < -1 && $value > $node->right->value) {
            return $this->rotate_left($node);
        }

        // Case 3: Left-right Rotation
        if ($balance > 1 && $value > $node->left->value) {
            $node->left = $this->rotate_left($node->left);
            return $this->rotate_right($node);
        }

        // Case 4: Right-left Rotation
        if ($balance < -1 && $value < $node->right->value) {
            $node->right = $this->rotate_right($node->right);
            return $this->rotate_left($node);
        }

        return $node;
    }

    // Insert a new node into the AVL tree
    function insert($value) {
        $this->root = $this->insert_recursive($this->root, $value);
    }

    // Recursive insertion of a new node
    function insert_recursive($node, $value) {
        
        // Insert into empty tree
        if ($node == null) {
            return new AVLNode($value);
        }

        // Insertion position
        // If value of new node < value of current node: Traverse left subtree
        if ($value < $node->value) {
            $node->left = $this->insert_recursive($node->left, $value); // Traverse left subtree
        
        // If value of new node > value of current node: Traverse right subtree
        } elseif ($value > $node->value) {
            $node->right = $this->insert_recursive($node->right, $value);
        
        // Otherwise: Error message
        } else {
            trigger_error("Insertion of the value not possible. The value $value already exists in the AVL tree.", E_USER_ERROR);
        }

        // Update height
        $this->update_height($node);

        // Balance AVL tree
        return $this->balance_node($node, $value);
    }

    // Insert an array of values
    function insert_array($array) {
        foreach ($array as $value) {
            $this->insert($value);
        }
    }

    // Traverse the AVL tree in-order
    function inorder_traversal($node) {
        if ($node != null) {
            $this->inorder_traversal($node->left);
            echo $node->value . " ";
            $this->inorder_traversal($node->right);
        }
    }

    // Starting point for tree traversal
    function display_avl_tree() {
        echo "Inorder traversal of the AVL-tree: ";
        $this->inorder_traversal($this->root);
    }
}
?>
