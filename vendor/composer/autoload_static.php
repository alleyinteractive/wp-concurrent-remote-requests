<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit327efefc4f16edf69fe400d60b12300e
{
    public static $files = array (
        '22177d82d05723dff5b1903f4496520e' => __DIR__ . '/..' . '/alleyinteractive/wordpress-autoloader/src/class-autoloader.php',
        'd0b4d9ff2237dcc1a532ae9d039c0c2c' => __DIR__ . '/..' . '/alleyinteractive/composer-wordpress-autoloader/src/autoload.php',
        '7b8a241a27a0fc0510afa7766b8d2d63' => __DIR__ . '/../..' . '/src/helpers.php',
    );

    public static $prefixLengthsPsr4 = array (
        'C' => 
        array (
            'ComposerWordPressAutoloader\\' => 28,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'ComposerWordPressAutoloader\\' => 
        array (
            0 => __DIR__ . '/..' . '/alleyinteractive/composer-wordpress-autoloader/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit327efefc4f16edf69fe400d60b12300e::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit327efefc4f16edf69fe400d60b12300e::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit327efefc4f16edf69fe400d60b12300e::$classMap;

        }, null, ClassLoader::class);
    }
}
