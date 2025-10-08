<?php

$tabla = [9,5,7,3,6,1];
for ( $i=0; $i<sizeof($tabla); $i++ ){
            
            for ($j=$i; $j<sizeof($tabla); $j++){
                if ($tabla[$j]<$tabla[$i]){
                    $temp=$tabla[$i];
                    $tabla[$i]=$tabla[$j];
                    $tabla[$j]=$temp;
                }
            }
            
        }
print_r($tabla);
?>