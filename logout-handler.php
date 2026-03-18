<?php
/**
 * Logout Handler
 * This dedicated file handles the request to log out the user.
 * It ensures the session is destroyed and the user is redirected cleanly.
 */

// Include the User class file. 
// Assuming this file is in the root and User.php is in 'classes/'.
require_once 'classes/User.php';

// Call the static logout method, which handles session destruction and redirection to login.php.
// The session_start() call is handled safely inside User::logout().
User::logout();
// Note: Closing PHP tag removed to prevent accidental trailing whitespace.