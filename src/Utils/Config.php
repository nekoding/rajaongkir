<?php

namespace Nekoding\Rajaongkir\Utils;

class Config
{

    const STARTER = "starter";
    const BASIC = "basic";
    const PRO = "pro";

    protected static $apiKey;
    protected static $apiMode = "starter";

    /**
     * set rajaongkir api key
     *
     * @param  string $apiKey
     * @return void
     */
    public static function setApiKey(string $apiKey)
    {
        self::$apiKey = $apiKey;
    }

    /**
     * get rajaongkir api key
     *
     * @return string
     */
    public static function getApiKey(): string
    {
        return self::$apiKey;
    }

    /**
     * set rajaongkir api mode
     *
     * @param  mixed $apiMode
     * @return void
     */
    public static function setApiMode(string $apiMode)
    {
        self::$apiMode = $apiMode;
    }

    /**
     * get rajaongkir api mode
     *
     * @return string
     */
    public static function getApiMode(): string
    {
        return self::$apiMode;
    }
}
