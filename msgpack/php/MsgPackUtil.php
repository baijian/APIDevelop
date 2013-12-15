<?php
class MsgPackUtil {

    public static function msgpack($data) {
        return msgpack_pack($data);
    }

    public static function msgunpack($msg) {
        return msgpack_unpack($msg);
    }
}
