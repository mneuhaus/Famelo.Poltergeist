Feature:
  In order to work with Behat/Mink
  As a developer
  I need to be able to set up Behat and Mink easily

  Scenario: Visit the Flow homepage
    When I go to "http://flow.typo3.org/"
    Then I should see "TYPO3 Flow is a web application platform enabling developers"