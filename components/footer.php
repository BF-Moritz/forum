<?php
include_once './daos/users.php';

$userCount = getUserCount();
$newestUser = getNewestUser();
?>

<link rel="stylesheet" type="text/css" href="css/footer.css">

<div class="footer">
    <div class="footer-container">
        <div class="footer-links">
            <a href="https://github.com/BF-Moritz/forum">Github</a>
        </div>
        <div class="footer-stats">
            Anzhl Mitglieder: <?php echo $userCount; ?><br>
            Neustes Mitglied: <?php
                                if ($newestUser == null) {
                                    echo '-';
                                } else {
                                    echo $newestUser->username;
                                }
                                ?>
        </div>
    </div>
</div>