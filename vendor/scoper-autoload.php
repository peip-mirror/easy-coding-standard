<?php

// scoper-autoload.php @generated by PhpScoper

$loader = require_once __DIR__.'/autoload.php';

// Aliases for the whitelisted classes. For more information see:
// https://github.com/humbug/php-scoper/blob/master/README.md#class-whitelisting
if (!class_exists('AutoloadIncluder', false) && !interface_exists('AutoloadIncluder', false) && !trait_exists('AutoloadIncluder', false)) {
    spl_autoload_call('ECSPrefix20210521\AutoloadIncluder');
}
if (!class_exists('ComposerAutoloaderInitd11cf0c75d5ac6eb75bd8f8746c72016', false) && !interface_exists('ComposerAutoloaderInitd11cf0c75d5ac6eb75bd8f8746c72016', false) && !trait_exists('ComposerAutoloaderInitd11cf0c75d5ac6eb75bd8f8746c72016', false)) {
    spl_autoload_call('ECSPrefix20210521\ComposerAutoloaderInitd11cf0c75d5ac6eb75bd8f8746c72016');
}
if (!class_exists('Symfony\Component\DependencyInjection\Extension\ExtensionInterface', false) && !interface_exists('Symfony\Component\DependencyInjection\Extension\ExtensionInterface', false) && !trait_exists('Symfony\Component\DependencyInjection\Extension\ExtensionInterface', false)) {
    spl_autoload_call('ECSPrefix20210521\Symfony\Component\DependencyInjection\Extension\ExtensionInterface');
}
if (!class_exists('Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator', false) && !interface_exists('Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator', false) && !trait_exists('Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator', false)) {
    spl_autoload_call('ECSPrefix20210521\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator');
}
if (!class_exists('Normalizer', false) && !interface_exists('Normalizer', false) && !trait_exists('Normalizer', false)) {
    spl_autoload_call('ECSPrefix20210521\Normalizer');
}
if (!class_exists('JsonException', false) && !interface_exists('JsonException', false) && !trait_exists('JsonException', false)) {
    spl_autoload_call('ECSPrefix20210521\JsonException');
}
if (!class_exists('Attribute', false) && !interface_exists('Attribute', false) && !trait_exists('Attribute', false)) {
    spl_autoload_call('ECSPrefix20210521\Attribute');
}
if (!class_exists('Stringable', false) && !interface_exists('Stringable', false) && !trait_exists('Stringable', false)) {
    spl_autoload_call('ECSPrefix20210521\Stringable');
}
if (!class_exists('UnhandledMatchError', false) && !interface_exists('UnhandledMatchError', false) && !trait_exists('UnhandledMatchError', false)) {
    spl_autoload_call('ECSPrefix20210521\UnhandledMatchError');
}
if (!class_exists('ValueError', false) && !interface_exists('ValueError', false) && !trait_exists('ValueError', false)) {
    spl_autoload_call('ECSPrefix20210521\ValueError');
}

// Functions whitelisting. For more information see:
// https://github.com/humbug/php-scoper/blob/master/README.md#functions-whitelisting
if (!function_exists('composerRequired11cf0c75d5ac6eb75bd8f8746c72016')) {
    function composerRequired11cf0c75d5ac6eb75bd8f8746c72016() {
        return \ECSPrefix20210521\composerRequired11cf0c75d5ac6eb75bd8f8746c72016(...func_get_args());
    }
}
if (!function_exists('sample')) {
    function sample() {
        return \ECSPrefix20210521\sample(...func_get_args());
    }
}
if (!function_exists('foo')) {
    function foo() {
        return \ECSPrefix20210521\foo(...func_get_args());
    }
}
if (!function_exists('bar')) {
    function bar() {
        return \ECSPrefix20210521\bar(...func_get_args());
    }
}
if (!function_exists('baz')) {
    function baz() {
        return \ECSPrefix20210521\baz(...func_get_args());
    }
}
if (!function_exists('xyz')) {
    function xyz() {
        return \ECSPrefix20210521\xyz(...func_get_args());
    }
}
if (!function_exists('printPHPCodeSnifferTestOutput')) {
    function printPHPCodeSnifferTestOutput() {
        return \ECSPrefix20210521\printPHPCodeSnifferTestOutput(...func_get_args());
    }
}
if (!function_exists('setproctitle')) {
    function setproctitle() {
        return \ECSPrefix20210521\setproctitle(...func_get_args());
    }
}
if (!function_exists('includeIfExists')) {
    function includeIfExists() {
        return \ECSPrefix20210521\includeIfExists(...func_get_args());
    }
}
if (!function_exists('dump')) {
    function dump() {
        return \ECSPrefix20210521\dump(...func_get_args());
    }
}
if (!function_exists('dd')) {
    function dd() {
        return \ECSPrefix20210521\dd(...func_get_args());
    }
}

return $loader;
