<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit9662302d8cbe52ef7d0e589717a5e1b6
{
    public static $prefixLengthsPsr4 = array (
        'C' => 
        array (
            'Core\\' => 5,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Core\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src/classes/Core',
        ),
    );

    public static $classMap = array (
        'Core\\Item\\Craft' => __DIR__ . '/../..' . '/src/classes/Core/Item/Craft.php',
        'Core\\Item\\CraftsList' => __DIR__ . '/../..' . '/src/classes/Core/Item/CraftsList.php',
        'Core\\Item\\Item' => __DIR__ . '/../..' . '/src/classes/Core/Item/Item.php',
        'Core\\Item\\ItemIconList' => __DIR__ . '/../..' . '/src/classes/Core/Item/ItemIconList.php',
        'Core\\Item\\Reagent' => __DIR__ . '/../..' . '/src/classes/Core/Item/Reagent.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit9662302d8cbe52ef7d0e589717a5e1b6::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit9662302d8cbe52ef7d0e589717a5e1b6::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit9662302d8cbe52ef7d0e589717a5e1b6::$classMap;

        }, null, ClassLoader::class);
    }
}
