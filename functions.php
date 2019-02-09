<?php
function valid_date(string $ts) : int
{
//dag (0 zondag 6 zaterdag)
    $wd = date("w", strtotime($ts));
//maand (1-12)
    $m = date("n", strtotime($ts));
//dag in maand (1-31)
    $dm = date("j", strtotime($ts));

    if ($wd == 0 || $wd == 6)
        return 1; //weekend error
    if ($m == 1 && $dm == 1)
        return 2; //new year error
    if ($m == 12 && $dm == 25)
        return 3; //christmas error
    if ($dm == 5 || $dm == 15)
        return 4; //5 or 15 error
    return 0;
}

function get_next_valid_day(string $ts) : string
{
    $dd = $ts;
    do {
        $next_day = date('d-m-Y', strtotime($dd . ' +1 day'));
        $dd = $next_day;
    } while (valid_date($dd) != 0);
    return $dd;
}


function get_next_meeting_day(string $ts, int $number) : string
{
    $dd = $ts;
    for ($i = 0; $i <= $number; $i++) {
        $next_valid_day = get_next_valid_day($dd);
        $dd = $next_valid_day;
    }
    return $dd;
}


function create_meeting_days(string $tsb, int $number, string $tse) : array
{
    $meetings = [];
    $dd = trim($tsb);
    $tel = 1;
    while (date('Y-m-d', strtotime($dd)) <= date('Y-m-d', strtotime($tse))) {
        $m_arr = [];
        $push_arr = array("id" => $tel, "day" => $dd);
        $m_arr = array_merge($m_arr, $push_arr);
        $next_meeting_day = get_next_meeting_day($dd, $number);
        $dd = $next_meeting_day;
        $tel++;
        $meetings[] = $m_arr;
    };

    return $meetings;

}

function outputCsv($fileName, $data)
{
    $file = fopen($fileName, 'w');
    fputcsv($file, array('id', 'day'));
    foreach ($data as $row) {
        fputcsv($file, $row);
    }
    fclose($file);
}
