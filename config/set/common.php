<?php

declare (strict_types=1);
namespace ECSPrefix202212;

use Symplify\EasyCodingStandard\Config\ECSConfig;
return static function (ECSConfig $ecsConfig) : void {
    $ecsConfig->import(__DIR__ . '/common/*.php');
};
