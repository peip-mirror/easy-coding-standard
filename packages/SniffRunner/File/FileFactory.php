<?php

declare (strict_types=1);
namespace Symplify\EasyCodingStandard\SniffRunner\File;

use PHP_CodeSniffer\Fixer;
use Symplify\EasyCodingStandard\Application\AppliedCheckersCollector;
use Symplify\EasyCodingStandard\Console\Style\EasyCodingStandardStyle;
use Symplify\EasyCodingStandard\SniffRunner\ValueObject\File;
use ECSPrefix20210619\Symplify\Skipper\Skipper\Skipper;
use ECSPrefix20210619\Symplify\SmartFileSystem\SmartFileInfo;
/**
 * @see \Symplify\EasyCodingStandard\Tests\SniffRunner\File\FileFactoryTest
 */
final class FileFactory
{
    /**
     * @var \PHP_CodeSniffer\Fixer
     */
    private $fixer;
    /**
     * @var \Symplify\Skipper\Skipper\Skipper
     */
    private $skipper;
    /**
     * @var \Symplify\EasyCodingStandard\Application\AppliedCheckersCollector
     */
    private $appliedCheckersCollector;
    /**
     * @var \Symplify\EasyCodingStandard\Console\Style\EasyCodingStandardStyle
     */
    private $easyCodingStandardStyle;
    public function __construct(\PHP_CodeSniffer\Fixer $fixer, \ECSPrefix20210619\Symplify\Skipper\Skipper\Skipper $skipper, \Symplify\EasyCodingStandard\Application\AppliedCheckersCollector $appliedCheckersCollector, \Symplify\EasyCodingStandard\Console\Style\EasyCodingStandardStyle $easyCodingStandardStyle)
    {
        $this->fixer = $fixer;
        $this->skipper = $skipper;
        $this->appliedCheckersCollector = $appliedCheckersCollector;
        $this->easyCodingStandardStyle = $easyCodingStandardStyle;
    }
    public function createFromFileInfo(\ECSPrefix20210619\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : \Symplify\EasyCodingStandard\SniffRunner\ValueObject\File
    {
        return new \Symplify\EasyCodingStandard\SniffRunner\ValueObject\File($smartFileInfo->getRelativeFilePath(), $smartFileInfo->getContents(), $this->fixer, $this->skipper, $this->appliedCheckersCollector, $this->easyCodingStandardStyle);
    }
}
