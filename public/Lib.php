<?php
namespace phplib;

/**
 * 通用函数库类
 */
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

    /**
     * 获取当前页面的url
     * @return [type]
     */
    public static function curPageUrl() {
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? 'https://' : 'http://';
        $pageURL = $protocol;
        if ($_SERVER['SERVER_PORT'] != '80')
        {
            $pageURL .= $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . $_SERVER['REQUEST_URI'];
        }
        else
        {
            $pageURL .= $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
        }

        return $pageURL;
    }

    /**
     * 生成一个n位数的随机数字码
     * @param  integer $figures 码位数
     * @return string           码
     */
    public function generateIntergerCode($figures = 8) {
        $code = '';
        $minNum = 1;
        $maxNum = pow(10, (int)$figures) - 1;
        $code = mt_rand($minNum, $maxNum);
        $code = str_pad($code, $figures, '0', STR_PAD_LEFT);// 不够8位左边补齐0

        return $code;
    }
}
