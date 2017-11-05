<?php

function dump($var, $title = null) {
    
    echo '<pre>';
    if(!is_null($title)) echo($title.' ');
    print_r($var);
    echo '</pre>';
}