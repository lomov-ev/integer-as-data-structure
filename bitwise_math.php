<?php 

function twoPow($pow) {
	return PHP_INT_MIN >> ($pow & 63);
}