<?php

declare (strict_types=1);
namespace ECSPrefix202212\Symplify\EasyTesting\PHPUnit;

/**
 * @api
 */
final class StaticPHPUnitEnvironment
{
    /**
     * Never ever used static methods if not neccesary, this is just handy for tests + src to prevent duplication.
     */
    public static function isPHPUnitRun() : bool
    {
        return \defined('ECSPrefix202212\\PHPUNIT_COMPOSER_INSTALL') || \defined('ECSPrefix202212\\__PHPUNIT_PHAR__');
    }
}
