<?php

use Behat\Behat\Context\ClosuredContextInterface,
    Behat\Behat\Context\TranslatedContextInterface,
    Behat\MinkExtension\Context\MinkContext,
    Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;

require_once dirname(__FILE__) . '/../../../Packages/Libraries/autoload.php';

/**
 * Features context.
 */
class FeatureContext extends MinkContext {
    /**
     * @When /^I click "([^"]*)" on a "([^"]*)" which contains "([^"]*)"$/
     */
    public function iPressOnARowWith($link, $selector, $text) {
        $nodes = $this->getSession()->getPage()->findAll('css', $selector);
        foreach ($nodes as $node) {
            $content  = $node->getText();
            if (preg_match('/'.preg_quote($text, '/').'/ui', $content)) {
                $node->clickLink($link);
                return;
            }
        }
    }

    /**
     * @When /^I wait (\d+) secs$/
     */
    public function iWaitSecs($seconds)
    {
        sleep($seconds);
    }

    /**
     * @Then /^I take a screenshot$/
     */
    public function iTakeAScreenshot() {
        $filename = sprintf('%s_%s_%s.%s', $this->getMinkParameter('browser_name'), date('c'), uniqid('', true), 'png');
        $filepath = dirname(__FILE__) . '/../Screenshots';
        file_put_contents($filepath . '/' . $filename, $this->getSession()->getScreenshot());
    }
}
