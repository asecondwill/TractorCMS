<?php

if (strlen($filename) >= $max){
	echo substr($filename,0, (int)($max /2)) . "..." . substr($filename, -5);
}else{
	echo $filename;
}