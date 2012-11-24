<?php
namespace Famelo\Poltergeist\Command;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Famelo.Poltergeist".    *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;

/**
 * behat command controller for the Famelo.Poltergeist package
 *
 * @Flow\Scope("singleton")
 */
class BehatCommandController extends \TYPO3\Flow\Cli\CommandController {

	/**
	 * Kickstarter for Behat BDD
	 *
	 * This command helps you to create the basic structure and a first
	 * feature
	 *
	 * @return void
	 */
	public function kickstartCommand() {
		$source = FLOW_PATH_PACKAGES . 'Application/Famelo.Poltergeist/Resources/Private/Kickstart/';
		$target = FLOW_PATH_ROOT;
		\TYPO3\Flow\Utility\Files::copyDirectoryRecursively($source, $target, TRUE);
		$this->outputLine('Done. Try ./bin/behat to test it out.');
	}

}

?>