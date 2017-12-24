<?
if(!headers_sent()){
	include('shopcart.php');
	session_start();
	$cart =& $_SESSION['cart']; // point $cart to session cart.
	if(!is_object($cart)) $cart = new wfCart(); // if $cart ( $_SESSION['cart'] ) isn't an object, make a new cart
}
?>