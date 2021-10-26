<div class="breadcrum-container">
    <?php
    if (isset($params['breadcrum'])) {
        $breadcrumItems = count($params['breadcrum']);
        $i = 0;
        foreach ($params['breadcrum'] as $breadcrumLink) {
            if (++$i === $breadcrumItems) {
                echo '<a class="breadcrum-link current-breadcrum-link" href="' . $breadcrumLink['link'] . '">' . $breadcrumLink['name'] . '</a>';
            } else {
                echo '<a class="breadcrum-link" href="' . $breadcrumLink['link'] . '">' . $breadcrumLink['name'] . '</a>';
                echo '<p class="breadcrum-link-arrow">></p>';
            }
        }
    }
    ?>
</div>