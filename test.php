<?php
set_error_handler("getError", E_ALL);
set_exception_handler('handleException');
function handleException(Exception $e){
	var_dump($e);
}
function getError($errorNo, $message, $filename, $lineNo){
	var_dump($errorNo);
	die();
}

throw new ErrorException();