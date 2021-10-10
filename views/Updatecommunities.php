<h1>Update Community</h1>


<?php


echo '<pre>';
var_dump($params['model']);
echo '</pre>';

?>

<form action="" method="POST">
    <div class="input-group">
        <?php

        $attr_name = "Name";
        if (isset($params['model'])) {
            echo '<input type="text" name="Name" value="' . $params['model']->Name . '">';
        }
        if ($params['model']->hasErrors($attr_name)) {
            echo '<div class="form-errors-container">';
            foreach ($params['model']->errors[$attr_name] as $error) {
                echo '<p>' . $error . '</p>';
            }
            echo '</div>';
        }
        ?>
    </div>
    <div class="input-group">
        <?php

        $attr_name = "Description";
        if (isset($params['model'])) {
            echo '<input type="text" name="Description" value="' . $params['model']->Description . '">';
        }

        ?>
    </div>
    <?php
    echo '<button name="ID" value="' . $params['model']->CommunityID . '">Update</button>';
    ?>
</form>