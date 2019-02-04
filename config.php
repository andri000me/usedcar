<?php
// HTTP
define('HTTP_SERVER', 'http://localhost:1000/usedcar/');

// HTTPS
define('HTTPS_SERVER', 'http://localhost:1000/usedcar/');

// DIR
define('DIR_APPLICATION', 'D:/Xampp/htdocs/usedcar/catalog/');
define('DIR_SYSTEM', 'D:/Xampp/htdocs/usedcar/system/');
define('DIR_IMAGE', 'D:/Xampp/htdocs/usedcar/image/');
define('DIR_STORAGE', 'D:/Xampp/htdocs/usedcar/storage/');
define('DIR_LANGUAGE', DIR_APPLICATION . 'language/');
define('DIR_TEMPLATE', DIR_APPLICATION . 'view/theme/');
define('DIR_CONFIG', DIR_SYSTEM . 'config/');
define('DIR_CACHE', DIR_STORAGE . 'cache/');
define('DIR_DOWNLOAD', DIR_STORAGE . 'download/');
define('DIR_LOGS', DIR_STORAGE . 'logs/');
define('DIR_MODIFICATION', DIR_STORAGE . 'modification/');
define('DIR_SESSION', DIR_STORAGE . 'session/');
define('DIR_UPLOAD', DIR_STORAGE . 'upload/');

// DB
define('DB_DRIVER', 'mysqli');
define('DB_HOSTNAME', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_DATABASE', 'usedcar');
define('DB_PORT', '3306');
define('DB_PREFIX', 'uc_');

//API
define('OTOCARE_API', 'https://cisadane-dev.asuransiastra.com/Otocare');
define('GET_CUST_DATA_API', '/data/v10/Customer/GetCustomerData');