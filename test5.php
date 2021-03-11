<?php    
function factorial($n)    
{    
    if ($n < 0)    
        return -1; /*Wrong value*/    
    if ($n == 0)    
        return 1; /*Terminating condition*/    
    return ($n * factorial ($n -1));    
}    
    
// echo factorial(4);    
$sum = 1;
for($i=1;$i<=5;$i++){
    $sum = $sum * $i;
}
echo $sum;
?>    