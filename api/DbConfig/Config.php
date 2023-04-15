<?php
    const ENV = "DEV";
    if(ENV == "PROD"){
        define('HOST_USERNAME', 'xyz');
        define('HOST_PASSWORD', 'abc');
        define('HOST_NAME', 'localhost');
        define('DATABASE_NAME', 'x_prompt');
    }else{
        // default  config values
        define('HOST_USERNAME', 'root');
        define('HOST_PASSWORD', '');
        define('HOST_NAME', 'localhost');
        define('DATABASE_NAME', 'x_prompt');
    }
?>
    