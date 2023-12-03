<?php 


    setcookie('custnamecookie',"",time()-(86400*40), "/");
    setcookie('custidcookie',"",time()-(86400*40), "/");
    setcookie('custtypecookie',"",time()-(86400*40), "/");

    session_start();
    session_destroy();

    header("location:login.php");

    
?>