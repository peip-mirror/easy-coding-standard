<?php

declare (strict_types=1);
namespace ECSPrefix202212;

use ECSPrefix202212\Symplify\EasyTesting\Kernel\EasyTestingKernel;
use ECSPrefix202212\Symplify\SymplifyKernel\ValueObject\KernelBootAndApplicationRun;
$possibleAutoloadPaths = [
    // dependency
    __DIR__ . '/../../../autoload.php',
    // after split package
    __DIR__ . '/../vendor/autoload.php',
    // monorepo
    __DIR__ . '/../../../vendor/autoload.php',
];
foreach ($possibleAutoloadPaths as $possibleAutoloadPath) {
    if (\file_exists($possibleAutoloadPath)) {
        require_once $possibleAutoloadPath;
        break;
    }
}
$kernelBootAndApplicationRun = new KernelBootAndApplicationRun(EasyTestingKernel::class);
$kernelBootAndApplicationRun->run();
