<?php

use Behat\Behat\Context\Context;
use Behat\MinkExtension\Context\MinkContext;
use Behat\Behat\Context\SnippetAcceptingContext;

abstract class CoreFeatureContext extends MinkContext implements
    Context,
    SnippetAcceptingContext
{
    /**
     * @Given I click on the link :link
     *
     * @param $link
     */
    public function iClickOnTheLink($link)
    {
        $this->clickLink($link);
    }

    /**
     * @Then I should be redirected back
     */
    public function iShouldBeRedirectedBack()
    {
        $this->getSession()->back();
    }
}
