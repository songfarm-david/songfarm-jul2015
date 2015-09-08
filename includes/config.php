<?php

/* Database Constants */
//test config
defined("DB_SERVER") 	? NULL : define("DB_SERVER",'localhost');
defined("DB_USER") 		? NULL : define("DB_USER",'admin');
defined("DB_PASS") 		? NULL : define("DB_PASS",'');
defined("DB_NAME") 		? NULL : define("DB_NAME",'songfarm-jul2015');

// live config
// defined("DB_SERVER") 	? NULL : define("DB_SERVER",'localhost');
// defined("DB_USER") 		? NULL : define("DB_USER",'songfarm_david');
// defined("DB_PASS") 		? NULL : define("DB_PASS",'');
// defined("DB_NAME") 		? NULL : define("DB_NAME",'songfarm_registree_info');


// Upload Errors
defined("UPLOAD_ERR_OK") 					? NULL : define("UPLOAD_ERR_OK", 0);
defined("UPLOAD_ERR_INI_SIZE") 		? NULL : define("UPLOAD_ERR_INI_SIZE", 1);
defined("UPLOAD_ERR_FORM_SIZE") 	? NULL : define("UPLOAD_ERR_FORM_SIZE", 2);
defined("UPLOAD_ERR_PARTIAL") 		? NULL : define("UPLOAD_ERR_PARTIAL", 3);
defined("UPLOAD_ERR_NO_FILE") 		? NULL : define("UPLOAD_ERR_NO_FILE", 4);
defined("UPLOAD_ERR_NO_TMP_DIR") 	? NULL : define("UPLOAD_ERR_NO_TMP_DIR", 6);
defined("UPLOAD_ERR_CANT_WRITE") 	? NULL : define("UPLOAD_ERR_CANT_WRITE", 7);
defined("UPLOAD_ERR_EXTENSION") 	? NULL : define("UPLOAD_ERR_EXTENSION", 8);

?>
