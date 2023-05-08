<?php 

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
		$input = parseInput($input);
		
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

function seed($numberOfElements) {
	if ($numberOfElements <= SIZE_LIMIT) {
		for ($i = 0; $i <= $numberOfElements; $i++) {
			write($i, rand(0, 255));
		}
	}
}