<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php foreach ($params['requests'] as $request) { ?>
        <p><?= $request->content_title ?></p>
        <span>
            <p><?= $request->user_first_name ?></p>
            <p><?= $request->user_last_name ?></p>
        </span>
        <p><?= $request->lend_duration ?></p>
        <form action="#" method="POST">
            <input type="hidden" name="content_id" value="<?= $request->content_id ?>" />
            <input type="hidden" name="user_reg_no" value="<?= $request->user_reg_no ?>" />
            <button name="action" value="1">Approve</button>
            <button name="action" value="2">Reject</button>
        </form>
    <?php } ?>
</body>

</html>