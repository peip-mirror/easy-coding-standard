<?php

declare (strict_types=1);
namespace ECSPrefix20220527;

use PhpCsFixer\Fixer\ArrayNotation\NoWhitespaceBeforeCommaInArrayFixer;
use PhpCsFixer\Fixer\ArrayNotation\WhitespaceAfterCommaInArrayFixer;
use PhpCsFixer\Fixer\Basic\BracesFixer;
use PhpCsFixer\Fixer\Basic\EncodingFixer;
use PhpCsFixer\Fixer\Casing\ConstantCaseFixer;
use PhpCsFixer\Fixer\Casing\LowercaseKeywordsFixer;
use PhpCsFixer\Fixer\CastNotation\LowercaseCastFixer;
use PhpCsFixer\Fixer\CastNotation\ShortScalarCastFixer;
use PhpCsFixer\Fixer\ClassNotation\ClassDefinitionFixer;
use PhpCsFixer\Fixer\ClassNotation\NoBlankLinesAfterClassOpeningFixer;
use PhpCsFixer\Fixer\ClassNotation\SingleClassElementPerStatementFixer;
use PhpCsFixer\Fixer\ClassNotation\VisibilityRequiredFixer;
use PhpCsFixer\Fixer\Comment\NoTrailingWhitespaceInCommentFixer;
use PhpCsFixer\Fixer\ControlStructure\ElseifFixer;
use PhpCsFixer\Fixer\ControlStructure\NoBreakCommentFixer;
use PhpCsFixer\Fixer\ControlStructure\SwitchCaseSemicolonToColonFixer;
use PhpCsFixer\Fixer\ControlStructure\SwitchCaseSpaceFixer;
use PhpCsFixer\Fixer\FunctionNotation\FunctionDeclarationFixer;
use PhpCsFixer\Fixer\FunctionNotation\MethodArgumentSpaceFixer;
use PhpCsFixer\Fixer\FunctionNotation\NoSpacesAfterFunctionNameFixer;
use PhpCsFixer\Fixer\FunctionNotation\ReturnTypeDeclarationFixer;
use PhpCsFixer\Fixer\Import\NoLeadingImportSlashFixer;
use PhpCsFixer\Fixer\Import\OrderedImportsFixer;
use PhpCsFixer\Fixer\Import\SingleImportPerStatementFixer;
use PhpCsFixer\Fixer\Import\SingleLineAfterImportsFixer;
use PhpCsFixer\Fixer\LanguageConstruct\DeclareEqualNormalizeFixer;
use PhpCsFixer\Fixer\NamespaceNotation\BlankLineAfterNamespaceFixer;
use PhpCsFixer\Fixer\Operator\BinaryOperatorSpacesFixer;
use PhpCsFixer\Fixer\Operator\ConcatSpaceFixer;
use PhpCsFixer\Fixer\Operator\NewWithBracesFixer;
use PhpCsFixer\Fixer\Operator\TernaryOperatorSpacesFixer;
use PhpCsFixer\Fixer\Operator\UnaryOperatorSpacesFixer;
use PhpCsFixer\Fixer\PhpTag\BlankLineAfterOpeningTagFixer;
use PhpCsFixer\Fixer\PhpTag\FullOpeningTagFixer;
use PhpCsFixer\Fixer\PhpTag\NoClosingTagFixer;
use PhpCsFixer\Fixer\Semicolon\NoSinglelineWhitespaceBeforeSemicolonsFixer;
use PhpCsFixer\Fixer\Whitespace\IndentationTypeFixer;
use PhpCsFixer\Fixer\Whitespace\LineEndingFixer;
use PhpCsFixer\Fixer\Whitespace\NoSpacesInsideParenthesisFixer;
use PhpCsFixer\Fixer\Whitespace\NoTrailingWhitespaceFixer;
use PhpCsFixer\Fixer\Whitespace\SingleBlankLineAtEofFixer;
use Symplify\EasyCodingStandard\Config\ECSConfig;
return static function (\Symplify\EasyCodingStandard\Config\ECSConfig $ecsConfig) : void {
    $ecsConfig->ruleWithConfiguration(\PhpCsFixer\Fixer\Import\OrderedImportsFixer::class, ['imports_order' => ['class', 'function', 'const']]);
    $ecsConfig->ruleWithConfiguration(\PhpCsFixer\Fixer\LanguageConstruct\DeclareEqualNormalizeFixer::class, ['space' => 'none']);
    $ecsConfig->ruleWithConfiguration(\PhpCsFixer\Fixer\Basic\BracesFixer::class, ['allow_single_line_closure' => \false, 'position_after_functions_and_oop_constructs' => 'next', 'position_after_control_structures' => 'same', 'position_after_anonymous_constructs' => 'same']);
    $ecsConfig->ruleWithConfiguration(\PhpCsFixer\Fixer\ClassNotation\VisibilityRequiredFixer::class, ['elements' => ['const', 'method', 'property']]);
    $ecsConfig->rules([\PhpCsFixer\Fixer\Operator\BinaryOperatorSpacesFixer::class, \PhpCsFixer\Fixer\NamespaceNotation\BlankLineAfterNamespaceFixer::class, \PhpCsFixer\Fixer\PhpTag\BlankLineAfterOpeningTagFixer::class, \PhpCsFixer\Fixer\ClassNotation\ClassDefinitionFixer::class, \PhpCsFixer\Fixer\Casing\ConstantCaseFixer::class, \PhpCsFixer\Fixer\ControlStructure\ElseifFixer::class, \PhpCsFixer\Fixer\Basic\EncodingFixer::class, \PhpCsFixer\Fixer\PhpTag\FullOpeningTagFixer::class, \PhpCsFixer\Fixer\FunctionNotation\FunctionDeclarationFixer::class, \PhpCsFixer\Fixer\Whitespace\IndentationTypeFixer::class, \PhpCsFixer\Fixer\Whitespace\LineEndingFixer::class, \PhpCsFixer\Fixer\CastNotation\LowercaseCastFixer::class, \PhpCsFixer\Fixer\Casing\LowercaseKeywordsFixer::class, \PhpCsFixer\Fixer\Operator\NewWithBracesFixer::class, \PhpCsFixer\Fixer\ClassNotation\NoBlankLinesAfterClassOpeningFixer::class, \PhpCsFixer\Fixer\ControlStructure\NoBreakCommentFixer::class, \PhpCsFixer\Fixer\PhpTag\NoClosingTagFixer::class, \PhpCsFixer\Fixer\Import\NoLeadingImportSlashFixer::class, \PhpCsFixer\Fixer\Semicolon\NoSinglelineWhitespaceBeforeSemicolonsFixer::class, \PhpCsFixer\Fixer\FunctionNotation\NoSpacesAfterFunctionNameFixer::class, \PhpCsFixer\Fixer\Whitespace\NoSpacesInsideParenthesisFixer::class, \PhpCsFixer\Fixer\Whitespace\NoTrailingWhitespaceFixer::class, \PhpCsFixer\Fixer\Comment\NoTrailingWhitespaceInCommentFixer::class, \PhpCsFixer\Fixer\ArrayNotation\NoWhitespaceBeforeCommaInArrayFixer::class, \PhpCsFixer\Fixer\FunctionNotation\ReturnTypeDeclarationFixer::class, \PhpCsFixer\Fixer\CastNotation\ShortScalarCastFixer::class, \PhpCsFixer\Fixer\Whitespace\SingleBlankLineAtEofFixer::class, \PhpCsFixer\Fixer\Import\SingleImportPerStatementFixer::class, \PhpCsFixer\Fixer\Import\SingleLineAfterImportsFixer::class, \PhpCsFixer\Fixer\ControlStructure\SwitchCaseSemicolonToColonFixer::class, \PhpCsFixer\Fixer\ControlStructure\SwitchCaseSpaceFixer::class, \PhpCsFixer\Fixer\Operator\TernaryOperatorSpacesFixer::class, \PhpCsFixer\Fixer\Operator\UnaryOperatorSpacesFixer::class, \PhpCsFixer\Fixer\ClassNotation\VisibilityRequiredFixer::class, \PhpCsFixer\Fixer\ArrayNotation\WhitespaceAfterCommaInArrayFixer::class]);
    $ecsConfig->ruleWithConfiguration(\PhpCsFixer\Fixer\FunctionNotation\MethodArgumentSpaceFixer::class, ['on_multiline' => 'ensure_fully_multiline']);
    $ecsConfig->ruleWithConfiguration(\PhpCsFixer\Fixer\ClassNotation\SingleClassElementPerStatementFixer::class, ['elements' => ['property']]);
    $ecsConfig->ruleWithConfiguration(\PhpCsFixer\Fixer\Operator\ConcatSpaceFixer::class, ['spacing' => 'one']);
    $ecsConfig->skip([\PhpCsFixer\Fixer\Import\SingleImportPerStatementFixer::class]);
};
