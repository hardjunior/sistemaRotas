<?php

function view($arquivo, $array = null)
{
	$arquivo = __DIR__."\\".$arquivo;
	if (!is_null($array)) {
		foreach ($array as $var => $value) {
			${$var} = $value;
		}
	}
	ob_start();
	include "{$arquivo}.php";
	ob_end_flush();
}