<style>
    .communities {
        display: block;
    }
</style>




<h1>Communities</h1>

<?php

use app\core\Application;

echo Application::$app->session->getFlashMessage('success-community-creation');

?>

<a href="/create-top-level-communities">Create New Top Level Community</a>


<?php
// echo '<pre>';
// var_dump($params);
// echo '</pre>';

$allTopLevelCommunities = $params['allTopLevelCommunities'] ?? "";


foreach ($allTopLevelCommunities as $community) {
    echo '<div class="community-container">';
    echo '<a class="communities" href="#" data="' . $community['CommunityID'] . '">' . $community['Name'] . '</a>';
    echo '<button 
            class="delete-btn" 
            data-id="' . $community['CommunityID'] . '" 
            onclick="return confirm(`are you sure?`)"
            >Delete</button>';
    echo '<form 
            action="/communities/update/community"
            method="GET" >
                <button name="ID" value="' . $community['CommunityID'] . '">Update</button>
            </form>';

    echo '</div>';
}

?>

<Script>
    const deleteBtns = document.getElementsByClassName('delete-btn');
    var deleteBtnsArray = Array.from(deleteBtns);

    deleteBtnsArray.map(deleteBtn => {
        deleteBtn.addEventListener('click', () => {
            const delRequest = new XMLHttpRequest();
            let params = [];
            params = `deleteCommunity=true&communityID=${deleteBtn.dataset.id}`;
            delRequest.open('POST', '/ajax/delete-top-level-community');
            delRequest.onreadystatechange = function() {
                if (delRequest.responseText === 'success') {
                    deleteBtn.parentElement.remove();
                }
            }
            delRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            delRequest.send(params);
        })
    })
</Script>