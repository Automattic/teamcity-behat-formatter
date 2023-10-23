<?php

namespace Behat\TeamCityFormatter3;

use Behat\Testwork\Output\Printer\OutputPrinter;

class ConsoleOutput implements OutputPrinter
{
    private $output;

    public function __construct($output)
    {
        $this->output = $output;
    }

    public function write($message, $newline = false)
    {
        if ($newline) {
            $this->output->writeln($message);
        } else {
            $this->output->write($message);
        }
    }

    public function writeln($message = '')
    {
        $this->output->writeln($message);
    }

		private $parameters = [];

		public function setParameter($name, $value)
		{
				$this->parameters[$name] = $value;
		}

		public function getParameter($name)
		{
				return isset($this->parameters[$name]) ? $this->parameters[$name] : null;
		}

    public function flush()
    {
        // This might be left empty if there's no need for any additional operations when flushing.
    }

    public function setOutputPath($path)
    {
        // Implement setting an output path if required.
    }

    public function getOutputPath()
    {
        // Return an appropriate path or null.
        return null;
    }

    public function setOutputStyles(array $styles)
    {
        // Implement this if you have specific output styles.
    }

    public function addOutputStyle($name, $style)
    {
        // Implement this if you have specific output styles.
    }

		public function getOutputStyles()
		{
				// You can return an empty array if you're not defining any styles.
				return [];
		}

		private $verbosity = self::VERBOSITY_NORMAL; // Let's set a default verbosity

		public function setOutputVerbosity($level)
		{
				$this->verbosity = $level;
				$this->output->setVerbosity($level);
		}

		public function getOutputVerbosity()
		{
				return $this->verbosity;
		}

    public function getOutputStyle($name)
    {
        // Return an appropriate style or null.
        return null;
    }

    public function isOutputDecorated()
    {
        // Return true or false based on your needs.
        return $this->output->isDecorated();
    }

    public function setOutputDecorated($decorated = true)
    {
        $this->output->setDecorated($decorated);
    }
}

