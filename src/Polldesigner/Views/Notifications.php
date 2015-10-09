<?php
    // Check if there are errors in the session
    if (isset($_SESSION['errors']) && !empty($_SESSION['errors'])) {

        // Loop through the errors
        foreach($_SESSION['errors'] as $error) {

            echo '<div class="error">' . $error . '</div>';

        }

        // Release them
        unset($_SESSION['errors']);

    }