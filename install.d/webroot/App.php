<?php
define("DEBUG", true);

class App {
    private static $host = "10.150.158.227";
    private static $username = "spume";
    private static $passwd = "spume3224$";
    private static $database = "users";
    private static $encoding = "utf8";

    public static $hash_algo = "sha512";
    public static $datasources = [
        "default"  => []
        , "dash"  => [ "database" => "sp_history_dashboard" ]
    ];

    public static function connections($datasource=DEFAULT_DB){
        $tmp = isset(self::$datasources[$datasource]) ? self::$datasources[$datasource] : [];
        if($tmp){
            if(!isset($tmp["host"]))     $tmp["host"]     = self::$host;
            if(!isset($tmp["username"])) $tmp["username"] = self::$username;
            if(!isset($tmp["passwd"]))   $tmp["passwd"]   = self::$passwd;
            if(!isset($tmp["database"])) $tmp["database"] = self::$database;
            if(!isset($tmp["encoding"])) $tmp["encoding"] = self::$encoding;
        }
        return $tmp;
    }

	public static  function config($field=null){
		$_CONFIG = IO::jout("/etc/project.json");
		if($field && isset($_CONFIG->{$field})) return $_CONFIG->{$field};
		return $_CONFIG;
	}

	public static function devel(){ return App::config("developer"); }

	public static function project_name(){ return App::config("project_name"); }

	public static function init(){ if(User::logged()) (new Dash)->render(); else (new Login)->render(); }
}
