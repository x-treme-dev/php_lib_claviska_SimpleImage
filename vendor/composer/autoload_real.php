<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInit8dded083eee3dd0c56b6eb7f26e4f80d
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        require __DIR__ . '/platform_check.php';

        spl_autoload_register(array('ComposerAutoloaderInit8dded083eee3dd0c56b6eb7f26e4f80d', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInit8dded083eee3dd0c56b6eb7f26e4f80d', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInit8dded083eee3dd0c56b6eb7f26e4f80d::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}
