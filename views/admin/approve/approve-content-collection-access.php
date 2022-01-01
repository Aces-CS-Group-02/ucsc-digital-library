<?php

$requests = $params['requests'];

?>

<?php foreach ($requests as $request) { ?>
    <p><?= $request->collection_name ?></p>
    <p><?= $request->usergroup_name ?></p>
    <?php if ($request->permission == 1) { ?>
        <p>READ</p>
    <?php } else if ($request->permission == 2) { ?>
        <p>READ/DOWNLOAD</p>
    <?php } ?>
    <form action="/admin/approve-access-permission/content-collections/approve" method="POST">
        <input type='hidden' name='collection-id' value='<?= $request->content_collection_id ?>' />
        <input type='hidden' name='usergroup-id' value='<?= $request->group_id ?>' />
        <button>Approve</button>
    </form>
    <form action="/admin/approve-access-permission/content-collections/reject" method="POST">
        <input type='hidden' name='collection-id' value='<?= $request->content_collection_id ?>' />
        <input type='hidden' name='usergroup-id' value='<?= $request->group_id ?>' />
        <button>Reject</button>
    </form>
<?php } ?>