<?php
$arr = get_defined_vars();
// print all the server vars
print_r($arr);

// new line for git test
//add new line for two step in file

//add new line and new variable and change server values
$newVar = 'my name is naser';


echo $_SERVER['PHP_SELF2'];
echo "<br>";
echo $_SERVER['SERVER_NAME'];
echo "<br>";
echo $_SERVER['HTTP_HOST'];
echo "<br>";
echo $_SERVER['HTTP_REFERER'];
echo "<br>";
echo $_SERVER['HTTP_USER_AGENT'];
echo "<br>";
echo $_SERVER['SCRIPT_NAME'];
?>