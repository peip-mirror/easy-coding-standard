<?php

declare (strict_types=1);
namespace Symplify\CodingStandard\TokenRunner\DocBlock\MalformWorker;

use ECSPrefix20210801\Nette\Utils\Strings;
use PhpCsFixer\Tokenizer\Token;
use PhpCsFixer\Tokenizer\Tokens;
use Symplify\CodingStandard\TokenRunner\Contract\DocBlock\MalformWorkerInterface;
final class InlineVarMalformWorker implements \Symplify\CodingStandard\TokenRunner\Contract\DocBlock\MalformWorkerInterface
{
    /**
     * @var string
     * @see https://regex101.com/r/cj95e6/1
     */
    const SINGLE_ASTERISK_START_REGEX = '#^/\\*(\\n?\\s+@(?:psalm-|phpstan-)?var)#';
    /**
     * @param Tokens<Token> $tokens
     * @param string $docContent
     * @param int $position
     */
    public function work($docContent, $tokens, $position) : string
    {
        /** @var Token $token */
        $token = $tokens[$position];
        if (!$token->isGivenKind(\T_COMMENT)) {
            return $docContent;
        }
        return \ECSPrefix20210801\Nette\Utils\Strings::replace($docContent, self::SINGLE_ASTERISK_START_REGEX, '/**$1');
    }
}
