<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit3be0920d98e4f888e974f45d364f70ee
{
    public static $files = array (
        '253c157292f75eb38082b5acb06f3f01' => __DIR__ . '/..' . '/nikic/fast-route/src/functions.php',
    );

    public static $prefixLengthsPsr4 = array (
        'q' => 
        array (
            'quiz\\' => 5,
        ),
        'F' => 
        array (
            'FastRoute\\' => 10,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'quiz\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
        'FastRoute\\' => 
        array (
            0 => __DIR__ . '/..' . '/nikic/fast-route/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit3be0920d98e4f888e974f45d364f70ee::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit3be0920d98e4f888e974f45d364f70ee::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit3be0920d98e4f888e974f45d364f70ee::$classMap;

        }, null, ClassLoader::class);
    }
}