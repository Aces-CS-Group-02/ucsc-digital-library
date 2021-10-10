<h1>Error</h1>

<?php

echo '<pre>';
echo $params['exception']->getCode();
echo $params['exception']->getMessage();
echo '</pre>';


?>