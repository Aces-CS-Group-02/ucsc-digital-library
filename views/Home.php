<?php

use app\core\Application;

echo '<pre>';
var_dump(Application::$app->user);
echo '</pre>';

// echo '<pre>';
// var_dump(Application::$app->getUserDisplayName());
// echo '</pre>';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>

<body>
    <h1>Home Page</h1>
    <?php if (Application::$app->isGuest()) { ?>
        <a href="/login">Login</a>
    <?php } else { ?>
        <p><?php echo Application::$app->getUserDisplayName()['firstname'] . ' ' . Application::$app->getUserDisplayName()['lastname'] ?></p>
        <a href="/logout">Logout</a>
    <?php } ?>
</body>

</html>