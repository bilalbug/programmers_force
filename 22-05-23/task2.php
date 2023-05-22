<?php

$number = array ("3","5","300","9","30");

function Divisibleby3($number)
{
    $counter = 0;
    foreach ($number as $value) {
        if($value>=300){
            $counter = 0;
            break;
        }
        elseif($value%3==0){
            $counter++;
        }
    }
    echo $counter;
}

    Divisibleby3($number);

?>