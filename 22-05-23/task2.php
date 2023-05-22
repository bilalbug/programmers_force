<?php

$number = array ("3","5","6","9","300");

function Divisibleby3($number)
{
    $counter = 0;
    foreach ($number as $value) {
        if($value>=300){
            $counter = 0;
        }
        elseif($value%3==0){
            $counter++;
        }
    }
    echo $counter;
}

    Divisibleby3($number);

?>