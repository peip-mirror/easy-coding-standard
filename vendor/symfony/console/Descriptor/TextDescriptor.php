<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ECSPrefix20220418\Symfony\Component\Console\Descriptor;

use ECSPrefix20220418\Symfony\Component\Console\Application;
use ECSPrefix20220418\Symfony\Component\Console\Command\Command;
use ECSPrefix20220418\Symfony\Component\Console\Formatter\OutputFormatter;
use ECSPrefix20220418\Symfony\Component\Console\Helper\Helper;
use ECSPrefix20220418\Symfony\Component\Console\Input\InputArgument;
use ECSPrefix20220418\Symfony\Component\Console\Input\InputDefinition;
use ECSPrefix20220418\Symfony\Component\Console\Input\InputOption;
/**
 * Text descriptor.
 *
 * @author Jean-François Simon <contact@jfsimon.fr>
 *
 * @internal
 */
class TextDescriptor extends \ECSPrefix20220418\Symfony\Component\Console\Descriptor\Descriptor
{
    /**
     * {@inheritdoc}
     */
    protected function describeInputArgument(\ECSPrefix20220418\Symfony\Component\Console\Input\InputArgument $argument, array $options = [])
    {
        if (null !== $argument->getDefault() && (!\is_array($argument->getDefault()) || \count($argument->getDefault()))) {
            $default = \sprintf('<comment> [default: %s]</comment>', $this->formatDefaultValue($argument->getDefault()));
        } else {
            $default = '';
        }
        $totalWidth = $options['total_width'] ?? \ECSPrefix20220418\Symfony\Component\Console\Helper\Helper::width($argument->getName());
        $spacingWidth = $totalWidth - \strlen($argument->getName());
        $this->writeText(\sprintf(
            '  <info>%s</info>  %s%s%s',
            $argument->getName(),
            \str_repeat(' ', $spacingWidth),
            // + 4 = 2 spaces before <info>, 2 spaces after </info>
            \preg_replace('/\\s*[\\r\\n]\\s*/', "\n" . \str_repeat(' ', $totalWidth + 4), $argument->getDescription()),
            $default
        ), $options);
    }
    /**
     * {@inheritdoc}
     */
    protected function describeInputOption(\ECSPrefix20220418\Symfony\Component\Console\Input\InputOption $option, array $options = [])
    {
        if ($option->acceptValue() && null !== $option->getDefault() && (!\is_array($option->getDefault()) || \count($option->getDefault()))) {
            $default = \sprintf('<comment> [default: %s]</comment>', $this->formatDefaultValue($option->getDefault()));
        } else {
            $default = '';
        }
        $value = '';
        if ($option->acceptValue()) {
            $value = '=' . \strtoupper($option->getName());
            if ($option->isValueOptional()) {
                $value = '[' . $value . ']';
            }
        }
        $totalWidth = $options['total_width'] ?? $this->calculateTotalWidthForOptions([$option]);
        $synopsis = \sprintf('%s%s', $option->getShortcut() ? \sprintf('-%s, ', $option->getShortcut()) : '    ', \sprintf($option->isNegatable() ? '--%1$s|--no-%1$s' : '--%1$s%2$s', $option->getName(), $value));
        $spacingWidth = $totalWidth - \ECSPrefix20220418\Symfony\Component\Console\Helper\Helper::width($synopsis);
        $this->writeText(\sprintf(
            '  <info>%s</info>  %s%s%s%s',
            $synopsis,
            \str_repeat(' ', $spacingWidth),
            // + 4 = 2 spaces before <info>, 2 spaces after </info>
            \preg_replace('/\\s*[\\r\\n]\\s*/', "\n" . \str_repeat(' ', $totalWidth + 4), $option->getDescription()),
            $default,
            $option->isArray() ? '<comment> (multiple values allowed)</comment>' : ''
        ), $options);
    }
    /**
     * {@inheritdoc}
     */
    protected function describeInputDefinition(\ECSPrefix20220418\Symfony\Component\Console\Input\InputDefinition $definition, array $options = [])
    {
        $totalWidth = $this->calculateTotalWidthForOptions($definition->getOptions());
        foreach ($definition->getArguments() as $argument) {
            $totalWidth = \max($totalWidth, \ECSPrefix20220418\Symfony\Component\Console\Helper\Helper::width($argument->getName()));
        }
        if ($definition->getArguments()) {
            $this->writeText('<comment>Arguments:</comment>', $options);
            $this->writeText("\n");
            foreach ($definition->getArguments() as $argument) {
                $this->describeInputArgument($argument, \array_merge($options, ['total_width' => $totalWidth]));
                $this->writeText("\n");
            }
        }
        if ($definition->getArguments() && $definition->getOptions()) {
            $this->writeText("\n");
        }
        if ($definition->getOptions()) {
            $laterOptions = [];
            $this->writeText('<comment>Options:</comment>', $options);
            foreach ($definition->getOptions() as $option) {
                if (\strlen($option->getShortcut() ?? '') > 1) {
                    $laterOptions[] = $option;
                    continue;
                }
                $this->writeText("\n");
                $this->describeInputOption($option, \array_merge($options, ['total_width' => $totalWidth]));
            }
            foreach ($laterOptions as $option) {
                $this->writeText("\n");
                $this->describeInputOption($option, \array_merge($options, ['total_width' => $totalWidth]));
            }
        }
    }
    /**
     * {@inheritdoc}
     */
    protected function describeCommand(\ECSPrefix20220418\Symfony\Component\Console\Command\Command $command, array $options = [])
    {
        $command->mergeApplicationDefinition(\false);
        if ($description = $command->getDescription()) {
            $this->writeText('<comment>Description:</comment>', $options);
            $this->writeText("\n");
            $this->writeText('  ' . $description);
            $this->writeText("\n\n");
        }
        $this->writeText('<comment>Usage:</comment>', $options);
        foreach (\array_merge([$command->getSynopsis(\true)], $command->getAliases(), $command->getUsages()) as $usage) {
            $this->writeText("\n");
            $this->writeText('  ' . \ECSPrefix20220418\Symfony\Component\Console\Formatter\OutputFormatter::escape($usage), $options);
        }
        $this->writeText("\n");
        $definition = $command->getDefinition();
        if ($definition->getOptions() || $definition->getArguments()) {
            $this->writeText("\n");
            $this->describeInputDefinition($definition, $options);
            $this->writeText("\n");
        }
        $help = $command->getProcessedHelp();
        if ($help && $help !== $description) {
            $this->writeText("\n");
            $this->writeText('<comment>Help:</comment>', $options);
            $this->writeText("\n");
            $this->writeText('  ' . \str_replace("\n", "\n  ", $help), $options);
            $this->writeText("\n");
        }
    }
    /**
     * {@inheritdoc}
     */
    protected function describeApplication(\ECSPrefix20220418\Symfony\Component\Console\Application $application, array $options = [])
    {
        $describedNamespace = $options['namespace'] ?? null;
        $description = new \ECSPrefix20220418\Symfony\Component\Console\Descriptor\ApplicationDescription($application, $describedNamespace);
        if (isset($options['raw_text']) && $options['raw_text']) {
            $width = $this->getColumnWidth($description->getCommands());
            foreach ($description->getCommands() as $command) {
                $this->writeText(\sprintf("%-{$width}s %s", $command->getName(), $command->getDescription()), $options);
                $this->writeText("\n");
            }
        } else {
            if ('' != ($help = $application->getHelp())) {
                $this->writeText("{$help}\n\n", $options);
            }
            $this->writeText("<comment>Usage:</comment>\n", $options);
            $this->writeText("  command [options] [arguments]\n\n", $options);
            $this->describeInputDefinition(new \ECSPrefix20220418\Symfony\Component\Console\Input\InputDefinition($application->getDefinition()->getOptions()), $options);
            $this->writeText("\n");
            $this->writeText("\n");
            $commands = $description->getCommands();
            $namespaces = $description->getNamespaces();
            if ($describedNamespace && $namespaces) {
                // make sure all alias commands are included when describing a specific namespace
                $describedNamespaceInfo = \reset($namespaces);
                foreach ($describedNamespaceInfo['commands'] as $name) {
                    $commands[$name] = $description->getCommand($name);
                }
            }
            // calculate max. width based on available commands per namespace
            $width = $this->getColumnWidth(\array_merge(...\array_values(\array_map(function ($namespace) use($commands) {
                return \array_intersect($namespace['commands'], \array_keys($commands));
            }, \array_values($namespaces)))));
            if ($describedNamespace) {
                $this->writeText(\sprintf('<comment>Available commands for the "%s" namespace:</comment>', $describedNamespace), $options);
            } else {
                $this->writeText('<comment>Available commands:</comment>', $options);
            }
            foreach ($namespaces as $namespace) {
                $namespace['commands'] = \array_filter($namespace['commands'], function ($name) use($commands) {
                    return isset($commands[$name]);
                });
                if (!$namespace['commands']) {
                    continue;
                }
                if (!$describedNamespace && \ECSPrefix20220418\Symfony\Component\Console\Descriptor\ApplicationDescription::GLOBAL_NAMESPACE !== $namespace['id']) {
                    $this->writeText("\n");
                    $this->writeText(' <comment>' . $namespace['id'] . '</comment>', $options);
                }
                foreach ($namespace['commands'] as $name) {
                    $this->writeText("\n");
                    $spacingWidth = $width - \ECSPrefix20220418\Symfony\Component\Console\Helper\Helper::width($name);
                    $command = $commands[$name];
                    $commandAliases = $name === $command->getName() ? $this->getCommandAliasesText($command) : '';
                    $this->writeText(\sprintf('  <info>%s</info>%s%s', $name, \str_repeat(' ', $spacingWidth), $commandAliases . $command->getDescription()), $options);
                }
            }
            $this->writeText("\n");
        }
    }
    /**
     * {@inheritdoc}
     */
    private function writeText(string $content, array $options = [])
    {
        $this->write(isset($options['raw_text']) && $options['raw_text'] ? \strip_tags($content) : $content, isset($options['raw_output']) ? !$options['raw_output'] : \true);
    }
    /**
     * Formats command aliases to show them in the command description.
     */
    private function getCommandAliasesText(\ECSPrefix20220418\Symfony\Component\Console\Command\Command $command) : string
    {
        $text = '';
        $aliases = $command->getAliases();
        if ($aliases) {
            $text = '[' . \implode('|', $aliases) . '] ';
        }
        return $text;
    }
    /**
     * Formats input option/argument default value.
     * @param mixed $default
     */
    private function formatDefaultValue($default) : string
    {
        if (\INF === $default) {
            return 'INF';
        }
        if (\is_string($default)) {
            $default = \ECSPrefix20220418\Symfony\Component\Console\Formatter\OutputFormatter::escape($default);
        } elseif (\is_array($default)) {
            foreach ($default as $key => $value) {
                if (\is_string($value)) {
                    $default[$key] = \ECSPrefix20220418\Symfony\Component\Console\Formatter\OutputFormatter::escape($value);
                }
            }
        }
        return \str_replace('\\\\', '\\', \json_encode($default, \JSON_UNESCAPED_SLASHES | \JSON_UNESCAPED_UNICODE));
    }
    /**
     * @param array<Command|string> $commands
     */
    private function getColumnWidth(array $commands) : int
    {
        $widths = [];
        foreach ($commands as $command) {
            if ($command instanceof \ECSPrefix20220418\Symfony\Component\Console\Command\Command) {
                $widths[] = \ECSPrefix20220418\Symfony\Component\Console\Helper\Helper::width($command->getName());
                foreach ($command->getAliases() as $alias) {
                    $widths[] = \ECSPrefix20220418\Symfony\Component\Console\Helper\Helper::width($alias);
                }
            } else {
                $widths[] = \ECSPrefix20220418\Symfony\Component\Console\Helper\Helper::width($command);
            }
        }
        return $widths ? \max($widths) + 2 : 0;
    }
    /**
     * @param InputOption[] $options
     */
    private function calculateTotalWidthForOptions(array $options) : int
    {
        $totalWidth = 0;
        foreach ($options as $option) {
            // "-" + shortcut + ", --" + name
            $nameLength = 1 + \max(\ECSPrefix20220418\Symfony\Component\Console\Helper\Helper::width($option->getShortcut()), 1) + 4 + \ECSPrefix20220418\Symfony\Component\Console\Helper\Helper::width($option->getName());
            if ($option->isNegatable()) {
                $nameLength += 6 + \ECSPrefix20220418\Symfony\Component\Console\Helper\Helper::width($option->getName());
                // |--no- + name
            } elseif ($option->acceptValue()) {
                $valueLength = 1 + \ECSPrefix20220418\Symfony\Component\Console\Helper\Helper::width($option->getName());
                // = + value
                $valueLength += $option->isValueOptional() ? 2 : 0;
                // [ + ]
                $nameLength += $valueLength;
            }
            $totalWidth = \max($totalWidth, $nameLength);
        }
        return $totalWidth;
    }
}
