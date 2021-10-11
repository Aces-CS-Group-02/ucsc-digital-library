<style>
    .communities {
        display: block;
    }
</style>




<h1>Communities</h1>

<?php

use app\core\Application;

if (Application::$app->session->getFlashMessage('success-community-creation')) {
    echo Application::$app->session->getFlashMessage('success-community-creation');
}

?>

<a href="/create-top-level-communities">Create New Top Level Community</a>


<?php


$allTopLevelCommunities = $params['allTopLevelCommunities'] ?? "";


// foreach ($allTopLevelCommunities as $community) {
//     echo '<div class="community-container">';
//     echo '<a class="communities" href="#" data="' . $community['CommunityID'] . '">' . $community['Name'] . '</a>';
//     echo '<button 
//             class="delete-btn" 
//             data-id="' . $community['CommunityID'] . '" 
//             onclick="return confirm(`are you sure?`)"
//             >Delete</button>';
//     echo '<form 
//             action="/communities/update/community"
//             method="GET" >
//                 <button name="ID" value="' . $community['CommunityID'] . '">Update</button>
//             </form>';

//     echo '</div>';
// }

?>

<?php foreach ($allTopLevelCommunities as $community) { ?>
    <div class="community-container">
        <a class="communities" href="#"><?php echo $community['Name'] ?></a>
        <button class="btn-del" data-id="<?php echo $community['CommunityID'] ?>">Delete</button>
        <button class="btn-update" data-id="<?php echo $community['CommunityID'] ?>">Update</button>
    </div>
<?php } ?>

<Script>
    (() => {
        const ID_MAP = new WeakMap();
        const ID_MAP_2 = new WeakMap();


        const onClickAction = ({
            currentTarget
        }) => {
            // Exit if there is no ID stored
            if (!ID_MAP.has(currentTarget)) return;

            // Retrieve and log ID
            const id = ID_MAP.get(currentTarget);
            console.log(id);

            // AJAX request
            if (confirm("Are you sure?")) {
                const delRequest = new XMLHttpRequest();
                let params = [];
                params = `deleteCommunity=true&communityID=${id}`;
                delRequest.open('POST', '/ajax/delete-top-level-community');
                delRequest.onreadystatechange = function() {
                    if (delRequest.responseText === 'success') {
                        currentTarget.parentElement.remove();
                    }
                }
                delRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                delRequest.send(params);
            }


        }


        const deleteBtns = document.querySelectorAll('.btn-del');
        const updateBtns = document.querySelectorAll('.btn-update');

        for (const btn of deleteBtns) {
            // Skip if it doesn't have an ID
            if (!btn.dataset.id) continue;

            // Store and hide `data-id` attribute
            ID_MAP.set(btn, btn.dataset.id);
            btn.removeAttribute('data-id');

            // Add event listener
            btn.addEventListener('click', onClickAction, false);
        }



        // ============================================================
        const handleUpdate = ({
            currentTarget
        }) => {
            // console.log(currentTarget)
            if (!ID_MAP_2.has(currentTarget)) return;

            // Retrieve and log ID
            const id_update = ID_MAP_2.get(currentTarget);
            console.log(id_update);

            // AJAX request
            window.location = `/communities/update/community?ID=${id_update}`;
        }


        for (const updateBtn of updateBtns) {
            // Skip if it doesn't have an ID
            if (!updateBtn.dataset.id) continue;

            // Store and hide `data-id` attribute
            ID_MAP_2.set(updateBtn, updateBtn.dataset.id);
            updateBtn.removeAttribute('data-id');

            // Add event listener
            updateBtn.addEventListener('click', handleUpdate, false);
        }


    })();
</Script>