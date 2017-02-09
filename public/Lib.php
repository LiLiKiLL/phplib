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
        $str = '';
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
     * 生成一个n位数的随机数字码,n<=11
     * @param  integer $figures 码位数
     * @return string           码,格式:01234567
     */
    public static function generateIntergerCode($figures = 8) {
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
            $endTimeDate = date('Y-m-d', $endTimeStamp);
            $tmpDate = $startTimeDate;
            while (strtotime($tmpDate) <= $endTimeStamp) {
                $dateList[] = $tmpDate;
                $tmpDate = date('Y-m-d', strtotime("$tmpDate +1 day"));
            }
        }

        return $dateList;
    }

    /**
     * json格式参数的字段验证，必须为json且要有必须字段
     * @param  mixed      $param        要验证的参数
     * @param  array $requiredKeys 必须的字段
     * @param  integer $level 参数数组维度
     * @return boolean
     */
    public static function jsonParamValidate($param, $requiredKeys = array(), $level = 1) {
        $result = true;
        if ($jsonParam = json_decode($param, true)) {
            // 参数为一维数组
            if (1 == $level) {
                $keys = array_keys($jsonParam);
                // 缺失的键
                $missKeys = array_diff($requiredKeys, $keys);
                if (! empty($missKeys)) {
                    $result = false;
                }
            }
            // 参数为二维数组
            else if (2 == $level) {
                foreach ($jsonParam as $k => $v) {
                    $keys = array_keys($v);
                    $missKeys = array_diff($requiredKeys, $keys);
                    if (! empty($missKeys)) {
                        $result = false;
                        break;
                    }
                }
            }
        }
        else {
            $result = false;
        }

        return $result;
    }

    /**
     * 将二维数组重构为一维数组
     * @param  array $data         要重构的数组
     * @param  string $keyKeyName   作为键的键名
     * @param  string $valueKeyName 作为值的键名
     * @return array               处理后的一维键=>值数组
     */
    public static function arrayRebuild($data, $keyKeyName, $valueKeyName) {
        $result = array();
        foreach ($data as $k => $v) {
            $result[$v[$keyKeyName]][] = $v[$valueKeyName];
        }

        return $result;
    }

    /**
     * 将手机号的中间四位以马赛克字符代替
     * @param  string $phone   手机号码
     * @param  string $replace 替换字符-4位
     * @return string          替换后的手机号
     */
    public static function phoneMosaic($phone, $replace = '****') {
        $newPhone = substr_replace($phone, $replace, 3, 4);

        return $newPhone;
    }

    /**
     * 显示文章的简要信息，例如只显示文章的前140个字符作为链接，其余内容用省略号表示
     * @param  string  $content  要简明显示的内容
     * @param  string  $replace  省略替代符
     * @param  integer $length   显示字符数
     * @param  string  $encoding 字符编码
     * @return string            处理后的字符串
     */
    public static function contentBreif($content, $replace = '...', $length = 140, $encoding = 'utf-8') {
        $newContent = mb_substr($content, 0, $length, $encoding) . $replace;

        return $newContent;
    }

    /**
     * 反念句子，针对英文，中文不适用
     * @param  string $sentence  [description]
     * @param  string $delimiter 不可为空字符串，为空explode返回false
     * @return string            [description]
     */
    public static function enSentenceReverse($sentence, $delimiter = ' ') {
        $newSentence = implode($delimiter, array_reverse(explode($delimiter, $sentence)));

        return $newSentence;
    }

    /**
     * 反念句子，各种编码都适用
     * @param  string $sentence [description]
     * @param  string $encoding 字符编码
     * @return string           [description]
     */
    public static function sentenceReverse($sentence, $encoding = 'utf-8') {
        $len = mb_strlen($sentence, $encoding);
        for ($i = 0; $i < $len; $i++) {
            $arr[] = mb_substr($sentence, $i, 1, 'utf-8');
        }
        $newSentence = implode('', array_reverse($arr));

        return $newSentence;
    }
}
