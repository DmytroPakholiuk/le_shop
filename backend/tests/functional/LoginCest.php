<?php

namespace backend\tests\functional;

use backend\tests\FunctionalTester;
use common\fixtures\UserFixture;

/**
 * Class LoginCest
 */
class LoginCest
{
    /**
     * Load fixtures before db transaction begin
     * Called in _before()
     * @see \Codeception\Module\Yii2::_before()
     * @see \Codeception\Module\Yii2::loadFixtures()
     * @return array
     */
    public function _fixtures()
    {
        return [
            'user' => [
                'class' => UserFixture::class,
                'dataFile' => codecept_data_dir() . 'login_data.php'
            ]
        ];
    }
    
    /**
     * @param FunctionalTester $I
     */
    public function loginUser(FunctionalTester $I)
    {
        $I->amOnRoute('/site/login');
        $I->fillField(['id' => 'loginform-username'], 'erau');
        $I->fillField(['id' => 'loginform-password'], 'password_0');
        $I->click('Sign In');

//        $I->see('<a class="nav-link" href="/site/logout" data-method="post"><i class="fas fa-sign-out-alt"></i></a>');
        $I->dontSeeLink('Login');
        $I->dontSeeLink('Signup');
    }
}
