<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ECSPrefix20210619\Symfony\Component\Console\Attribute;

/**
 * Service tag to autoconfigure commands.
 * @Attribute
 */
class AsCommand
{
    /**
     * @var string
     */
    public $name;
    /**
     * @var string|null
     */
    public $description;
    /**
     * @param string|null $description
     */
    public function __construct(string $name, $description = null, array $aliases = [], bool $hidden = \false)
    {
        $this->name = $name;
        $this->description = $description;
        if (!$hidden && !$aliases) {
            return;
        }
        $name = \explode('|', $name);
        $name = \array_merge($name, $aliases);
        if ($hidden && '' !== $name[0]) {
            \array_unshift($name, '');
        }
        $this->name = \implode('|', $name);
    }
}
