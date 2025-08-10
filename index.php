<?php
/**
 * @file index.php
 * @brief Main entry point for the server application.
 *
 * This file serves as the primary gateway for the server-side application.
 * It initializes the bootstrap module and starts the main application process.
 */

require('modules/bootstrap/Bootstrap.php');

use modules\bootstrap\Bootstrap;

/**
 * Creates and runs the main bootstrap module.
 *
 * This line:
 * 1. Instantiates the Bootstrap class
 * 2. Calls its onMainModule() method to start the application
 * @see modules\bootstrap\Bootstrap::onMainModule()
 */
(new Bootstrap())->onMainModule();