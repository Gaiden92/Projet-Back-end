<?php
/**
 * messages alertes
 * @param string $type
 * @param string $message
 * @return void
 */
function msgAlert(string $type, string $message) : void
{
    $_SESSION['msg'][] =
    [
        'type' => $type,
        'message' => $message
    ];
}





















?>