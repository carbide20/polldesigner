Welcome to the account page!

<a href="account/logout">Log out</a>

<?php
    // Only display polls if we have any
    if ($polls) {

    echo "<ul>";

        // Loop through each of the polls so we can display them
        foreach ($polls as $poll) {
        echo "<li>" . $poll->name . "</li>";
        }

        echo "</ul>";

    }

?>