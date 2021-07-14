<?php
namespace Maenxi\Config;

class Config
{
    public static $config = [];
    private static $_instance;
    public static function getInstance()
    {
        if(!self::$_instance){
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    public function parser(string $sConfigPath)
    {
        $sConfigPath = rtrim($sConfigPath, DIRECTORY_SEPARATOR);
        if(is_dir($sConfigPath)){
            throw new \Exception("{$sConfigPath} is not dir", -1);
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

    public function get(string $sKey)
    {
        $val = null;
        $oKeys = explode('.', $sKey);
        $oConfig = self::$config;
        foreach($oKeys as $item){
            if(!isset($oConfig[$item])){
                return null;
            }

            $val = $oConfig = $oConfig[$item];
        }

        return $val;
    }
}