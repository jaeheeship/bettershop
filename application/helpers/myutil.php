<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
    function getMonthName($month, $short = true) {
        $short_month = array('','Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');
        $long_month = array('','January','February','March','April','May','June','July','August','September','October','November','December');
        return !$short?$long_month[$month]:$short_month[$month];
    }

    function zgap() {
        $time_zone = $GLOBALS['_time_zone'];
        if($time_zone < 0) $to = -1; else $to = 1;
        $t_hour = substr($time_zone, 1, 2) * $to;
        $t_min = substr($time_zone, 3, 2) * $to;

        $server_time_zone = date("O");
        if($server_time_zone < 0) $so = -1; else $so = 1;
        $c_hour = substr($server_time_zone, 1, 2) * $so;
        $c_min = substr($server_time_zone, 3, 2) * $so;

        $g_min = $t_min - $c_min;
        $g_hour = $t_hour - $c_hour;

        $gap = $g_min*60 + $g_hour*60*60;
        return $gap;
    }


    function ztime($str) {
        if(!$str) return;
        $hour = (int)substr($str,8,2);
        $min = (int)substr($str,10,2);
        $sec = (int)substr($str,12,2);
        $year = (int)substr($str,0,4);
        $month = (int)substr($str,4,2);
        $day = (int)substr($str,6,2);
        if(strlen($str) <= 8) {
            $gap = 0;
        } else {
            $gap = zgap();
        }

        return mktime($hour, $min, $sec, $month?$month:1, $day?$day:1, $year)+$gap;
    } 

    function zdate($str, $format = 'Y-m-d H:i:s') {
        if(!$str) return;
        
        // If year value is less than 1970, handle it separately.
        if((int)substr($str,0,4) < 1970) {
            $hour  = (int)substr($str,8,2);
            $min   = (int)substr($str,10,2);
            $sec   = (int)substr($str,12,2);
            $year  = (int)substr($str,0,4);
            $month = (int)substr($str,4,2);
            $day   = (int)substr($str,6,2);

			// leading zero?
			$lz = create_function('$n', 'return ($n>9?"":"0").$n;');

			$trans = array(
				'Y'=>$year,
				'y'=>$lz($year%100),
				'm'=>$lz($month),
				'n'=>$month,
				'd'=>$lz($day),
				'j'=>$day,
				'G'=>$hour,
				'H'=>$lz($hour),
				'g'=>$hour%12,
				'h'=>$lz($hour%12),
				'i'=>$lz($min),
				's'=>$lz($sec),
				'M'=>getMonthName($month),
				'F'=>getMonthName($month,false)
			);

            $string = strtr($format, $trans);
        } else {
            $string = date($format, ztime($str));
        }
        
        return $string;
?>
