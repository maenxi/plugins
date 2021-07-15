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

    /**
     * @desc 设置配置文件路径
     * @param $sConfigPath string 绝对路径
     * @return $this
     * */
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

    /**
     * @desc 获取配置
     * @param $sConfigKey string
     * @return mixed
     * */
    public function get($sConfigKey = null)
    {
        if($sConfigKey && !is_string($sConfigKey)){
            throw new \Exception("param not a string", -1);
        }
        $oKeys = $sConfigKey ? explode('.', $sConfigKey) : [];
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