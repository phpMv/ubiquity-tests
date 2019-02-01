<?php 

class FirstCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    // tests
    public function tryToTest(AcceptanceTester $I)
    {
    	$I->amOnPage("/");
    	$I->canSee("Ubiquity","body");
    }
    
    // tests
    public function tryToOtherTest(AcceptanceTester $I)
    {
    	$I->amOnPage("/Main/testUser");
    	$I->canSee("SMITH","body");
    }
}
