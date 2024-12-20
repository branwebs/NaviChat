<?php
require_once '../../Entity/users.php';

function handleIndustrySelection($industry)
{
    $user = new User(); // Instantiate the User class

    // Fetch chatbot configuration based on the selected industry
    $botConfig = $user->getBot($industry);

    // Return the result to the main script
    return $botConfig;
}

?>