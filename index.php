<?php
define('APP_ENV','DEV');
define('DS','\\');
define('NSEP','\\');
define('API_EXT','.cls.php');
define('API_EXT_UI','.app.screen');

define('APP_BASE_DIR','');
define('APP_API_PATH',    APP_BASE_DIR.'api'.DS);
define('APP_MEDIA_PATH',  APP_BASE_DIR.'media'.DS);
define('APP_CLIENT_PATH', APP_BASE_DIR.'client'.DS);

define('APP_VER', 'main'.DS);
define('APP_VER_FOLDER', 'alpha'.DS);
define('APP_THEME', 'light'.DS);

define('APP_CONTENT_PRE',APP_CLIENT_PATH.'temp'.DS);
define('APP_RESOURCE_JS', APP_CLIENT_PATH.'js'.DS);
define('APP_RESOURCE_CSS',APP_CLIENT_PATH.'css'.DS);
define('APP_RESOURCE_SCREEN',APP_CLIENT_PATH.'screen'.DS);


define('APP_CONTENT_ALL',APP_CONTENT_PRE.APP_VER.APP_VER_FOLDER.DS);

define('APP_ASSETS_DIR', APP_CONTENT_ALL.'assets'.DS);
define('APP_CSS_DIR',    APP_CONTENT_ALL.'css'.DS);
define('APP_FONTS_DIR',  APP_CONTENT_ALL.'fonts'.DS);
define('APP_IMGS_DIR',   APP_CONTENT_ALL.'images'.DS);
define('APP_JS_DIR',     APP_CONTENT_ALL.'js'.DS);
define('APP_VIEW_DIR',   APP_CONTENT_ALL.'view'.DS);


define('APP_CLIENT_LIB',APP_CLIENT_PATH.'api'.DS);
define('APP_RESOURCE_ANGJS',APP_CLIENT_LIB.'angularjs'.DS);
define('APP_API_ANGJS',APP_CLIENT_LIB.'app_api'.DS);

// define('APP_ANGJS_PATH', 'https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js');
define('APP_ANGJS_PATH_BASE', APP_RESOURCE_ANGJS.'angular-library'.DS);
define('APP_ANGJS_MD_BASE', APP_RESOURCE_ANGJS.'angular-material'.DS);
define('APP_ANGJS_PATH', APP_ANGJS_PATH_BASE.'angular.min.js');
define('APP_ANGJS_STORAGE', APP_ANGJS_PATH_BASE.'angular-local-storage.min.js');
define('APP_ANGJS_CTRL', APP_RESOURCE_ANGJS.'controller'.DS);
define('APP_ANGJS_MOD',  APP_RESOURCE_ANGJS.'module'.DS);
define('APP_ANGJS_SERV', APP_RESOURCE_ANGJS.'service'.DS);


define('APP_VIEW_MAIN',APP_VIEW_DIR.APP_THEME.'index.html');
define('APP_MAIN',APP_API_PATH.'index.php');
define('APP_SRC',APP_API_PATH.'src'.DS);
define('APP_MODULES',APP_API_PATH.'modules'.DS);

// define('APP_API_ANGJS_CTRL',APP_API_ANGJS.'controller'.DS);
//Temp
define('APP_API_ANGJS_MOD',APP_RESOURCE_JS.'app.api.module.js');
define('APP_API_ANGJS_CTRL',APP_RESOURCE_JS.'app.api.controller.js');
define('APP_API_ANGJS_SERV',APP_RESOURCE_JS.'app.api.service.js');


define('APP_EXT_RESOURCES',
	[
		'VIDEO' => [
			'V001' => '//www.youtube-nocookie.com/embed/xadgZ4p2bHM?controls=0&amp;rel=0&amp;showinfo=0&amp;autohide=1&amp;iv_load_policy=3',
		],
		'MAPS'  => [
			'G001' => 'https://maps.googleapis.com/maps/api/js?key=AIzaSyCV1I_u6YyrmicpdvpYZHlintUZhcG_VDo',
		],
	]
);

define('EMAIL_SENDER','webmastersender@example.com');
define('EMAIL_WEBMASTER','webmaster@example.com');
define('EMAIL_HEADER',
	'From: '.EMAIL_WEBMASTER."\r\n".
	'Reply-To: '.EMAIL_WEBMASTER."\r\n".
	'X-Mailer: PHP/'
);
define('EMAIL_MESSAGE','
	Hell girls, 
	Name : :FNAME :LNAME

	:MSG
');


require_once(APP_MAIN);