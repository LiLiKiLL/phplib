<?php
namespace phplib;

/**
 * 通用函数库类
 */
class Lib {
    /**
     * 生成随机字符串
     * @param  integer $length 字符串长度
     * @return string          随机字符串
     */
    public static function createNonceStr($length = 16, $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789') {
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }

        return $str;
    }

    /**
     * 获取当前页面的url
     * @return string 当前页面url
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
     * @return string           码,格式:01234567
     */
    public function generateIntergerCode($figures = 8) {
        $code = '';
        $minNum = 1;
        $maxNum = pow(10, (int)$figures) - 1;
        $code = mt_rand($minNum, $maxNum);
        $code = str_pad($code, $figures, '0', STR_PAD_LEFT);// 不够8位左边补齐0

        return $code;
    }

    /**
     * 根据一个起始时间和一个结束时间，获取这两个时间之间的日期列表
     * @param  string $startTime 开始日期,格式:2016-12-22
     * @param  string $endTime   结束日期,格式:2016-12-31
     * @return array            1.开始日期>结束日期返回空数组;2.返回开始日期至结束日期的所有日期
     */
    public static function getDateListOfPeriod($startTime, $endTime) {
        $startTimeStamp = strtotime($startTime);
        $endTimeStamp = strtotime($endTime);
        $dateList = array();// 存储开始时间到结束时间的所有日期，日期格式：YYYY-MM-DD
        if ($startTimeStamp <= $endTimeStamp) {
            $startTimeDate = date('Y-m-d', $startTimeStamp);
            $endTimeDate = date('Y-m-d', $endTimeDate);
            $tmpDate = $startTimeDate;
            while (strtotime($tmpDate) <= $endTimeStamp) {
                $dateList[] = $tmpDate;
                $tmpDate = date('Y-m-d', strtotime("$tmpDate +1 day"));
            }
        }

        return $dateList;
    }
}
