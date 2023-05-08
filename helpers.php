<?php 

function parseInput($input) {
	if (is_string($input)) {
		$input = ord($input);
	}
	if (is_float($input)) {
		$input = (int)$input;
	}
	return is_int($input) && $input >= 0 && $input < 256 ? $input : 0;
}

function isEmpty() {
	return size() == 0;
}

function size() {
	global $pointer;
	return $pointer;
}

function printOut($asChars = false) {
	global $pointer;
	for ($i = 0; $i < $pointer; $i++) {
		echo $asChars ? chr(read($i)) : read($i) . ' ';
	}
}

function bitwiseRotate($turns) {
	
}

