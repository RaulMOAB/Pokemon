<?php

function get_max_length(array $manga):int{

   $arr = [];
   foreach ($manga as $index => $value) {   
    $arr []= max(array_map('strlen',$value));   
}

    $max_length = max($arr);
    return $max_length;
}


function main():void{

    $manga = [
        ['Chainsaw Man',    13],
        ['Attack on Titan', 27],
        ['Dragon Ball Z',   10],
        ['One Piece',       70]
    ];

    $max = get_max_length($manga);
    echo $max;

}

main();