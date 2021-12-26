<h1>Hi</h1>

<form action="" method="POST">
    <?php foreach ($params['data'] as $data) { ?>
        <button name='collection-id' value="<?= $data->id ?>"><?= $data->path ?></button>
    <?php } ?>
</form>