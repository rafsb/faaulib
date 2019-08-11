<?php
define("DEBUG",  false);

class App {
    private static $config = [
        "devel"                     => "Spume DEV Team"
        , "project_name"            => "SpumeMobileApi"
        , "driver"                  => DISK
        , "get_config_min_level"    => MANAGER
        , "hash_algorithm"          => SHA512
        , "database_credentials"    => [
            "host"      => "127.0.0.1"
            , "username"  => "root"
            , "passwd"    => "root"
            , "database"  => "test"
            , "encoding"  => "utf8"
        ]
    ];

    private static $datasources = [
        
        "default"  => []
        
    ];

    public static function connections($datasource=DEFAULT_DB){
        $tmp = isset(self::$datasources[$datasource]) ? self::$datasources[$datasource] : [];
        if(!isset($tmp["host"]))     $tmp["host"]     = self::config["database_credentials"][$host];
        if(!isset($tmp["username"])) $tmp["username"] = self::config["database_credentials"][$username];
        if(!isset($tmp["passwd"]))   $tmp["passwd"]   = self::config["database_credentials"][$passwd];
        if(!isset($tmp["database"])) $tmp["database"] = self::config["database_credentials"][$database];
        if(!isset($tmp["encoding"])) $tmp["encoding"] = self::config["database_credentials"][$encoding];
        return $tmp;
    }

    public function driver($drv=null){
        return $drv ? ($drv==self::config("driver") ? true : false) : self::config("driver");
    }
    
	public static  function config($field=null){
		if($field && isset(self::$config[$field])) return self::$config[$field];
		return User::level(self::$config["get_config_min_level"]) ? self::$config : null;
	}

	public static function devel(){ return App::config("developer"); }

	public static function project_name(){ return App::config("project_name"); }

	public static function init(){ if(User::logged()) (new Dash)->render(); else (new Login)->render(); }
}
