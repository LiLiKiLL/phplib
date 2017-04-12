<?php
include "Lib.php";

class Test {
    public static function createNonceStr() {
        $str = createNonceStr(8);
        echo $str;
    }

    public static function curPageUrl() {
        $url = curPageUrl();
        echo $url;
    }

    public static function generateIntergerCode() {
        $code = generateIntergerCode(11);
        echo $code;
    }

    public static function getDateListOfPeriod() {
        $startDate = '2017-01-01';
        $endDate = '2017-01-31';
        $period = getDateListOfPeriod($startDate, $endDate);
        var_export($period);
    }

    public static function jsonParamValidate() {
        $param = <<<HEREDOC
        [{"position_desc": "前屏", "position": 1, "count_ry": 2, "count_mall": 2, "fee": 6000 }, {"position_desc": "首页", "position": 2, "count_ry": 2, "count_mall": 2, "fee": 6000 }, {"position_desc": "内页", "position": 3, "count_ry": 2, "count_mall": 2, "fee": 6000 }]
HEREDOC;

        $param = <<<HEREDOC
        {"position_desc": "前屏", "position": 1, "count_ry": 2, "count_mall": 2, "fee": 6000 }
HEREDOC;

        $requiredKeys = ['position', 'count_ry', 'count_mall', 'fee'];

        $result = jsonParamValidate($param, $requiredKeys, 1);

        var_dump($result);
    }

    public static function arrayRebuild() {
        $arr = [
            [
                'type' => 'fruit',
                'name' => 'apple',
            ],
            [
                'type' => 'fruit',
                'name' => 'banana',
            ],
            [
                'type' => 'vegetable',
                'name' => 'tomato',
            ],
            [
                'type' => 'car',
                'name' => 'BMW',
            ],
            [
                'type' => 'car',
                'name' => 'Ford',
            ],
            [
                'type' => 'vegetable',
                'name' => 'potato',
            ],
            [
                'type' => 'vegetable',
                'name' => 'beans',
            ],
        ];
        $arrMap = arrayRebuild($arr, 'type', 'name');
        var_export($arrMap);
    }

    public static function phoneMosaic() {
        $phone = '15062658814';
        $newPhone = phoneMosaic($phone);
        echo $newPhone;
    }

    public static function contentBreif() {
        $content = <<<HEREDOC
这两天，两档娱乐节目火了两个人:一是湖南卫视《歌手》里的民谣歌者赵雷，一是央视《中国诗词大会》里的高中姑娘武亦姝。赵雷一把吉他，轻弹轻吟“和我在成都的街头走一走，直到所有的灯都熄灭了也不停留，你会挽着我的衣袖，我会把手揣进裤兜”，道出了每个人心中藏着的那个人、那座城;武姑娘一袭红衣，轻启朱唇“七月在野，八月在宇，九月在户，十月蟋蟀入我床下”，满足了多少男人“对古代才女的所有幻想”。两个人用自己惊艳的才情圈粉无数。

这真是个最好的年代，千里马无须苦等伯乐，总有合适的平台让他们一鸣惊人。但这也是个充满悲剧色彩的年代，技术会把事物最美好的一面推送到我们面前，直到它不再美好，而悲剧不正是“把美好的事物毁灭给人看”吗？这还是个逻辑混乱的年代，我们的赵雷不管是成为下一个肥肥的晓松，或者是下一个“占据中国乐坛半壁江山”的汪峰，都有着看似不错的未来，而我们的武姑娘，不管是成为下一个咪蒙，还是下一个章泽天，好像都很惨。
HEREDOC;
        $newContent = contentBreif($content, '...', 10);
        echo $newContent;
    }

    public static function sentenceReverse() {
        // $sentence = 'Sometimes one pays most for the things one gets for nothing.';
        $sentence = '有时候一个人为不花钱得到的东西付出的代价最高。';
        $newSentence = sentenceReverse($sentence);
        echo $newSentence;
    }

    public static function tabToSpace() {
        $str = <<<HEREDOC
		床前明月光，
		疑似地上霜。
		举头望明月，
		低头思故乡。
HEREDOC;
		$content = [$str, $str];
        $newContent = tabToSpace($content);
        print_r($newContent);
    }

    public static function getDateParts() {
        $date = date('Y-m-d H:i:s');
        $dateParts = getDateParts($date);
        print_r($dateParts);
    }

    public static function getUniqueId() {
        $id = getUniqueId();
        echo $id;
    }

    public static function weekDate() {
        $date = date('Y-m-d H:i:s');
        $date = '2017-01-05';
        $weekDate = weekDate();

        print_r($weekDate);
    }

    public static function monthDate() {
        $date = date('Y-m-d H:i:s');
        $date = '1993-09-09';
        $monthDate = monthDate($date);

        print_r($monthDate);
    }

    public static function age() {
        $birthDate = '1993-09-09';
        $birthDate = '1993-10-23';
        $age = age($birthDate);

        print_r($age);
    }

    public static function runTime() {
        runTime();
    }

    public static function getDesc() {
        $data = [
            'id' => 1,
            'name' => '测试',
            'status' => 1,
        ];
        $descMap = [
            1 => '正常',
            2 => '已删除',
        ];
        getDesc($data, 'status', $descMap);
        print_r($data);
    }

    public static function timestampsFormat() {
        $data = [
            'create_at' => 1489849359,
            'update_at' => 1489849359,
            'start_time' => 1489849359,
            'end_time' => 1489849359,
        ];
        timestampsFormat($data);
        print_r($data);
    }

    public static function assignArrayDefault() {
        $default = [
            'name' => 'chenxu',
            'age' => 18,
            'sex' => 'male',
        ];
        $array = [
            'name' => 'anyo',
        ];
        $array = assignArrayDefault($array, $default);

        print_r($array);
    }

    public static function getRequestUrl()
    {
        echo getRequestUrl();
    }
}



// Test::createNonceStr();
// Test::curPageUrl();
// Test::generateIntergerCode();
// Test::getDateListOfPeriod();
// Test::jsonParamValidate();
// Test::arrayRebuild();
// Test::phoneMosaic();
// Test::contentBreif();
// Test::sentenceReverse();
// Test::tabToSpace();
// echo strtotime('1969-01-01 00:00:00');// -31536000
// echo date('Y-m-d H:i:s', -31536000);
// Test::getDateParts();
// $birthday = 'March 10, 1975';
// $g = strtotime("$birthday -9 months ago");
// echo $g;
// Test::runtime();
// Test::getUniqueId();
// Test::weekDate();
// Test::monthDate();
// Test::age();
// Test::runTime();
// Test::getDesc();
// Test::timestampsFormat();
// $lc = array('a', 'b' => 'b');// 值为小写字母
// $uc = array('A', 'b' => 'B');// 值为大写字母
// print_r($lc + $uc);
// print_r($uc + $lc);
// Test::assignArrayDefault();
Test::getRequestUrl();
// http://localhost/www_cx/phplib/public/test.php