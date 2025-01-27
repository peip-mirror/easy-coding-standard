<?php

declare (strict_types=1);
namespace Symplify\EasyCodingStandard\Skipper\Skipper;

use Symplify\EasyCodingStandard\Skipper\Matcher\FileInfoMatcher;
use ECSPrefix202212\Symplify\SmartFileSystem\SmartFileInfo;
/**
 * @see \Symplify\EasyCodingStandard\Tests\Skipper\Skipper\Skip\SkipSkipperTest
 */
final class SkipSkipper
{
    /**
     * @var \Symplify\EasyCodingStandard\Skipper\Matcher\FileInfoMatcher
     */
    private $fileInfoMatcher;
    public function __construct(FileInfoMatcher $fileInfoMatcher)
    {
        $this->fileInfoMatcher = $fileInfoMatcher;
    }
    /**
     * @param array<string, string[]|null> $skippedClasses
     * @param object|string $checker
     * @param \Symplify\SmartFileSystem\SmartFileInfo|string $file
     */
    public function doesMatchSkip($checker, $file, array $skippedClasses) : bool
    {
        foreach ($skippedClasses as $skippedClass => $skippedFiles) {
            if (!\is_a($checker, $skippedClass, \true)) {
                continue;
            }
            // skip everywhere
            if (!\is_array($skippedFiles)) {
                return \true;
            }
            if ($this->fileInfoMatcher->doesFileInfoMatchPatterns($file, $skippedFiles)) {
                return \true;
            }
        }
        return \false;
    }
}
