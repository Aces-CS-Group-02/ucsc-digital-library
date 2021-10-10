<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>

<style>
    .danger-alert {
        background-color: rgba(255, 0, 0, 0.3);
        color: white;
        font-weight: 500;
        padding: 5px 7px;
        border-radius: 3px;
    }

    .successful-alert {
        background-color: rgba(0, 255, 0, 0.6);
        color: white;
        font-weight: 500;
        padding: 5px 7px;
        border-radius: 3px;
    }

    .active {
        background-color: gray;
    }

    .input-group {
        /* margin: 10px; */
        width: 100%;
        display: flex;
        flex-direction: column;
        margin-bottom: 20px;
    }

    .input-group>label {
        margin-bottom: 7px;
    }

    .input-group>input {
        border-radius: 4px;
        outline: none;
        border: 1px solid gray;
        height: 1.5rem;
    }

    form {
        max-width: 400px;
        width: 400px;
        display: flex;
        flex-direction: column;
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
    }

    #page-title {
        width: 100%;
        text-align: center;
    }

    .form-errors-container {
        height: fit-content;
        padding: 2px 0px;
        /* background-color: rgba(230, 10, 0, 0.8); */
        border-radius: 4px;
        margin-top: 4px;
    }

    .form-errors-container>p {
        /* margin: 4px 0; */
        margin: 0;
        color: rgba(230, 10, 0, 0.8);
    }

    .border-warning {
        border: 1px solid rgba(230, 10, 0, 0.8) !important;
    }
</style>

<body>
    <h1 id="page-title">Register</h1>

    <?php

    // echo '<pre>';
    // var_dump($params);
    // echo '</pre>';

    ?>

    <form action="" method="POST">
        <div class="input-group">
            <?php

            $attr_name = 'firstname';
            $warning_class = $params['model']->hasErrors($attr_name) ? "border-warning" : "";

            echo '<label for="first-name">First Name</label>';
            echo '<input 
                        type="text" 
                        name="firstname" 
                        value="' . $params["model"]->{$attr_name} . '" 
                        id="first-name"
                        class="' . $warning_class . '"
                        >';


            if ($params['model']->hasErrors($attr_name)) {
                echo '<div class="form-errors-container">';
                foreach ($params['model']->errors[$attr_name] as $error) {
                    echo '<p>' . $error . '</p>';
                }
                echo '</div>';
            }
            ?>
        </div>

        <div class=" input-group">
            <?php

            $attr_name = 'lastname';
            $warning_class = $params['model']->hasErrors($attr_name) ? "border-warning" : "";

            echo '<label for="last-name">Last Name</label>';
            echo '<input 
                        type="text" 
                        name="lastname" 
                        value="' . $params["model"]->{$attr_name} . '" 
                        id="last-name"
                        class="' . $warning_class . '"
            >';

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

            $attr_name = 'email';
            $warning_class = $params['model']->hasErrors($attr_name) ? "border-warning" : "";

            echo '<label for="last-name">Email</label>';
            echo '<input 
                        type="text" 
                        name="email" 
                        value="' . $params["model"]->{$attr_name} . '" 
                        id="email"
                        class="' . $warning_class . '"
            >';

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

            $attr_name = 'password';
            $warning_class = $params['model']->hasErrors($attr_name) ? "border-warning" : "";

            echo '<label for="last-name">Password</label>';
            echo '<input 
                        type="password" 
                        name="password" 
                        value="' . $params["model"]->{$attr_name} . '" 
                        id="password"
                        class="' . $warning_class . '"
            >';

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

            $attr_name = 'confirmpassword';
            $warning_class = $params['model']->hasErrors($attr_name) ? "border-warning" : "";

            echo '<label for="confirm">Confirm Password</label>';
            echo '<input 
                        type="password" 
                        name="confirmpassword" 
                        value="' . $params["model"]->{$attr_name} . '" 
                        id="confirmpassword"
                        class="' . $warning_class . '"
            >';

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
            <input id="form-register-btn" type="submit" value="Register">

        </div>

    </form>



</body>

</html>