<?php
namespace phplib;

use phplib\Lib as Lib;
include "Lib.php";

class Test {
    public static function createNonceStr() {
        $str = Lib::createNonceStr(8);
        echo $str;
    }

    public static function curPageUrl() {
        $url = Lib::curPageUrl();
        echo $url;
    }

    public static function generateIntergerCode() {
        $code = Lib::generateIntergerCode(11);
        echo $code;
    }

    public static function getDateListOfPeriod() {
        $startDate = '2017-01-01';
        $endDate = '2017-01-31';
        $period = Lib::getDateListOfPeriod($startDate, $endDate);
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

        $result = Lib::jsonParamValidate($param, $requiredKeys, 1);

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
        $arrMap = Lib::arrayRebuild($arr, 'type', 'name');
        var_export($arrMap);
    }
}

// Test::createNonceStr();
// Test::curPageUrl();
// Test::generateIntergerCode();
// Test::getDateListOfPeriod();
// Test::jsonParamValidate();
Test::arrayRebuild();