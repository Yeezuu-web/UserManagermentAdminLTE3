<?php

namespace App\Helpers;

class Helper{
    public static function duration($times)
    {   
        $sum = strtotime('00:00:00');
        
        $totaltime = 0;
        
        foreach( $times as $element ) {
            
            // Converting the time into seconds
            $timeinsec = strtotime($element) - $sum;
            
            // Sum the time with previous value
            $totaltime = $totaltime + $timeinsec;
        }
        
        // Totaltime is the summation of all
        // time in seconds
        
        // Hours is obtained by dividing
        // totaltime with 3600
        $h = intval($totaltime / 3600);
        
        $totaltime = $totaltime - ($h * 3600);
        
        // Minutes is obtained by dividing
        // remaining total time with 60
        $m = intval($totaltime / 60);
        
        // Remaining value is seconds
        $s = $totaltime - ($m * 60);

        //Result 
        $result = (str_pad($h, 2, '0', STR_PAD_LEFT) ? str_pad($h, 2, '0', STR_PAD_LEFT) : '00').':'.(str_pad($m, 2, '0', STR_PAD_LEFT) ? str_pad($m, 2, '0', STR_PAD_LEFT) : '00').':'.(str_pad($s, 2, '0', STR_PAD_LEFT) ? str_pad($s, 2, '0', STR_PAD_LEFT) : '00');

        // Return the result
        return $result;
    }
}

?>