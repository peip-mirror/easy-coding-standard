<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInita6972d575ac9ce55f770181356fc2dd0
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

        spl_autoload_register(array('ComposerAutoloaderInita6972d575ac9ce55f770181356fc2dd0', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInita6972d575ac9ce55f770181356fc2dd0', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInita6972d575ac9ce55f770181356fc2dd0::getInitializer($loader));

        $loader->setClassMapAuthoritative(true);
        $loader->register(true);

        $includeFiles = \Composer\Autoload\ComposerStaticInita6972d575ac9ce55f770181356fc2dd0::$files;
        foreach ($includeFiles as $fileIdentifier => $file) {
            composerRequirea6972d575ac9ce55f770181356fc2dd0($fileIdentifier, $file);
        }

        return $loader;
    }
}

/**
 * @param string $fileIdentifier
 * @param string $file
 * @return void
 */
function composerRequirea6972d575ac9ce55f770181356fc2dd0($fileIdentifier, $file)
{
    if (empty($GLOBALS['__composer_autoload_files'][$fileIdentifier])) {
        $GLOBALS['__composer_autoload_files'][$fileIdentifier] = true;

        require $file;
    }
}
