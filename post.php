<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    echo '<pre>',print_r($_POST, TRUE),'</pre><br /><br /><br />';
}

?>

<form method="post" action="">
    <input type="hidden" name="test1" value="one" />
    <input type="hidden" name="test2" value="two" />
    <input type="hidden" name="test3" value="three" />
    <input type="submit" value="Test Me" />
</form>