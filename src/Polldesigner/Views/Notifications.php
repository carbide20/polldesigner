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

    // Check if there are errors in the session
    if (isset($_SESSION['warnings']) && !empty($_SESSION['warnings'])) {

        // Loop through the errors
        foreach($_SESSION['warnings'] as $warning) {

            echo '<div class="warning">' . $warning . '</div>';

        }

        // Release them
        unset($_SESSION['warnings']);

    }

    // Check if there are errors in the session
    if (isset($_SESSION['successes']) && !empty($_SESSION['successes'])) {

        // Loop through the errors
        foreach($_SESSION['successes'] as $success) {

            echo '<div class="success">' . $success . '</div>';

        }

        // Release them
        unset($_SESSION['successes']);

    }