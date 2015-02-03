<?php
session_start();

// get the product id
$id = isset($_GET['id']) ? $_GET['id'] : "";
$name = isset($_GET['name']) ? $_GET['name'] : "";

/* 
 * check if the 'cart' session array was created
 * if it is NOT, create the 'cart' session array
 */
if(!isset($_SESSION['cart'])){
	$_SESSION['cart'] = array();
}

// remove the item from the array
$_SESSION['cart'] = array_diff($_SESSION['cart'], array($id));

// redirect to product list and tell the user it was added to cart
header('Location: member.php?action=removed&id=' . $id . '&name=' . $name);
?>