<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit24887e3b83ed7f03e127d3924b575b05
{
    public static $prefixLengthsPsr4 = array (
        'A' => 
        array (
            'App\\Schema\\' => 11,
            'AbieSoft\\Application\\' => 21,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'App\\Schema\\' => 
        array (
            0 => __DIR__ . '/../..' . '/schema',
        ),
        'AbieSoft\\Application\\' => 
        array (
            0 => __DIR__ . '/..' . '/abiesoft',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit24887e3b83ed7f03e127d3924b575b05::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit24887e3b83ed7f03e127d3924b575b05::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit24887e3b83ed7f03e127d3924b575b05::$classMap;

        }, null, ClassLoader::class);
    }
}