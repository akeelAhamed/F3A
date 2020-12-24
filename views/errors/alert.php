<?php /* All Error message goes here */

if (isset($_SESSION['alert'])):
    echo '<div uk-alert class="uk-box-shadow-small '.$_SESSION['type'].'">';
    echo '<a class="uk-alert-close" uk-close></a><ul class="uk-list uk-list-bullet">';
    foreach ($_SESSION['alert'] as $key => $alert):
        echo "<li>$alert</li>";
    endforeach;
    echo '</ul></div>';

    unset($_SESSION['alert']);
    unset($_SESSION['type']);
endif;