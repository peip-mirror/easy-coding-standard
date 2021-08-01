<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ECSPrefix20210801\Symfony\Component\DependencyInjection\Loader\Configurator;

use ECSPrefix20210801\Symfony\Component\DependencyInjection\Alias;
/**
 * @author Nicolas Grekas <p@tchwork.com>
 */
class AliasConfigurator extends \ECSPrefix20210801\Symfony\Component\DependencyInjection\Loader\Configurator\AbstractServiceConfigurator
{
    use Traits\DeprecateTrait;
    use Traits\PublicTrait;
    const FACTORY = 'alias';
    public function __construct(\ECSPrefix20210801\Symfony\Component\DependencyInjection\Loader\Configurator\ServicesConfigurator $parent, \ECSPrefix20210801\Symfony\Component\DependencyInjection\Alias $alias)
    {
        $this->parent = $parent;
        $this->definition = $alias;
    }
}
