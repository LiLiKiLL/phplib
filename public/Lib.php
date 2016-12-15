<?php
namespace phplib;

class Lib {
    /**
     * 生成随机字符串
     * @param  integer $length 字符串长度
     * @return [type]          [description]
     */
    public static function createNonceStr($length = 16) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }
}
