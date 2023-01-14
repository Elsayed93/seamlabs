<?php

namespace App\Http\Controllers\Problems;

class MinimizeNumber
{
    public function getMax($arr)
    {
        $maxNumber = $arr[0];
        for ($i = 0, $length = count($arr); $i < $length; $i++) {
            if ($arr[$i] > $maxNumber) {
                $maxNumber = $arr[$i];
            }
        }

        return $maxNumber;
    }


    public function minSteps($arr,  $n)
    {
        $maxVal = $this->getMax($arr);
        return $maxVal;
    }
}
