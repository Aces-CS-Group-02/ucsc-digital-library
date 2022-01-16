<?php foreach ($params['topLevelCommunities'] as $toplevelcommunity) { ?>
    <a href="/browse/community?community_id=<?= $toplevelcommunity->community_id ?>"><?= $toplevelcommunity->name ?></a>
<?php } ?>