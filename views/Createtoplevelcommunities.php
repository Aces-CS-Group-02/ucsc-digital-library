<h1>Create Top Level Communities</h1>

<form action="" method="POST">
    <div class="input-group">
        <input type="text" placeholder="Enter new Top level community Name" name="Name" value="<?php echo $params['model']->Name ?? "" ?>">
        <?php
        $attr_name = 'Name';
        if (isset($params['model']) && $params['model']->hasErrors($attr_name)) {

            foreach ($params['model']->errors[$attr_name] as $error) {
                echo '<p>' . $error . '</p>';
            }
        };
        ?>
    </div>
    <div class="input-group">

        <input type="text" placeholder="Community description" name="Description" value="<?php echo $params['model']->Description ?? "" ?>">
    </div>

    <input type="submit" Value="Create">
</form>