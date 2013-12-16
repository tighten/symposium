<?php namespace Markedstyle\CSS;

use \Exception;

class Inliner {
	protected $css;
	protected $output_css;
	protected $wrapper = '.style-preview';
	protected $processes = array(
		'captureBody'
	);

	public function __construct($css)
	{
		$this->css = $css;

		return $this;
	}

	public function output()
	{
		$this->output_css = $this->css;

		foreach ($this->processes as $process) {
			// @todo: Test if eixsts
			$this->$process();
		}

		return $this->output_css;
	}

	/**
	 * Capture any calls to body and replace with wrapper
	 *
	 * @todo Make this smart enough that something else with the phrase 'body' in it won't break
	 * @return $this
	 */
	protected function captureBody()
	{
		$this->output_css = str_replace('body', $this->wrapper, $this->output_css);
	}
}
