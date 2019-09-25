<?php 
/**
 * Dump shortcut
 */
function _d()
{
    call_user_func_array( 'var_dump', func_get_args() );
}

/**
 * Dump and die shortcut
 */
function _dd()
{
    ob_get_clean(); call_user_func_array( 'var_dump', func_get_args() ); die;
}

/**
 * Autoloader
 */
require __DIR__ . '/vendor/autoload.php';
