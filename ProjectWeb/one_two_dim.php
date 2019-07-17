<?php

function arrayToMat($array, $split){

  if(count($array) % $split == 0){

    $row = 1;

    for($i = 0; $i < count($array); $i += $split){

      for($j = 0; $j < $split; $j++){

        $mat[$row][$j+1] = $array[$i+$j];

      }

    $row++;

    }

    return $mat;

  } else {

  return FALSE;

  }

}


?>