<?php

$stack = 0;
$pointer = 0;
//Size can be one byte more if operations are done on negative numbers
define('SIZE_LIMIT', PHP_INT_SIZE-1);

function twoPow($pow) {
	return PHP_INT_MIN >> ($pow & 63);
}

function parseInput($input) {
	if (is_string($input)) {
		$input = ord($input);
	}
	if (is_float($input)) {
		$input = (int)$input;
	}
	return is_int($input) && $input >= 0 && $input < 256 ? $input : 0;
}

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

function peek() {
	if (!isEmpty()) {
	global $stack;
	global $pointer;
	return ($stack & (255 << (($pointer-1) * 8))) >> ($pointer-1) * 8;
	} else {
		return 0;
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

function isEmpty() {
	return size() == 0;
}

function size() {
	global $pointer;
	return $pointer;
}

function shift() {
	global $stack;
	global $pointer;
	$shifted = $stack & 255;
	$stack >>= 8;
	$pointer--;
	return $shifted;
}

function unshift($input) {
	global $stack;
	global $pointer;
	if (size() < SIZE_LIMIT) {
		$input = parseInput($input);
		$stack <<= 8;
		$stack |= $input;
		$pointer++;
	}
}

function read($index){
	if ($index < size()) {
		global $stack;
		return ($stack >> ($index * 8)) & 255;
	} else {
		return 0;
	}
}

function write($index, $input) {
	if ($index < SIZE_LIMIT) {
		global $stack;
		global $pointer;
		$input = parseInput();
		
		$mask = ~($input << ($index * 8));
		$stack &= $mask;
		$stack |= $input << ($index * 8);
		if (size() < $index+1) {
			$pointer = $index+1;
		}
	}
}

function reverse() {
	global $stack;
	global $pointer;
	$reversed = 0;
	for ($i = 0; $i < $pointer; $i++) {
		$reversed |= read($i) << ((($pointer-1)-$i) * 8);
	}
	$stack = $reversed;
} 

function bubbleSort($ascending = true) {
	global $stack;
	global $pointer;
	$sorted = 0;
	for ($i = 0; $i < $pointer; $i++) {
		for ($j = 0; $j < ($pointer - $i - 1); $j++) {
			if ((!$ascending && read($j) < read($j+1)) || ($ascending && read($j) > read($j+1))) {
				$stack ^= read($j+1) << ($j*8);
				$stack ^= read($j) << (($j+1)*8);
				$stack ^= read($j+1) << ($j*8);
			}
		}
	}
}

function printOut($asChars = false) {
	global $pointer;
	for ($i = 0; $i < $pointer; $i++) {
		echo $asChars ? chr(read($i)) : read($i) . ' ';
	}
}

function shuffljatka() {
	
}
function permutations() {
	
}

function rotate($turns) {
	global $pointer;
	$direction = (($turns >> (PHP_INT_SIZE*8)-1) << 1) + 1;
	for ($i = 0; $i < $turns * $direction; $i++) {
	    $direction+1 ? push(shift()) : unshift(pop());
	}
}

function bitwiseRotate($turns) {
	
}

// what to use 8th byte for
// pointer
// writing space for one operation

push(65);
push(66);
push(67);
push(68);

echo printOut() . PHP_EOL;
echo printOut(true);