<?php
namespace Maenxi\Config;

class Config
{
    private static $config = [];
    private static $_instance;
    public static function getInstance()
    {
        if(!self::$_instance){
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    public function parser($sConfigPath)
    {
        $sConfigPath = rtrim($sConfigPath, DIRECTORY_SEPARATOR);
        if(!is_dir($sConfigPath)){
            throw new \Exception("{$sConfigPath} not a directory", -1);
        }

        $aFileList = scandir($sConfigPath);

        foreach($aFileList as $sFile){
            list($sFileName, $sFileSuffix) = explode('.', $sFile);
            if(!$sFileSuffix || $sFileSuffix !== 'php'){
                continue;
            }

            self::$config[$sFileName] = include($sConfigPath . DIRECTORY_SEPARATOR . $sFile);
        }

        return $this;
    }

    public function get($sKey = null)
    {
        $oKeys = explode('.', $sKey);
        $val = $oConfig = self::$config;
        foreach($oKeys as $item){
            if(!isset($oConfig[$item])){
                return null;
            }

            $val = $oConfig = $oConfig[$item];
        }

        return $val;
    }
}