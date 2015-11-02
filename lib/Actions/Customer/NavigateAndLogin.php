<?php

namespace Magium\Actions\Customer;

use Magium\Navigators\Customer\Login as CustomerLogin;

class NavigateAndLogin
{

    protected $login;
    protected $loginNavigator;

    public function __construct(
        Login $login,
        CustomerLogin $loginNavigator

    ) {
       $this->login = $login;
        $this->loginNavigator = $loginNavigator;
    }

    /**
     *
     * Will log in to the specified customer account.  If requireLogin is specified it will assert that
     * the login form MUST be there.  Otherwise it will return if the login form is not there, presuming
     * that the current session is already logged in.
     *
     * @param string $username
     * @param string $password
     * @param bool $requireLogin Fail the test if there is an account currently logged in
     */

    public function login($username = null, $password = null, $requireLogin = false)
    {
        $this->loginNavigator->navigateToLogin();
        $this->login->login($username, $password, $requireLogin);
    }
}