# This Package helps to install Behat/Mink inside TYPO3 Flow

Simple install it through composer:

```
composer require famelo/poltergeist
```

After the installation you can run the kickstart command to add some
files to your current Flow installation:

```
./flow behat:kickstart
```

This adds a behat.yml and a folder Tests/Features/ to your current setup.

To run behat you can just run this:

```
./bin/behat
```


Here are a few Sites to get you started on Behat:

behat.yml: http://docs.behat.org/guides/7.config.html

Behat Quickstart: http://docs.behat.org/quick_intro.html

Developing Web Applications with Behat and Mink: http://docs.behat.org/cookbook/behat_and_mink.html
