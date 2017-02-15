<?php
    $month = isset($_GET['month']) ? intval($_GET['month']) : date('m');
    $year = isset($_GET['year']) ? intval($_GET['year']) : date('Y');
    $opts = '';
    // 设置默认选项
    if (! is_array($opts)) {
        $opts = array();
    }
    if (! isset($opts['id'])) {
        $opts['id'] = 'calendar';
    }
    if (! isset($opts['month_link'])) {
        $opts['month_link'] = <<<HEREDOC
<a href="{$_SERVER['PHP_SELF']}?month=%d&amp;year=%d">%s</a>
HEREDOC;
    }
    $classes = array();
    foreach (['prev', 'month', 'next', 'weekday', 'blank', 'day', 'today'] as $class) {
        if (isset($opts[$class . '_class'])) {
            $classes[$class] = htmlentities($opts[$class . '_class']);
        }
        else {
            $classes[$class] = $class;
        }
    }
    list($this_year, $this_month, $this_day) = explode(',', strftime('%Y,%m,%d'));
    $day_highlight = (($this_month == $month)) && (($this_year == $year));

    list($prev_year, $prev_month) = explode(',', strftime('%Y,%m', mktime(0, 0, 0, $month - 1, 1, $year)));
    $prev_month_link = sprintf($opts['month_link'], $prev_month, $prev_year, '&laquo;');

    list($next_year, $next_month) = explode(',', strftime('%Y,%m', mktime(0, 0, 0, $month + 1, 1, $year)));
    $next_month_link = sprintf($opts['month_link'], $next_month, $next_year, '&raquo;');
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>日历</title>
        <style type="text/css">
            tr, td {
                border: 1px solid black;
            }
            .prev {
                text-align: left;
            }
            .next {
                text-align: right;
            }
            .day, .month, .weekday {
                text-align: center;
            }
            .today {
                background: yellow;
            }
            .blank {

            }
        </style>
    </head>
    <body>
        <table id="<?php echo htmlentities($opts['id']); ?>">
            <tr>
                <td class="<?php echo $classes['prev']; ?>">
                    <?php echo $prev_month_link; ?>
                </td>
                <td class="<?php echo $classes['month']; ?>" colspan="5">
                    <?php echo strftime('%B %Y', mktime(0, 0, 0, $month, 1, $year)); ?>
                </td>
                <td class="<?php echo $classes['next']; ?>">
                    <?php echo $next_month_link; ?>
                </td>
            </tr>
<?php
    $totaldays = date('t', mktime(0, 0, 0, $month, 1, $year));

    // 输出本周的日期
    echo '<tr>';
    $weekdays = ['日', '一', '二', '三', '四', '五', '六'];
    while (list($k, $v) = each($weekdays)) {
        echo '<td class="' . $classes['weekday'] . '"">' . $v . '</td>';
    }
    echo '</tr><tr>';
    // 将第一天与对应的星期相对应
    $day_offset = date('w', mktime(0, 0, 0, $month, 1, $year));
    if ($day_offset > 0) {
        for ($i = 0; $i < $day_offset; $i++) {
            echo '<td class="' . $classes['blank'] . '">&nbsp;</td>';
        }
    }

    $yestoday = time() - 86400;
    // 输出所有天
    for ($day = 1; $day <= $totaldays; $day++) {
        $day_secs = mktime(0, 0, 0, $month, $day, $year);
        if ($day_secs >= $yestoday) {
            if ($day_highlight && ($day == $this_day)) {
                echo '<td class="' . $classes['today'] . '">' . $day . '</td>';
            }
            else {
                echo '<td class="' . $classes['day'] . '">' . $day . '</td>';
            }
        }
        else {
            echo '<td class="' . $classes['day'] . '">' . $day . '</td>';
        }
        $day_offset++;

        /* 每周开始一个新行 */
        if ($day_offset == 7) {
            $day_offset = 0;
            if ($day < $totaldays) {
                echo '</tr><tr>';
            }
        }
    }

    /* 填充最后一周的空白 */
    if ($day_offset > 0) {
        $day_offset = 7 - $day_offset;
    }
    if ($day_offset > 0) {
        for ($i = 0; $i < $day_offset; $i++) {
            echo '<td class="' . $classes['blank'] . '">&nbsp;</td>';
        }
    }
    echo '</tr></table>';
?>
    </body>
</html>
