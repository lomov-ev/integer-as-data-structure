<?php

include 'bitwise_math.php';
include 'helpers.php';
include 'array_operations.php';

$stack = 0;
$pointer = 0;
define('SIZE_LIMIT', PHP_INT_SIZE-1);

function push($input) {
	if (size() < SIZE_LIMIT) {
		$input = parseInput($input);
		global $stack;
		global $pointer;
		$stack ^= 2**($pointer * 8) - 1;
		$prep = (~$input & 255) << $pointer * 8;
		$stack |= $prep;
		$pointer++;
		$stack ^= 2**($pointer * 8) - 1;
	}
}

function pop() {
	if (!isEmpty()) {
		global $stack;
		global $pointer;
		$top = peek();
		$mask = 255 << (($pointer) * 8);
		$stack -= $mask;
		$pointer--;
		return $top;
	} else {
		return 0;
	}
}

function peek() {
	if (!isEmpty()) {
	global $stack;
	global $pointer;
	return ($stack & (255 << (($pointer-1) * 8))) >> ($pointer-1) * 8;
	} else {
		return 0;
	}
}

push(65);
push(66);
push(67);
push(68);

seed(6);

echo printOut() . PHP_EOL;
echo printOut(true);