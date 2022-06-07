<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInit26ecf2d67a2631794038819dd5aacf60
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

        spl_autoload_register(array('ComposerAutoloaderInit26ecf2d67a2631794038819dd5aacf60', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInit26ecf2d67a2631794038819dd5aacf60', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInit26ecf2d67a2631794038819dd5aacf60::getInitializer($loader));

        $loader->setClassMapAuthoritative(true);
        $loader->register(true);

        $includeFiles = \Composer\Autoload\ComposerStaticInit26ecf2d67a2631794038819dd5aacf60::$files;
        foreach ($includeFiles as $fileIdentifier => $file) {
            composerRequire26ecf2d67a2631794038819dd5aacf60($fileIdentifier, $file);
        }

        return $loader;
    }
}

/**
 * @param string $fileIdentifier
 * @param string $file
 * @return void
 */
function composerRequire26ecf2d67a2631794038819dd5aacf60($fileIdentifier, $file)
{
    if (empty($GLOBALS['__composer_autoload_files'][$fileIdentifier])) {
        $GLOBALS['__composer_autoload_files'][$fileIdentifier] = true;

        require $file;
    }
}
