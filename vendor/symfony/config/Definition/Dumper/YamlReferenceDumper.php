<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ECSPrefix20210801\Symfony\Component\Config\Definition\Dumper;

use ECSPrefix20210801\Symfony\Component\Config\Definition\ArrayNode;
use ECSPrefix20210801\Symfony\Component\Config\Definition\BaseNode;
use ECSPrefix20210801\Symfony\Component\Config\Definition\ConfigurationInterface;
use ECSPrefix20210801\Symfony\Component\Config\Definition\EnumNode;
use ECSPrefix20210801\Symfony\Component\Config\Definition\NodeInterface;
use ECSPrefix20210801\Symfony\Component\Config\Definition\PrototypedArrayNode;
use ECSPrefix20210801\Symfony\Component\Config\Definition\ScalarNode;
use ECSPrefix20210801\Symfony\Component\Config\Definition\VariableNode;
use ECSPrefix20210801\Symfony\Component\Yaml\Inline;
/**
 * Dumps a Yaml reference configuration for the given configuration/node instance.
 *
 * @author Kevin Bond <kevinbond@gmail.com>
 */
class YamlReferenceDumper
{
    private $reference;
    /**
     * @param \Symfony\Component\Config\Definition\ConfigurationInterface $configuration
     */
    public function dump($configuration)
    {
        return $this->dumpNode($configuration->getConfigTreeBuilder()->buildTree());
    }
    /**
     * @param \Symfony\Component\Config\Definition\ConfigurationInterface $configuration
     * @param string $path
     */
    public function dumpAtPath($configuration, $path)
    {
        $rootNode = $node = $configuration->getConfigTreeBuilder()->buildTree();
        foreach (\explode('.', $path) as $step) {
            if (!$node instanceof \ECSPrefix20210801\Symfony\Component\Config\Definition\ArrayNode) {
                throw new \UnexpectedValueException(\sprintf('Unable to find node at path "%s.%s".', $rootNode->getName(), $path));
            }
            /** @var NodeInterface[] $children */
            $children = $node instanceof \ECSPrefix20210801\Symfony\Component\Config\Definition\PrototypedArrayNode ? $this->getPrototypeChildren($node) : $node->getChildren();
            foreach ($children as $child) {
                if ($child->getName() === $step) {
                    $node = $child;
                    continue 2;
                }
            }
            throw new \UnexpectedValueException(\sprintf('Unable to find node at path "%s.%s".', $rootNode->getName(), $path));
        }
        return $this->dumpNode($node);
    }
    /**
     * @param \Symfony\Component\Config\Definition\NodeInterface $node
     */
    public function dumpNode($node)
    {
        $this->reference = '';
        $this->writeNode($node);
        $ref = $this->reference;
        $this->reference = null;
        return $ref;
    }
    private function writeNode(\ECSPrefix20210801\Symfony\Component\Config\Definition\NodeInterface $node, \ECSPrefix20210801\Symfony\Component\Config\Definition\NodeInterface $parentNode = null, int $depth = 0, bool $prototypedArray = \false)
    {
        $comments = [];
        $default = '';
        $defaultArray = null;
        $children = null;
        $example = null;
        if ($node instanceof \ECSPrefix20210801\Symfony\Component\Config\Definition\BaseNode) {
            $example = $node->getExample();
        }
        // defaults
        if ($node instanceof \ECSPrefix20210801\Symfony\Component\Config\Definition\ArrayNode) {
            $children = $node->getChildren();
            if ($node instanceof \ECSPrefix20210801\Symfony\Component\Config\Definition\PrototypedArrayNode) {
                $children = $this->getPrototypeChildren($node);
            }
            if (!$children) {
                if ($node->hasDefaultValue() && \count($defaultArray = $node->getDefaultValue())) {
                    $default = '';
                } elseif (!\is_array($example)) {
                    $default = '[]';
                }
            }
        } elseif ($node instanceof \ECSPrefix20210801\Symfony\Component\Config\Definition\EnumNode) {
            $comments[] = 'One of ' . \implode('; ', \array_map('json_encode', $node->getValues()));
            $default = $node->hasDefaultValue() ? \ECSPrefix20210801\Symfony\Component\Yaml\Inline::dump($node->getDefaultValue()) : '~';
        } elseif (\ECSPrefix20210801\Symfony\Component\Config\Definition\VariableNode::class === \get_class($node) && \is_array($example)) {
            // If there is an array example, we are sure we dont need to print a default value
            $default = '';
        } else {
            $default = '~';
            if ($node->hasDefaultValue()) {
                $default = $node->getDefaultValue();
                if (\is_array($default)) {
                    if (\count($defaultArray = $node->getDefaultValue())) {
                        $default = '';
                    } elseif (!\is_array($example)) {
                        $default = '[]';
                    }
                } else {
                    $default = \ECSPrefix20210801\Symfony\Component\Yaml\Inline::dump($default);
                }
            }
        }
        // required?
        if ($node->isRequired()) {
            $comments[] = 'Required';
        }
        // deprecated?
        if ($node instanceof \ECSPrefix20210801\Symfony\Component\Config\Definition\BaseNode && $node->isDeprecated()) {
            $deprecation = $node->getDeprecation($node->getName(), $parentNode ? $parentNode->getPath() : $node->getPath());
            $comments[] = \sprintf('Deprecated (%s)', ($deprecation['package'] || $deprecation['version'] ? "Since {$deprecation['package']} {$deprecation['version']}: " : '') . $deprecation['message']);
        }
        // example
        if ($example && !\is_array($example)) {
            $comments[] = 'Example: ' . \ECSPrefix20210801\Symfony\Component\Yaml\Inline::dump($example);
        }
        $default = '' != (string) $default ? ' ' . $default : '';
        $comments = \count($comments) ? '# ' . \implode(', ', $comments) : '';
        $key = $prototypedArray ? '-' : $node->getName() . ':';
        $text = \rtrim(\sprintf('%-21s%s %s', $key, $default, $comments), ' ');
        if ($node instanceof \ECSPrefix20210801\Symfony\Component\Config\Definition\BaseNode && ($info = $node->getInfo())) {
            $this->writeLine('');
            // indenting multi-line info
            $info = \str_replace("\n", \sprintf("\n%" . $depth * 4 . 's# ', ' '), $info);
            $this->writeLine('# ' . $info, $depth * 4);
        }
        $this->writeLine($text, $depth * 4);
        // output defaults
        if ($defaultArray) {
            $this->writeLine('');
            $message = \count($defaultArray) > 1 ? 'Defaults' : 'Default';
            $this->writeLine('# ' . $message . ':', $depth * 4 + 4);
            $this->writeArray($defaultArray, $depth + 1);
        }
        if (\is_array($example)) {
            $this->writeLine('');
            $message = \count($example) > 1 ? 'Examples' : 'Example';
            $this->writeLine('# ' . $message . ':', $depth * 4 + 4);
            $this->writeArray(\array_map([\ECSPrefix20210801\Symfony\Component\Yaml\Inline::class, 'dump'], $example), $depth + 1);
        }
        if ($children) {
            foreach ($children as $childNode) {
                $this->writeNode($childNode, $node, $depth + 1, $node instanceof \ECSPrefix20210801\Symfony\Component\Config\Definition\PrototypedArrayNode && !$node->getKeyAttribute());
            }
        }
    }
    /**
     * Outputs a single config reference line.
     */
    private function writeLine(string $text, int $indent = 0)
    {
        $indent = \strlen($text) + $indent;
        $format = '%' . $indent . 's';
        $this->reference .= \sprintf($format, $text) . "\n";
    }
    private function writeArray(array $array, int $depth)
    {
        $isIndexed = \array_values($array) === $array;
        foreach ($array as $key => $value) {
            if (\is_array($value)) {
                $val = '';
            } else {
                $val = $value;
            }
            if ($isIndexed) {
                $this->writeLine('- ' . $val, $depth * 4);
            } else {
                $this->writeLine(\sprintf('%-20s %s', $key . ':', $val), $depth * 4);
            }
            if (\is_array($value)) {
                $this->writeArray($value, $depth + 1);
            }
        }
    }
    private function getPrototypeChildren(\ECSPrefix20210801\Symfony\Component\Config\Definition\PrototypedArrayNode $node) : array
    {
        $prototype = $node->getPrototype();
        $key = $node->getKeyAttribute();
        // Do not expand prototype if it isn't an array node nor uses attribute as key
        if (!$key && !$prototype instanceof \ECSPrefix20210801\Symfony\Component\Config\Definition\ArrayNode) {
            return $node->getChildren();
        }
        if ($prototype instanceof \ECSPrefix20210801\Symfony\Component\Config\Definition\ArrayNode) {
            $keyNode = new \ECSPrefix20210801\Symfony\Component\Config\Definition\ArrayNode($key, $node);
            $children = $prototype->getChildren();
            if ($prototype instanceof \ECSPrefix20210801\Symfony\Component\Config\Definition\PrototypedArrayNode && $prototype->getKeyAttribute()) {
                $children = $this->getPrototypeChildren($prototype);
            }
            // add children
            foreach ($children as $childNode) {
                $keyNode->addChild($childNode);
            }
        } else {
            $keyNode = new \ECSPrefix20210801\Symfony\Component\Config\Definition\ScalarNode($key, $node);
        }
        $info = 'Prototype';
        if (null !== $prototype->getInfo()) {
            $info .= ': ' . $prototype->getInfo();
        }
        $keyNode->setInfo($info);
        return [$key => $keyNode];
    }
}
