<?php

// DIRECTORY_SEPARATOR is a PHP pre-defined constant
defined('DS') ? NULL : define('DS', DIRECTORY_SEPARATOR);
defined('SITE_ROOT') ? NULL : define('SITE_ROOT', DS.'wamp'.DS.'www'.DS.'songfarm-Jul2015');
defined('LIB_PATH') ? NULL : define('LIB_PATH', SITE_ROOT.DS.'includes');
defined('CORE_PATH') ? NULL : define('CORE_PATH' , SITE_ROOT.DS.'public');
defined('IMAGE_PATH') ? NULL : define('IMAGE_PATH', SITE_ROOT.DS.'uploaded_images');

// Load database config file first
require_once(LIB_PATH.DS."config.php");
// Load classes
require_once(LIB_PATH.DS."session.php");
require_once(LIB_PATH.DS."database.php");
require_once(LIB_PATH.DS."validateLogin.php");
require_once(LIB_PATH.DS."user.php");
require_once(LIB_PATH.DS."songcircle.php");
require_once(LIB_PATH.DS."userProfile.php");
// Load basic functions
require_once(LIB_PATH.DS."functions.php");
require_once(LIB_PATH.DS."detectUserIp.php");

?>
