<?php

declare (strict_types=1);
namespace ECSPrefix20220527\Symplify\RuleDocGenerator\Contract\Category;

use ECSPrefix20220527\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
interface CategoryInfererInterface
{
    public function infer(\ECSPrefix20220527\Symplify\RuleDocGenerator\ValueObject\RuleDefinition $ruleDefinition) : ?string;
}
