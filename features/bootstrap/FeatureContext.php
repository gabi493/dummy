<?php

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Symfony\Component\Yaml\Yaml;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Behat\Mink\Driver;


/**
 * Defines application features from the specific context.
 */
class FeatureContext extends WebTestCase implements Context, SnippetAcceptingContext
{
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    private $shelf;
    private $basket;

    private $user;

    private $driver;
    private $session;
    private $page;

    public function __construct()
    {
        $this->shelf = new Shelf();
        $this->basket = new Basket($this->shelf);
        $this->user = new User();

        // Choose a Mink driver.
        $this->driver = new \Behat\Mink\Driver\GoutteDriver();
        $this->session = new \Behat\Mink\Session($this->driver);

        // start the session
        $this->session->start();
        $this->session->visit('http://localhost:8000/');

        $this->page = $this->session->getPage();    //ahora podemos manipular la página
    }

    /**
     * @Given there is a :product, which costs £:price
     */
    public function thereIsAWhichCostsPs($product, $price)
    {
        $this->shelf->setProductPrice($product, floatval($price));
    }

    /**
     * @When I add the :product to the basket
     */
    public function iAddTheToTheBasket($product)
    {
        $this->basket->addProduct($product);
    }

    /**
     * @Then I should have :count product(s) in the basket
     */
    public function iShouldHaveProductInTheBasket($count)
    {
        PHPUnit_Framework_Assert::assertCount(
            intval($count),
            $this->basket
        );
    }

    /**
     * @Then the overall basket price should be £:price
     */
    public function theOverallBasketPriceShouldBePs($price)
    {
        PHPUnit_Framework_Assert::assertSame(
            floatval($price),
            $this->basket->getTotalPrice()
        );
    }
//***********************************************************************************************
//                                          LOGIN
//***********************************************************************************************


        // Choose a Mink driver.
    /*    private $driver = new \Behat\Mink\Driver\GoutteDriver();

        private $session = new \Behat\Mink\Session($driver);

            // start the session
        private $session->start();
        private $session->visit('http://localhost:8000/');

        private $page = $session->getPage();    //ahora podemos manipular la página
    */
    /**
     * @Given my username is :name
     */
    public function myUsernameIs($name)
    {
        $this->user->setUsername($name);
    }

    /**
     * @Then I should not be able to log into the system
     */
    public function iShouldNotBeAbleToLogIntoTheSystem()
    {
        throw new PendingException('Do not login the system');
    }

    /**
     * @Then should get :arg1 error in the login-page
     */
    public function shouldGetErrorInTheLoginPage($arg1)
    {
        throw new PendingException('Show error: Username not registered in the system');
    }

    /**
     * @Given I am not registered
     */
    public function iAmNotRegistered()
    {
        $message = $this->page->findById('message');
        return $message == 'Username not registered in the system';

    }

    /**
     * @When I try to :arg1 to the system
     */
    public function iTryToToTheSystem($arg1)
    {
        if ($arg1 == 'login') {
            $registerForm = $this->page->find('css', 'form');

            if (null === $registerForm) {
                throw new \Exception('The element is not found');
            }

            // find some field INSIDE form with class="username"
            $usernameField = $registerForm->findField('username');
            $usernameField->setValue('gabriel');
            //    throw new \Exception($usernameField->getValue());

            $passwordField = $registerForm->findField('password');
            $passwordField->setValue('1234');
            //    throw new \Exception($passwordField->getValue());
            $submitButton = $registerForm->find('css', 'div button');
            $submitButton->click();
        }
        else {
            throw new PendingException();
        }
    }

    /**
     * @Then I should see the error message :arg1
     */
    public function iShouldSeeTheErrorMessage($arg1)
    {
        if ($arg1 == 'Username not registered in the system') {
            $registerForm = $this->page->find('css', 'form');
            $errorMessage = $registerForm->findField('message');
            return $errorMessage == $arg1;
        }
    }
}
