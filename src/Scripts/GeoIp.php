<?php

namespace LiveControls\AutoAddress\Scripts;

use GeoIp2\Database\Reader;
use Illuminate\Support\Facades\Cache;

class GeoIp
{
    private static function isUsable(): bool
    {
        return config('autoaddress.geoip2_enabled') && config('autoaddress.geoip2_database_path') && file_exists(config('autoaddress.geoip2_database_path'));
    }

    public static function getReader(bool $useCache = true, int $cacheTime = 3600): Reader
    {
        if(! self::isUsable()) {
            throw new \Exception('GeoIP2 is not usable. Please check your configuration.');
        }

        if(! $useCache) {
            return new Reader(config('autoaddress.geoip2_database_path'));
        }

        return Cache::remember('geoip2_reader', $cacheTime, function () {
            return new Reader(config('autoaddress.geoip2_database_path'));
        });
    }

    public static function getRecord(string $ipAddress, bool $useCache = true, int $cacheTime = 3600): ?\GeoIp2\Model\City
    {
        if(! self::isUsable()) {
            return null;
        }

        $reader = self::getReader();

        if($useCache) {
            $cacheKey = 'geoip2_record_' . md5($ipAddress);
            return Cache::remember($cacheKey, $cacheTime, function () use ($ipAddress, $reader) {
                try {
                    return $reader->city($ipAddress);
                } catch (\GeoIp2\Exception\AddressNotFoundException $e) {
                    return null;
                }
            });
        }

        try {
            return $reader->city($ipAddress);
        } catch (\GeoIp2\Exception\AddressNotFoundException $e) {
            return null;
        }
    }
}