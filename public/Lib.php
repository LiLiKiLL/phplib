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

    /**
     * 将制表符转换为空格
     * @param  mixed  $content  可以是字符串或数组
     * @param  integer $tabSpace 一个制表符代表的空格数
     * @return mixed            [description]
     */
    public static function tabToSpace($content, $tabSpace = 4) {
        $pattern = '/[\t]/';
        $replace = str_repeat(' ', $tabSpace);
        // 使用正则替换，可以转换数组
        $newContent = preg_replace($pattern, $replace, $content);
        // 使用字符串替换，只支持字符串
        // $newContent = str_replace("\t", $replace, $content);

        return $newContent;
    }

    /**
     * 获取YYYY-MM-DD HH:II:SS格式的所有日期时间
     * @param  [type] $date [description]
     * @return [type]       [description]
     */
    public static function getDateParts($date) {
        preg_match('/(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})/', $date, $dateParts);
        // 使用substr函数
        // $dateParts[0] = $date;
        // $dateParts[1] = substr($date, 0, 4);
        // $dateParts[2] = substr($date, 5, 2);
        // $dateParts[3] = substr($date, 8, 2);
        // $dateParts[4] = substr($date, 11, 2);
        // $dateParts[5] = substr($date, 14, 2);
        // $dateParts[6] = substr($date, 17, 2);

        return $dateParts;
    }

    /**
     * 根据Unix微秒时间戳和进程ID生成唯一ID（不可靠，有极小或不等于零的概率下同一进程会在同一微秒内调用microtime()）
     * @return [type] [description]
     */
    public static function getUniqueId() {
        list($microSeconds, $seconds) = explode(' ', microtime());
        $id = $seconds.$microSeconds.getmypid();

        return $id;
    }

    /**
     * 枚举某个日期的该星期所有日期，下标0开始，周日为第一天
     * @param  string $date YYYY-MM-DD [HH:II:SS]格式的日期，不传则为当前日期
     * @return array       以星期（0-6，0为星期日）为下标的，日期为值的数组
     */
    public static function weekDate($date = '') {
        $date = empty($date) ? date('Y-m-d H:i:s') : $date;
        // 获取该日期的星期
        $time = strtotime($date);
        $weekDay = strftime('%w', $time);// 0-6，0表示星期日
        // 得到本周第一天的时间戳，周日为第一天
        $startDay = $time - (86400 * $weekDay);
        $weekDate = array();
        for ($i = 0;$i < 7; $i++) {
            $weekDate[$i] = date('Y-m-d', $startDay + 86400 * $i);
        }

        return $weekDate;
    }

    /**
     * 枚举某个日期所在月的每一天
     * @param  string $date YYYY-MM-DD [HH:II:SS]格式的日期
     * @return array       该月日期枚举数组
     */
    public static function monthDate($date = '') {
        $date = empty($date) ? date('Y-m-d H:i:s') : $date;
        // 获取该日期是几月
        $time = strtotime($date);
        $month = strftime('%m', $time);// 01-12
        $year = strftime('%Y', $time);// YYYY
        // 获取本月第一天午夜的Unix时间戳
        $monthStart = mktime(0, 0, 0, $month, 1, $year);
        // 获取下月第一天午夜的Unix时间戳
        $monthEnd = mktime(0, 0, 0, $month + 1, 1, $year);
        $day = $monthStart;
        $monthDate = array();
        while ($day < $monthEnd) {
            $monthDate[] = date('Y-m-d', $day);
            $day += 86400;
        }

        return $monthDate;
    }

    /**
     * 计算一个人的年龄，精确到天
     * @param  [type] $birthDate [description]
     * @return [type]            [description]
     */
    public static function age($birthDate) {
        // 计算出生天数
        $now = time();
        $nowYear = strftime('%Y', $now);
        $birthTime = strtotime($birthDate);
        $birthYear = strftime('%Y', $birthTime);

        $second = $now - $birthTime;// 出生到现在秒数 = 现在时间戳 - 生日时间戳
        $minute = ceil($second / 60);// 出生到现在分钟数
        $hour = ceil($second / 3600);// 出生到现在小时数
        $day = ceil($second / 86400);// 出生到现在天数
        $year = $nowYear - $birthYear;// 岁数 = 现在年份 - 出生年份

        // 具体到年月日时分秒
        


        return $age;
    }

    public static function runTime() {
        $t1 = microtime(true);
        // ... 执行代码 ...
        for ($i = 1; $i <= 100000; $i++) {
            $str = md5('abcde');
        }
        $t2 = microtime(true);
        $t = round($t2 - $t1, 3);
        echo '耗时'. $t .'秒';
    }

    /**
     * 将数据库中的数字表示的字段，添加一个中文描述字段，方便debug和查看接口信息
     * 比如：数据库中status字段用1表示正常，2表示已删除，则可以通过本函数，给数据添加一个status_desc的中文描述字段
     * 原$data ：['status' => 1]
     * 处理后$data：['status' => 1, 'status_desc' => '正常']
     * 调用示例：Lib::getDesc(['status' => 1], 'status', [1 => '正常', 2 => '已删除'])
     * @param  array &$data      要转换的数据
     * @param  string $originKey  要添加中文描述的原始key
     * @param  array $descMap    数字描述map数组
     * @return [type]             若$data中不存在$originKey字段，则返回原$data，若$descMap不存在$orginKey对应值的Map，则返回描述值为空字符串
     */
    public static function getDesc(&$data, $originKey, $descMap) {
        $newDescKey = $originKey . '_desc';
        if (isset($data[$originKey])) {
            $data[$newDescKey] = isset($descMap[$data[$originKey]]) ? $descMap[$data[$originKey]] : '';
        }
    }

    /**
     * 格式化时间戳
     * 调用示例：Lib::timestampFormat(['create_at' => 1122991787, 'update_at' => 126767899], ['create_at', 'update_at'], 'Y-m-d H:i:s')
     * @param  array &$data      要格式化的数据
     * @param  array $keys       要格式化的字段
     * @param  string $format    格式
     * @return [type]             [description]
     */
    public static function timestampsFormat(&$data, $keys = ['create_at', 'update_at', 'start_time', 'end_time'], $format = 'Y-m-d H:i:s') {
        foreach ($keys as $key) {
            if (isset($data[$key])) {
                $data[$key] = date($format, $data[$key]);
            }
        }
    }
}
