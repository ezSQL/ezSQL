<?php

declare(strict_types=1);

namespace ezsql;

use ezsql\DInjector;
use function ezsql\functions\setInstance;

class Database
{
    /**
     * Timestamp for benchmark.
     *
     * @var float
     */
    private static $_ts = null;
    private static $factory = null;
    private static $instances = [];

    private function __construct()
    {
    }
    private function __clone()
    {
    }
    public function __wakeup()
    {
    }

    /**
     * Initialize and connect a vendor database.
     *
     * @param string $vendor SQL driver
     * @param array $setting SQL connection parameters
     * @param string $tag Store the instance for later use
     * @return Database\ez_pdo|Database\ez_pgsql|Database\ez_sqlsrv|Database\ez_sqlite3|Database\ez_mysqli
     */
    public static function initialize(?string $vendor = null, ?array $setting = null, ?string $tag = null)
    {
        if (isset(self::$instances[$vendor]) && empty($setting) && empty($tag))
            return setInstance(self::$instances[$vendor]) ? self::$instances[$vendor] : false;

        if (empty($vendor) || empty($setting)) {
            throw new \Exception(\MISSING_CONFIGURATION);
        } else {
            self::$_ts = \microtime(true);
            $key = $vendor;
            $value = \VENDOR[$key];

            if (empty($GLOBALS['ez' . $key]) || !empty($tag)) {
                $di = new DInjector();
                $di->set($key, $value);
                $di->set('ezsql\ConfigInterface', 'ezsql\Config');
                $instance = $di->get($key, ['driver' => $key, 'arguments' => $setting]);
                if (!empty($tag)) {
                    self::$instances[$tag] = $instance;
                    return $instance;
                }
            }

            setInstance($GLOBALS['ez' . $key]);
            return $GLOBALS['ez' . $key];
        }
    }

    /**
     * Print-out a memory used benchmark.
     *
     * @return array|float time elapsed, memory usage.
     */
    public static function benchmark()
    {
        return [
            'start'  => self::$_ts,
            'elapse' => \microtime(true) - self::$_ts,
            'memory' => \memory_get_usage(true),
        ];
    }
}
