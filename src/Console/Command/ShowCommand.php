<?php

namespace Symplify\EasyCodingStandard\Console\Command;

use ECSPrefix20210514\Symfony\Component\Console\Input\InputInterface;
use ECSPrefix20210514\Symfony\Component\Console\Output\OutputInterface;
use Symplify\EasyCodingStandard\Console\Reporter\CheckerListReporter;
use Symplify\EasyCodingStandard\Console\Style\EasyCodingStandardStyle;
use Symplify\EasyCodingStandard\FixerRunner\Application\FixerFileProcessor;
use Symplify\EasyCodingStandard\Guard\LoadedCheckersGuard;
use Symplify\EasyCodingStandard\SniffRunner\Application\SniffFileProcessor;
use Symplify\PackageBuilder\Console\Command\AbstractSymplifyCommand;
use Symplify\PackageBuilder\Console\ShellCode;
final class ShowCommand extends \Symplify\PackageBuilder\Console\Command\AbstractSymplifyCommand
{
    /**
     * @var SniffFileProcessor
     */
    private $sniffFileProcessor;
    /**
     * @var FixerFileProcessor
     */
    private $fixerFileProcessor;
    /**
     * @var EasyCodingStandardStyle
     */
    private $easyCodingStandardStyle;
    /**
     * @var CheckerListReporter
     */
    private $checkerListReporter;
    /**
     * @var LoadedCheckersGuard
     */
    private $loadedCheckersGuard;
    public function __construct(\Symplify\EasyCodingStandard\SniffRunner\Application\SniffFileProcessor $sniffFileProcessor, \Symplify\EasyCodingStandard\FixerRunner\Application\FixerFileProcessor $fixerFileProcessor, \Symplify\EasyCodingStandard\Console\Style\EasyCodingStandardStyle $easyCodingStandardStyle, \Symplify\EasyCodingStandard\Console\Reporter\CheckerListReporter $checkerListReporter, \Symplify\EasyCodingStandard\Guard\LoadedCheckersGuard $loadedCheckersGuard)
    {
        parent::__construct();
        $this->sniffFileProcessor = $sniffFileProcessor;
        $this->fixerFileProcessor = $fixerFileProcessor;
        $this->easyCodingStandardStyle = $easyCodingStandardStyle;
        $this->checkerListReporter = $checkerListReporter;
        $this->loadedCheckersGuard = $loadedCheckersGuard;
    }
    /**
     * @return void
     */
    protected function configure()
    {
        $this->setDescription('Show loaded checkers');
    }
    /**
     * @return int
     */
    protected function execute(\ECSPrefix20210514\Symfony\Component\Console\Input\InputInterface $input, \ECSPrefix20210514\Symfony\Component\Console\Output\OutputInterface $output)
    {
        if ($this->loadedCheckersGuard->areSomeCheckerRegistered() === \false) {
            $this->loadedCheckersGuard->report();
            return \Symplify\PackageBuilder\Console\ShellCode::ERROR;
        }
        $totalCheckerCount = \count($this->sniffFileProcessor->getCheckers()) + \count($this->fixerFileProcessor->getCheckers());
        $this->checkerListReporter->report($this->sniffFileProcessor->getCheckers(), 'PHP_CodeSniffer');
        $this->checkerListReporter->report($this->fixerFileProcessor->getCheckers(), 'PHP-CS-Fixer');
        $successMessage = \sprintf('Loaded %d checker%s in total', $totalCheckerCount, $totalCheckerCount === 1 ? '' : 's');
        $this->easyCodingStandardStyle->success($successMessage);
        return \Symplify\PackageBuilder\Console\ShellCode::SUCCESS;
    }
}
