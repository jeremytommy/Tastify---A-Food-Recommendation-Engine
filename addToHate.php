<?php
session_start();

// get the product id
$id = isset($_GET['id']) ? $_GET['id'] : "";
$name = isset($_GET['name']) ? $_GET['name'] : "";

if(!isset($_SESSION['hate'])) {
	$_SESSION['hate'] = array();
}

// check if the item is in the array, if it is, do not add
if(in_array($id, $_SESSION['hate'])){
	// redirect to product list and tell the user it was added to cart
	header('Location: initialize2.php?action=exists&id' . $id . '&name=' . $name);
}

// else, add the item to the array
else{
	array_push($_SESSION['hate'], $id);
	
	// redirect to product list and tell the user it was added to cart
	header('Location: initialize2.php?action=add&id' . $id . '&name=' . $name);
}
?>