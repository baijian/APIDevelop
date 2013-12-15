<?php
require 'MsgPackUtil.php';

$data = array(
    'name' => 'baijian',
    'uid' => 5555,
);
$packed = MsgPackUtil::msgpack($data);
file_put_contents('tmp.txt', $packed);
//hexdump -C tmp.txt

$unpacked = MsgPackUtil::msgunpack($packed);
var_dump($unpacked);
