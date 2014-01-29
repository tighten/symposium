<?php namespace Markedstyle\CSS;

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
			$this->$process();
		}

		return $this->output_css;
	}

	/**
	 * Capture any calls to body and replace with wrapper
	 *
	 * @return $this
	 */
	protected function captureBody()
	{
		$this->output_css = str_replace('body', $this->wrapper, $this->output_css);
	}
}
