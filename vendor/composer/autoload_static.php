<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitcd7f6f96279715dae11f6f02c575f74c
{
    public static $prefixLengthsPsr4 = array (
        'O' => 
        array (
            'OneTUI\\' => 7,
        ),
        'K' => 
        array (
            'Klein\\' => 6,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'OneTUI\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src/OneTUI',
        ),
        'Klein\\' => 
        array (
            0 => __DIR__ . '/..' . '/klein/klein/src/Klein',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitcd7f6f96279715dae11f6f02c575f74c::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitcd7f6f96279715dae11f6f02c575f74c::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitcd7f6f96279715dae11f6f02c575f74c::$classMap;

        }, null, ClassLoader::class);
    }
}
