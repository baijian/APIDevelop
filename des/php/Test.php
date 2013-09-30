<?php
require 'DESUtils.php';

$key = "abcdefgh";  
$input = "helloworld";  
$crypt = new DESUtils($key);  
echo "Encode: " . $crypt->encrypt($input)."\n";  
echo "Decode: " . $crypt->decrypt($crypt->encrypt($input)) . "\n"; 
