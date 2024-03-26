<?php
    #logial test- CatalystIT pty
    #outpout the number from 1 to 100 
    #which are divisible by 3 output it by word "foo"
    #which are divisible by 5 output it by word "bar"
    #which are divisible by both 3 & 5 output it by word "foobar"


    $foo = "foo"; // variable created for reuse - string valued variable
    $bar = "bar"; // variable created for reuse - string valued variable
    
    //for loop to make number counting from 1 to 100 and ends at 100
    for($start = 1; $start <=100; $start++){
        
        if($start % 3 == 0 && $start % 5 == 0){ //initial check if condition with ('&&' and) logical operator to perform checking both conditions divisible by 3 & 5
            echo $foo . $bar . ", ";
        }elseif($start % 3 == 0 ){ // if condition to check wither the counting numbers are divisible by 3
            echo $foo . ", ";
        }elseif($start % 5 == 0){ // if condition to check wither the counting numbers are divisible by 5
            echo $bar . ", ";
        }else{
            echo $start . ", ";
        }
    }
?>