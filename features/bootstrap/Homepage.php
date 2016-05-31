<?php

namespace Page;

use Behat\Mink\Exception\ElementNotFoundException;
use SensioLabs\Behat\PageObjectExtension\PageObject\Page;

class Homepage extends Page
{
    /**
     * @var string $path
     */
    protected $path = '/';

    /**
     * @param string $mail
     * @param string $username
     * @param string $password
     *
     * @return Page
     */
    public function login($mail, $username, $password)
    {
        $signupRegisterForm = $this->find('css', 'form#login');

        if (!$searchForm) {
            throw new ElementNotFoundException($this->getDriver(), 'form', 'css', 'form#login');
        }

        $signupRegisterForm->fillField('mail', $mail);
        $signupRegisterForm->fillField('username', $username);
        $signupRegisterForm->fillField('password', $password);
        $signupRegisterForm->pressButton('submit');

        return $this->getPage('http://localhost:8000/signup.error/3');
    }
}