<?php
function collatzConjecture($startingNum)
{
    $sequence = array();

    $num = $startingNum;

    while ($num != 1) {
        if (fmod($num, 2) == 0)
            $num /= 2;
        else
            $num = ($num * 3) + 1;

        array_push($sequence, $num);
    }
    return $sequence;
}
function highestNum($sequence,$initNum)
{
    $maxVal = $initNum;
    foreach ($sequence as $elem) {
        if ($elem > $maxVal)
            $maxVal = $elem;
    }
    return $maxVal;
}
?>