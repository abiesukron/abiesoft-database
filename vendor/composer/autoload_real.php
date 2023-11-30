<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInit24887e3b83ed7f03e127d3924b575b05
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

        spl_autoload_register(array('ComposerAutoloaderInit24887e3b83ed7f03e127d3924b575b05', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInit24887e3b83ed7f03e127d3924b575b05', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInit24887e3b83ed7f03e127d3924b575b05::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}
