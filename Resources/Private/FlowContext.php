<?php

use Behat\Behat\Context\ClosuredContextInterface,
    Behat\Behat\Context\TranslatedContextInterface,
    Behat\MinkExtension\Context\MinkContext,
    Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;

/**
 * Flow context.
 */
class FlowContext extends MinkContext {
    /**
     * The TYPO3 Flow Bootstrap
     * @var \TYPO3\Flow\Core\Bootstrap
     */
    protected static $bootstrap;

    /**
     * The TYPO3 Flow Context
     * @var string
     */
    protected static $context = 'Development';

    /**
     * Flag to enable/disable waiting for
     * documen.readyState == 'complete'.
     * Quite useful for Selenium2 to minimize
     * fals assertions because of partially
     * loaded pages.
     *
     * @var boolean
     */
    protected static $waitForReadyState = TRUE;

    /**
     * @BeforeSuite
     */
    public static function prepare() {
        $_SERVER['FLOW_ROOTPATH'] = dirname(__FILE__) . '/../../../../../';
        require_once($_SERVER['FLOW_ROOTPATH'] . 'Packages/Framework/TYPO3.Flow/Classes/TYPO3/Flow/Core/Bootstrap.php');

        self::$bootstrap = new \TYPO3\Flow\Core\Bootstrap(self::$context);
        self::$bootstrap->registerRequestHandler(new Famelo\Poltergeist\SilentRequestHandler(self::$bootstrap));
        self::$bootstrap->setPreselectedRequestHandlerClassName('Famelo\Poltergeist\SilentRequestHandler');
        self::$bootstrap->run();
     }

    /**
     * @BeforeStep
     */
    public function beforeStep() {
        if (self::$waitForReadyState) {
            try {
                $this->getSession()->wait(5000, 'document.readyState === "complete"');
            } catch(Exception $e){};
        }
    }

    /**
     * @Given /^there are no "([^"]*)" entities$/
     */
    public function thereAreNoEntities($entity) {
        $persistenceManager = self::$bootstrap->getObjectManager()->get('\TYPO3\Flow\Persistence\Doctrine\PersistenceManager');
        $query = $persistenceManager->createQueryForType(lcfirst($entity));
        $objects = $query->execute();
        foreach ($objects as $object) {
            $persistenceManager->remove($object);
        }
        $persistenceManager->persistAll();
    }

    /**
     * @When /^(?:|I )click "([^"]*)" on a "([^"]*)" which contains "([^"]*)"$/
     */
    public function iClickALinkOnARowWichContains($link, $selector, $text) {
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
     * @When /^(?:|I )wait (\d+) secs$/
     */
    public function iWaitSecs($seconds) {
        sleep($seconds);
    }

    /**
     * @Then /^(?:|I )take a screenshot$/
     */
    public function iTakeAScreenshot() {
        $filename = sprintf('%s_%s_%s.%s', $this->getMinkParameter('browser_name'), date('c'), uniqid('', true), 'png');
        $filepath = dirname(__FILE__) . '/../Screenshots';
        file_put_contents($filepath . '/' . $filename, $this->getSession()->getScreenshot());
    }
}
