<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit84526a1e036b234dfd25a631a1d664c8
{
    public static $prefixLengthsPsr4 = array (
        'G' => 
        array (
            'Guynoolla\\App\\' => 14,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Guynoolla\\App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit84526a1e036b234dfd25a631a1d664c8::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit84526a1e036b234dfd25a631a1d664c8::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit84526a1e036b234dfd25a631a1d664c8::$classMap;

        }, null, ClassLoader::class);
    }
}
