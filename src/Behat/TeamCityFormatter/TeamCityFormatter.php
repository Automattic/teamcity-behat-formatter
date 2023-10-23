<?php
namespace Behat\TeamCityFormatter3;

use Behat\Behat\EventDispatcher\Event\AfterStepTested;
use Behat\Behat\EventDispatcher\Event\BeforeFeatureTested;
use Behat\Behat\EventDispatcher\Event\AfterFeatureTested;
use Behat\Behat\EventDispatcher\Event\BeforeScenarioTested;
use Behat\Behat\EventDispatcher\Event\AfterScenarioTested;
use Behat\Testwork\Output\Formatter;
use Behat\Testwork\Output\Printer\OutputPrinter;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class TeamCityFormatter implements Formatter, EventSubscriberInterface
{
    private $printer;

    public function __construct(OutputPrinter $printer)
    {
        $this->printer = $printer;
    }

    public static function getSubscribedEvents()
    {
        return [
            AfterStepTested::AFTER => ['afterStep', -10],
            BeforeFeatureTested::BEFORE => 'beforeFeature',
            AfterFeatureTested::AFTER => 'afterFeature',
            BeforeScenarioTested::BEFORE => 'beforeScenario',
            AfterScenarioTested::AFTER => 'afterScenario',
        ];
    }

    private $parameters = [];

    // ... (existing methods)

    public function setParameter($name, $value)
    {
        $this->parameters[$name] = $value;
    }

    public function getParameter($name)
    {
        return isset($this->parameters[$name]) ? $this->parameters[$name] : null;
    }

    public function getOutputPrinter()
    {
        return $this->printer;
    }

    public function getName()
    {
        return 'teamcity';
    }

    public function getDescription()
    {
        return 'Outputs results in TeamCity format';
    }

    public function getOutputPath()
    {
        return null; // STDOUT
    }

    public function setOutputPath($path)
    {
        // Not relevant, as we're writing to STDERR
    }

    public function isVerbose()
    {
        return false;
    }

    public function beforeFeature(BeforeFeatureTested $event)
    {
        $feature = $event->getFeature();
        $fileName = $feature->getFile();
        $this->printEvent("testSuiteStarted", [
            "name" => $feature->getTitle(),
            "locationHint" => "file://$fileName",
        ]);
    }

    public function afterFeature(AfterFeatureTested $event)
    {
        $feature = $event->getFeature();
        $fileName = $feature->getFile();
        $this->printEvent("testSuiteFinished", [
            "name" => $feature->getTitle(),
            "locationHint" => "file://$fileName",
        ]);
    }

    public function beforeScenario(BeforeScenarioTested $event)
    {
        $scenario = $event->getScenario();
        $fileName = $scenario->getFile();
        $this->printEvent("testStarted", [
            "name" => $scenario->getTitle(),
            "locationHint" => "file://$fileName",
            "captureStandardOutput" => "true"
        ]);
    }

    public function afterScenario(AfterScenarioTested $event)
    {
        $scenario = $event->getScenario();
        $fileName = $scenario->getFile();
        $this->printEvent("testFinished", [
            "name" => $scenario->getTitle(),
            "locationHint" => "file://$fileName",
        ]);
    }

    public function afterStep(AfterStepTested $event)
    {
        // This method will need further adjustments to capture the step details
        // as the previous API for steps has changed in Behat 3.
    }

    public static function printEvent($eventName, $params = array())
    {
        self::printText("\n##teamcity[$eventName");
        foreach ($params as $key => $value) {
            $escapedValue = self::escapeValue((string)$value);
            self::printText(" $key='$escapedValue'");
        }
        self::printText("]\n");
    }

    public static function printText($text)
    {
        file_put_contents('php://stderr', $text);
    }

    public static function escapeValue($text)
    {
        if (true === empty($text) || null === $text) {
            $text = 'null';
        }
        return \str_replace(
            ['|', "'", "\n", "\r", ']', '['],
            ['||', "|'", '|n', '|r', '|]', '|['],
            $text
        );
    }
}

