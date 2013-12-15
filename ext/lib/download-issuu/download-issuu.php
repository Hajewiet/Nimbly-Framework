<?php

function download_issuu_token() {
    set_time_limit(0);
    for ($i = 1; $i <= 17; $i++) {
       file_put_contents("page_{$i}.jpg", 
               file_get_contents("http://image.issuu.com/130812213734-7ea4ddb6508305ab282bc9e0538973c0/jpg/page_{$i}.jpg"));  
    }
}

?>
