<?php

class FirstCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    // tests
    public function tryToTest(AcceptanceTester $I)
    {
    }

    public function funcionaPaginaPrincipal(AcceptanceTester $I) {
        $I->amOnPage('/');
        $I->see('La mejor tienda de laptops de la región.');
    }

}
