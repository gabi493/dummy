<?php

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Symfony\Component\Yaml\Yaml;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
//use SensioLabs\Behat\PageObjectExtension\PageObject\Page;
use Behat\Mink\Driver;
use Behat\Mink\Element;


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

    private $_username;
    private $_password;
    private $_title;
    private $_body;

    private $driver;
    private $session;
    private $page;

    private $signupDriver;
    private $signupSession;
    private $signupPage;

    private $menuDriver;
    private $menuSession;
    private $menuPage;

    private $commentDriver;
    private $commentSession;
    private $commentPage;

    private $registerForm;
    private $signupRegisterForm;
    private $menuRegisterForm;
    private $commentRegisterForm;

    private $_url;
    private $_driver;   // 1-4
    private $_userCase; // a-c
    private $_signupEmail;
    private $_signupUsername;
    private $_signupPassword;
    private $_signupRol;
    private $_signupEnterprise;
    private $_wrongSignupEmail;
    private $_wrongSignupUsername;
    private $_wrongSignupPassword;

    private $date;

    private function resetSessions()
    {
        if (! null === $this->session) $this->session->reset();
        if (! null === $this->signupSession) $this->signupSession->reset();
        if (! null === $this->menuSession) $this->menuSession->reset();
        if (! null === $this->commentSession) $this->commentSession->reset();
    }

    private function loadParam($param)
    {
        $file = '/Applications/XAMPP/htdocs/dummy/web/config/properties.txt';
        $searchfor = $param;

// the following line prevents the browser from parsing this as HTML.
        header('Content-Type: text/plain');
// get the file contents, assuming the file to be readable (and exist)
        $contents = file_get_contents($file);
// escape special characters in the query
        $pattern = preg_quote($searchfor, '/');
// finalise the regular expression, matching the whole line
        $pattern = "/^.*$pattern.*\$/m";
// search, and store all matching occurences in $matches
        if(preg_match_all($pattern, $contents, $matches)){
            return $matches;
        }
        else{
            echo "No matches found";
        }
    }

    private function loadParams()
    {

        $this->date = exec("date +%Y:%m:%d-%H.%M.%S");
        $param = $this->loadParam("[URL] = ");
        $this->_url = $param[0][0];

        $param = $this->loadParam("[Driver] = ");
        $this->_driver = $param[0][0];

        $param = $this->loadParam("[UserCase] = ");
        $this->_userCase = $param[0][0];

        $param = $this->loadParam("[SignupEmail] = ");
        $this->_signupEmail = $param[0][0];

        $param = $this->loadParam("[SignupUsername] = ");
        $this->_signupUsername = $param[0][0];

        $param = $this->loadParam("[SignupPassword] = ");
        $this->_signupPassword = $param[0][0];

        $param = $this->loadParam("[SignupRol] = ");
        $this->_signupRol = $param[0][0];

        $param = $this->loadParam("[SignupEnterprise] = ");
        $this->_signupEnterprise = $param[0][0];

        $param = $this->loadParam("[WrongSignupEmail] = ");
        $this->_wrongSignupEmail = $param[0][0];

        $param = $this->loadParam("[WrongSignupUsername] = ");
        $this->_wrongSignupUsername = $param[0][0];

        $param = $this->loadParam("[WrongSignupPassword] = ");
        $this->_wrongSignupPassword = $param[0][0];

        $this->_url = str_replace("[URL] = ", "", $this->_url);         // delete the string "[URL] = " from the variable $_url
        $this->_driver = str_replace("[Driver] = ", "", $this->_driver);   // delete the string "[Driver] = " from the variable $_driver
        $this->_userCase = str_replace("[UserCase] = ", "", $this->_userCase);   // delete the string "[UserCase] = " from the variable _userCase
        $this->_signupEmail = str_replace("[SignupEmail] = ", "", $this->_signupEmail);
        $this->_signupUsername = str_replace("[SignupUsername] = ", "", $this->_signupUsername);
        $this->_signupPassword = str_replace("[SignupPassword] = ", "", $this->_signupPassword);
        $this->_signupRol = str_replace("[SignupRol] = ", "", $this->_signupRol);
        $this->_signupEnterprise = str_replace("[SignupEnterprise] = ", "", $this->_signupEnterprise);
        $this->_wrongSignupEmail = str_replace("[WrongSignupEmail] = ", "", $this->_wrongSignupEmail);
        $this->_wrongSignupUsername = str_replace("[WrongSignupUsername] = ", "", $this->_wrongSignupUsername);
        $this->_wrongSignupPassword = str_replace("[WrongSignupPassword] = ", "", $this->_wrongSignupPassword);

//        print_r("###################################################   --> _url: " . $this->_url . "\n");
//        print_r("###################################################   --> _driver: " . $this->_driver . "\n");
//        print_r("###################################################   --> _userCase: " . $this->_userCase . "\n");
//        print_r("###################################################   --> _signupEmail: " . $this->_signupEmail . "\n");
//        print_r("###################################################   --> _signupUsername: " . $this->_signupUsername . "\n");
//        print_r("###################################################   --> _signupPassword: " . $this->_signupPassword . "\n");
//        print_r("###################################################   --> _signupRol: " . $this->_signupRol . "\n");
//        print_r("###################################################   --> _signupEnterprise: " . $this->_signupEnterprise . "\n");
//        print_r("###################################################   --> _wrongSignupEmail: " . $this->_wrongSignupEmail . "\n");
//        print_r("###################################################   --> _wrongSignupUsername: " . $this->_wrongSignupUsername . "\n");
//        print_r("###################################################   --> _wrongSignupPassword: " . $this->_wrongSignupPassword . "\n");
    }

    private function testSessionWithGoute ()
    {
        $this->session = new \Behat\Mink\Session($this->driver);
        $this->session->start();                    // start the session
        $this->session->visit($this->_url);
        $this->page = $this->session->getPage();    //ahora podemos manipular la página
        $this->registerForm = $this->page->find('css', 'form');
    }

    private function testSignupSessionWithGoute ()
    {
        $this->signupSession = new \Behat\Mink\Session($this->signupDriver);
        $this->signupSession->start();                          // start the session
        $this->signupSession->visit($this->_url . 'signup');
        $this->signupPage = $this->signupSession->getPage();    //ahora podemos manipular la página
        $this->signupRegisterForm = $this->signupPage->find('css', 'form');
    }

    private function testMenuSessionWithGoute ()
    {
        $this->menuSession = new \Behat\Mink\Session($this->menuDriver);
        $this->menuSession->start();                          // start the session
        $this->menuSession->visit($this->_url);
        $this->menuPage = $this->menuSession->getPage();    //ahora podemos manipular la página
        $this->menuRegisterForm = $this->menuPage->find('css', 'form');
    }

    private function testCommentSessionWithGoute ()
    {
        $this->commentSession = new \Behat\Mink\Session($this->commentDriver);
        $this->commentSession->start();                          // start the session
        $this->commentSession->visit($this->_url);
        $this->commentPage = $this->commentSession->getPage();    //ahora podemos manipular la página
        $this->commentRegisterForm = $this->commentPage->find('css', 'form');
    }

    private function testEverythingWithGoute ()
    {
        $this->testLoginWithGoute();
        $this->testSignupWithGoute();
        $this->testMenuWithGoute();
        $this->testCommentWithGoute();
    }

    private function testLoginWithGoute ()
    {
        $this->driver = new \Behat\Mink\Driver\GoutteDriver();
        $this->testSessionWithGoute();
    }

    private function testSignupWithGoute ()
    {
        $this->signupDriver = new \Behat\Mink\Driver\GoutteDriver();
        $this->testSignupSessionWithGoute();
    }

    private function testMenuWithGoute ()
    {
        $this->menuDriver = new \Behat\Mink\Driver\GoutteDriver();
        $this->testMenuSessionWithGoute();
    }

    private function testCommentWithGoute ()
    {
        $this->commentDriver = new \Behat\Mink\Driver\GoutteDriver();
        $this->testCommentSessionWithGoute();
    }

    private function testSessionWithBrowserKit ()
    {
        $this->session = new \Behat\Mink\Session($this->driver);
        $this->session->start();                    // start the session
        $this->session->visit($this->_url);
        $this->page = $this->session->getPage();    //ahora podemos manipular la página
        $this->registerForm = $this->page->find('css', 'form');
    }

    private function testSignupSessionWithBrowserKit ()
    {
        $this->signupSession = new \Behat\Mink\Session($this->signupDriver);
        $this->signupSession->start();                          // start the session
        $this->signupSession->visit($this->_url . 'signup');
        $this->signupPage = $this->signupSession->getPage();    //ahora podemos manipular la página
        $this->signupRegisterForm = $this->signupPage->find('css', 'form');
    }

    private function testMenuSessionWithBrowserKit ()
    {
        $this->menuSession = new \Behat\Mink\Session($this->menuDriver);
        $this->menuSession->start();                    // start the session
        $this->menuSession->visit($this->_url);
        $this->menuPage = $this->menuSession->getPage();    //ahora podemos manipular la página
        $this->menuRegisterForm = $this->menuPage->find('css', 'form');
    }

    private function testCommentSessionWithBrowserKit ()
    {
        $this->commentSession = new \Behat\Mink\Session($this->commentDriver);
        $this->commentSession->start();                    // start the session
        $this->commentSession->visit($this->_url);
        $this->commentPage = $this->commentSession->getPage();    //ahora podemos manipular la página
        $this->commentRegisterForm = $this->commentPage->find('css', 'form');
    }

    private function testEverythingWithBrowserKit ()
    {
        $this->testLoginWithBrowserKit();
        $this->testSignupWithBrowserKit();
        $this->testMenuWithBrowserKit();
        $this->testCommentWithBrowserKit();
    }

    private function testLoginWithBrowserKit ()
    {
        $loginBrowserkitClient = new \Goutte\Client();
        $this->driver = new \Behat\Mink\Driver\BrowserKitDriver($loginBrowserkitClient);
        $this->testSessionWithBrowserKit();
    }

    private function testSignupWithBrowserKit ()
    {
        $signupBrowserkitClient = new \Goutte\Client();
        $this->signupDriver = new \Behat\Mink\Driver\BrowserKitDriver($signupBrowserkitClient);
        $this->testSignupSessionWithBrowserKit();
    }

    private function testMenuWithBrowserKit ()
    {
        $menuBrowserkitClient = new \Goutte\Client();
        $this->menuDriver = new \Behat\Mink\Driver\BrowserKitDriver($menuBrowserkitClient);
        $this->testMenuSessionWithBrowserKit();
    }

    private function testCommentWithBrowserKit ()
    {
        $commentBrowserkitClient = new \Goutte\Client();
        $this->commentDriver = new \Behat\Mink\Driver\BrowserKitDriver($commentBrowserkitClient);
        $this->testCommentSessionWithBrowserKit();
    }

    private function testSessionWithSelenium2 ()
    {
        $this->session = new \Behat\Mink\Session($this->driver);
        $this->session->start();                    // start the session
        $this->session->visit($this->_url);
        $this->page = $this->session->getPage();    //ahora podemos manipular la página
        $this->registerForm = $this->page->find('css', 'form');
    }

    private function testSignupSessionWithSelenium2 ()
    {
        $this->signupSession = new \Behat\Mink\Session($this->signupDriver);
        $this->signupSession->start();                          // start the session
        $this->signupSession->visit($this->_url . 'signup');
        $this->signupPage = $this->signupSession->getPage();    //ahora podemos manipular la página
        $this->signupRegisterForm = $this->signupPage->find('css', 'form');
    }

    private function testMenuSessionWithSelenium2 ()
    {
        $this->menuSession = new \Behat\Mink\Session($this->menuDriver);
        $this->menuSession->start();                          // start the session
        $this->menuSession->visit($this->_url);
        $this->menuPage = $this->menuSession->getPage();    //ahora podemos manipular la página
        $this->menuRegisterForm = $this->menuPage->find('css', 'form');
    }

    private function testCommentSessionWithSelenium2 ()
    {
        $this->commentSession = new \Behat\Mink\Session($this->commentDriver);
        $this->commentSession->start();                          // start the session
        $this->commentSession->visit($this->_url);
        $this->commentPage = $this->commentSession->getPage();    //ahora podemos manipular la página
        $this->commentRegisterForm = $this->commentPage->find('css', 'form');
    }

    private function testEverythingWithSelenium2 ($browser)
    {
        $this->testLoginWithSelenium2($browser);
        $this->testSignupWithSelenium2($browser);
        $this->testMenuWithSelenium2($browser);
        $this->testCommentWithSelenium2($browser);
    }

    private function testLoginWithSelenium2 ($browser)
    {
        $this->driver = new \Behat\Mink\Driver\Selenium2Driver($browser);
        $this->testSessionWithSelenium2();
    }

    private function testSignupWithSelenium2 ($browser)
    {
        $this->signupDriver = new \Behat\Mink\Driver\Selenium2Driver($browser);
        $this->testSignupSessionWithSelenium2();
    }

    private function testMenuWithSelenium2 ($browser)
    {
        $this->menuDriver = new \Behat\Mink\Driver\Selenium2Driver($browser);
        $this->testMenuSessionWithSelenium2();
    }

    private function testCommentWithSelenium2 ($browser)
    {
        $this->commentDriver = new \Behat\Mink\Driver\Selenium2Driver($browser);
        $this->testCommentSessionWithSelenium2();
    }

    public function spin ($lambda, $wait = 5)
    {
        for ($i = 0; $i < $wait; $i++)
        {
            try {
                if ($lambda($this)) {
                    return true;
                }
            } catch (Exception $e) {
                // do nothing
            }

            sleep(1);
        }

        $backtrace = debug_backtrace();
        throw new Exception(
            "Timeout thrown by " . $backtrace[1]['class'] . "::" . $backtrace[1]['function'] . "()\n" .
            $backtrace[1]['file'] . ", line " . $backtrace[1]['line']
        );
    }

    public function __construct()
    {
        $this->resetSessions();
//        $this->commentSession->start();
        $this->loadParams();

//-------- Choose a Mink driver
        if ($this->_driver == 1) { //GoutteDriver
            if ($this->_userCase == "a") { //test Everything
                $this->testEverythingWithGoute();
            }
            else if ($this->_userCase == "b") { //test Login
                $this->testLoginWithGoute();
            }
            else if ($this->_userCase == "c") { //test Sign up
                $this->testSignupWithGoute();
            }
            else if ($this->_userCase == "d") { //test Menu
                $this->testMenuWithGoute();
            }
            else {
                $this->testCommentWithGoute();
            }
        }
        else if ($this->_driver == 2) { //BrowserKitDriver
//            $loginBrowserkitClient = new \Goutte\Client();
//            $signupBrowserkitClient = new \Goutte\Client();
            if ($this->_userCase == "a") { //test Everything
                $this->testEverythingWithBrowserKit();
            }
            else if ($this->_userCase == "b") { //test Login
                $this->testLoginWithBrowserKit();
            }
            else if ($this->_userCase == "c") { //test Sign up
                $this->testSignupWithBrowserKit();
            }
            else if ($this->_userCase == "d") { //test Menu
                $this->testMenuWithBrowserKit();
            }
            else {
                $this->testCommentWithBrowserKit();
            }
        }
        else if ($this->_driver == 3 || $this->_driver == 4) { //Selenium2Driver
//            system("java -jar selenium-server-standalone-2.53.0.jar");
//            sleep(1);
            $browser = "firefox";
            if ($this->_driver == 4) $browser = "chrome";
            if ($this->_userCase == "a") { //test Everything
                $this->testEverythingWithSelenium2($browser);
            }
            else if ($this->_userCase == "b") { //test Login
                $this->testLoginWithSelenium2($browser);
            }
            else if ($this->_userCase == "c") { //test Sign up
                $this->testSignupWithSelenium2($browser);
            }
            else if ($this->_userCase == "d") { //test Menu
                $this->testMenuWithSelenium2($browser);
            }
            else {
                $this->testCommentWithSelenium2($browser);
            }
        }
    }


//***********************************************************************************************
//                                          LOGIN
    // Choose a Mink driver.
    /*    private $driver = new \Behat\Mink\Driver\GoutteDriver();

        private $session = new \Behat\Mink\Session($driver);

            // start the session
        private $session->start();
        private $session->visit('http://localhost:8000/');

        private $page = $session->getPage();    //ahora podemos manipular la página
    */
//***********************************************************************************************


    /**
     * @Given I am not registered
     */
    public function iAmNotRegistered()
    {
//        $this->page = $this->session->getPage();
//        $message = $this->page->findById('message');
//        if ($message != 'Incorrect username or password') {
//            throw new \Exception('Messages do not coincide');
//        }
//        else {
            return true;
//        }
    }

    /**
     * @When I try to :arg1 to the system
     */
    public function iTryToToTheSystem($arg1)
    {
//        $this->page = $this->session->getPage();
        if ($arg1 == 'login') {
//            $registerForm = $this->page->find('css', 'form');
            if (null === $this->registerForm) {
                throw new \Exception('The element is not found');
            }
            // find some field INSIDE form with class="username"
            $this->registerForm->fillField('username', $this->_signupUsername);
            $this->registerForm->fillField('password', $this->_wrongSignupPassword);
            $this->registerForm->pressButton('submit');
            return $this->page;
        }
        else {
//            throw new PendingException();
            return true;
        }
    }

    /**
     * @Then I should see the login error message :arg1
     */
    public function iShouldSeeTheLoginErrorMessage($arg1)
    {
//        $this->page = $this->session->getPage();

        $a = 'Incorrect username or password';
        if ($arg1 == $a) {
//            $registerForm = $this->page->find('css', 'form');
            if (null == $this->registerForm) {
                throw new \Exception('The element $registerForm is not found');
            }
            $errorMessage = $this->registerForm->findById('message');
            if (null == $errorMessage) {
                throw new \Exception('Empty error message!');
            }

            else if ($errorMessage->getText() != $arg1) {
                throw new \Exception('Messages do not coincide; error recieved: ' . $errorMessage->getText() . ' || Error should be = ' . $arg1);
            }
            else {
                if ($this->_driver == 4 || $this->_driver == 3) { // Chrome or Firefox
                    $path = "/Applications/XAMPP/htdocs/dummy/web/tests_output/loginTestAction/screenshots/iShouldSeeTheLoginErrorMessage--" . $arg1 . "--" . $this->date . ".png";
                    $this->takeScreenshot($path, $this->driver);
                }
                return $this->page;
            }
        }
    }


//***********************************************************************************************
//                                         SIGN-UP
    // Choose a Mink driver.
    /*    private $driver = new \Behat\Mink\Driver\GoutteDriver();

        private $session = new \Behat\Mink\Session($driver);

            // start the session
        private $session->start();
        private $session->visit('http://localhost:8000/');

        private $page = $session->getPage();    //ahora podemos manipular la página
    */
//***********************************************************************************************


    /**
     * @When I try to :arg1 to the system with an e-mail not containing an @
     */
    public function iTryToToTheSystemWithAnEMailNotContainingAn($arg1)
    {
//        $this->signupPage = $this->signupSession->getPage();
        if ($arg1 == 'sign') {
//            $signupRegisterForm = $this->signupPage->find('css', 'form');

            if (null === $this->signupRegisterForm) {
                throw new \Exception('The element is not found');
            }

            // find some field INSIDE form with class="mail"
            $this->signupRegisterForm->fillField('mail', $this->_wrongSignupEmail); //<-------------
            $this->signupRegisterForm->fillField('username', $this->_signupUsername);
            $this->signupRegisterForm->fillField('password', $this->_signupPassword);
            $rolSelector = $this->signupPage->find('xpath', '//select[@id = "rols"]');
            $rolSelector -> selectOption($this->_signupRol);
            $enterpriseSelector = $this->signupPage->find('xpath', '//select[@id = "enterprises"]');
            $enterpriseSelector -> selectOption($this->_signupEnterprise);
            $this->signupRegisterForm->pressButton('submit');

            return $this->signupPage;
        }
        else {
            throw new \Exception('The argument passed is not one of the considered ones; It is: ' . $arg1);
        }
    }

    /**
     * @When I try to :arg1 to the system with a username shorter than :arg2 characters
     */
    public function iTryToToTheSystemWithAUsernameShorterThanCharacters($arg1, $arg2)
    {
//        $this->signupPage = $this->signupSession->getPage();
        if ($arg1 == 'sign') {
//            $signupRegisterForm = $this->signupPage->find('css', 'form');

            if (null === $this->signupRegisterForm) {
                throw new \Exception('The element is not found');
            }

            // find some field INSIDE form with class="username"
            $this->signupRegisterForm->fillField('mail', $this->_signupEmail);
            $this->signupRegisterForm->fillField('username', $this->_wrongSignupUsername); //<-------------
            $this->signupRegisterForm->fillField('password', $this->_signupPassword);
            $rolSelector = $this->signupPage->find('xpath', '//select[@id = "rols"]');
            $rolSelector -> selectOption($this->_signupRol);
            $enterpriseSelector = $this->signupPage->find('xpath', '//select[@id = "enterprises"]');
            $enterpriseSelector -> selectOption($this->_signupEnterprise);
            $this->signupRegisterForm->pressButton('submit');

            return $this->signupPage;
        }
        else {
            throw new \Exception('The argument passed is not one of the considered ones; It is: ' . $arg1);
        }
    }

    /**
     * @When I try to :arg1 to the system with a password shorter than :arg2 characters
     */
    public function iTryToToTheSystemWithAPasswordShorterThanCharacters($arg1, $arg2)
    {
        if ($arg1 == 'sign') {
            if (null === $this->signupRegisterForm) {
                throw new \Exception('The element is not found');
            }

            // find some field INSIDE form with class="password"
            $this->signupRegisterForm->fillField('mail', $this->_signupEmail);
            $this->signupRegisterForm->fillField('username', $this->_signupUsername);
            $this->signupRegisterForm->fillField('password', $this->_wrongSignupPassword); //<-------------
            $rolSelector = $this->signupPage->find('xpath', '//select[@id = "rols"]');
            $rolSelector -> selectOption($this->_signupRol);
            $enterpriseSelector = $this->signupPage->find('xpath', '//select[@id = "enterprises"]');
            $enterpriseSelector -> selectOption($this->_signupEnterprise);
            $this->signupRegisterForm->pressButton('submit');

            return $this->signupPage;
        }
        else {
            throw new \Exception('The argument passed is not one of the considered ones; It is: ' . $arg1);
        }
    }

    /**
     * @When I try to :arg1 to the system without an e-mail, username or password
     */
    public function iTryToToTheSystemWithoutAnEMailUsernameOrPassword($arg1)
    {
//        $this->signupPage = $this->signupSession->getPage();
        if ($arg1 == 'sign') {
//            $signupRegisterForm = $this->signupPage->find('css', 'form');

            if (null === $this->signupRegisterForm) {
                throw new \Exception('The element is not found');
            }

            // find some field INSIDE form with class="password"
            $this->signupRegisterForm->fillField('mail', $this->_signupEmail);
//            $signupRegisterForm->fillField('username', 'gabriel'); //<-------------
//            $signupRegisterForm->fillField('password', 'gabriel'); //<-------------
            $rolSelector = $this->signupPage->find('xpath', '//select[@id = "rols"]');
            $rolSelector -> selectOption($this->_signupRol);
            $enterpriseSelector = $this->signupPage->find('xpath', '//select[@id = "enterprises"]');
            $enterpriseSelector -> selectOption($this->_signupEnterprise);
            $this->signupRegisterForm->pressButton('submit');

            return $this->signupPage;
        }
        else {
            throw new \Exception('The argument passed is not one of the considered ones; It is: ' . $arg1);
        }
//        throw new PendingException();
    }

    /**
     * @When I try to :arg1 to the system with the e-mail :arg2, the username :arg3, the password :arg4, the rol :arg5 and the enterprise :arg6
     */
    public function iTryToToTheSystemWithTheEMailTheUsernameThePasswordTheRolAndTheEnterprise($arg1, $arg2, $arg3, $arg4, $arg5, $arg6)
    {
        if ($arg1 == 'sign') {
            if (null === $this->signupRegisterForm) {
                throw new \Exception('The element is not found');
            }

            // find some field INSIDE form with class="password"
            /*$this->signupRegisterForm->fillField('mail', $this->_signupEmail);
            $this->signupRegisterForm->fillField('username', $this->_signupUsername);
            $this->signupRegisterForm->fillField('password', $this->_signupPassword);
            $rolSelector = $this->signupPage->find('xpath', '//select[@id = "rols"]');
            $rolSelector -> selectOption($this->_signupRol);
            $enterpriseSelector = $this->signupPage->find('xpath', '//select[@id = "enterprises"]');
            $enterpriseSelector -> selectOption($this->_signupEnterprise);
            $this->signupRegisterForm->pressButton('submit');*/

            $this->signupRegisterForm->fillField('mail', $arg2);
            $this->signupRegisterForm->fillField('username', $arg3);
            $this->signupRegisterForm->fillField('password', $arg4);
            $rolSelector = $this->signupPage->find('xpath', '//select[@id = "rols"]');
            if ($arg5 == "Usuario") {
                $rolSelector -> selectOption("1");
            }
            else if ($arg5 == "Administrador") {
                $rolSelector -> selectOption("2");
            }
            else if ($arg5 == "Superadministrador") {
                $rolSelector -> selectOption("3");
            }
            else {
                throw new \Exception('Rols available: (Usuario, Administrador, Superadministrador)');
            }
            $enterpriseSelector = $this->signupPage->find('xpath', '//select[@id = "enterprises"]');
            if ($arg6 = "Empresa 1") {
                $enterpriseSelector -> selectOption("1");
            }
            else {
                throw new \Exception('Enterprises available: (Empresa 1)');
            }
            $this->signupRegisterForm->pressButton('submit');

            return $this->signupPage;
        }
        else {
            throw new \Exception('The argument passed is not one of the considered ones; It is: ' . $arg1);
        }
    }

    /**
     * @Then I should see the signup error message :arg1
     */
    public function iShouldSeeTheSignupErrorMessage($arg1)
    {
//        $this->signupPage = $this->signupSession->getPage();

        $b = 'Invalid e-mail format';
        $c = 'Username must be at least 6 characters long';
        $d = 'Password must be at least 6 characters long';
        $e = 'Fill in all the fields';

        if ($arg1 == $b || $arg1 == $c || $arg1 == $d || $arg1 == $e) {

//            $signupRegisterForm = $this->signupPage->find('css', 'form');
            if (null == $this->signupRegisterForm) {
                throw new \Exception('The element $registerForm is not found');
            }
            $errorMessage = $this->signupRegisterForm->findById('message');

            if ($errorMessage->getText() != $arg1) {
                throw new \Exception('Messages do not coincide; Error recieved: ' . $errorMessage->getText() . ' || Error should be: ' . $arg1);
            }
            else {
                if ($this->_driver == 4 || $this->_driver == 3) { // Chrome or Firefox
                    $path = "/Applications/XAMPP/htdocs/dummy/web/tests_output/signupTestAction/screenshots/iShouldSeeTheSignupErrorMessage--" . $arg1 . "--" . $this->date . ".png";
                    return $this->takeScreenshot($path, $this->signupDriver);
                }
                return true;
            }
        }
    }


//***********************************************************************************************
//                                         MENU
    // Choose a Mink driver.
    /*    private $driver = new \Behat\Mink\Driver\GoutteDriver();

        private $session = new \Behat\Mink\Session($driver);

            // start the session
        private $session->start();
        private $session->visit('http://localhost:8000/');

        private $page = $session->getPage();    //ahora podemos manipular la página
    */
//***********************************************************************************************

    /**
     * @Given I am logged as username :arg1 with password :arg2
     */
    public function iAmLoggedAsUsernameWithPassword($arg1, $arg2)
    {
        $this->_username = $arg1;
        $this->_password = $arg2;
//        echo("_username = " . $this->_username . "\r\n");
//        echo("_password = " . $this->_password . "\r\n");
        if ($this->_userCase == "d") { //test Menu
            if (null === $this->menuRegisterForm) {
                throw new \Exception('The element is not found');
            }
            // find some field INSIDE form with class="username"
            $this->menuRegisterForm->fillField('username', $arg1);
            $this->menuRegisterForm->fillField('password', $arg2);
            $this->menuRegisterForm->pressButton('submit');
            return $this->menuPage;
        }
        else if ($this->_userCase == "e") { //test Comment
            if (null === $this->commentRegisterForm) {
                throw new \Exception('The element is not found');
            }
            // find some field INSIDE form with class="username"
            $this->commentRegisterForm->fillField('username', $arg1);
            $this->commentRegisterForm->fillField('password', $arg2);
            $this->commentRegisterForm->pressButton('submit');
            return $this->commentPage;
        }
    }

    /**
     * @When I try to surf to the :arg1 tab
     */
    public function iTryToSurfToTheTab($arg1)
    {
        if ($this->_userCase == "d") { //test Menu
            if (null === $this->menuRegisterForm) {
                throw new \Exception('The element $this->menuRegisterForm is not found');
            }

            $tab = $this->menuPage->find('css', "a:contains(" . $arg1 . ")");
            if (null === $tab) {
                throw new \Exception('The tab ' . $arg1 . ' is not found');
            }
            $tab->click();
            return $this->menuPage;
        }
        else if ($this->_userCase == "e") { //test Comment
            if (null === $this->commentRegisterForm) {
                throw new \Exception('The element $this->commentRegisterForm is not found');
            }

            $tab = $this->commentPage->find('css', "a:contains(" . $arg1 . ")");
            if (null === $tab) {
                throw new \Exception('The tab ' . $arg1 . ' is not found');
            }
            $tab->click();
            return $this->commentPage;
        }
    }

    /**
     * @Then I should see the post title :arg1
     */
    public function iShouldSeeThePostTitle($arg1)
    {
        if (null == $this->menuPage) {
            throw new \Exception('The element $menuRegisterForm is not found');
        }
        $postTitle = $this->menuPage->findById('postTitle');

        if (null === $postTitle) {
            throw new \Exception('The title ->' . $arg1 . '<- is not found');
        }
        if ($postTitle->getText() != $arg1) {
            throw new \Exception('Title does not coincide; Title recieved: ' . $postTitle->getText() . ' || Title should be: ' . $arg1);
        }
        else {
            if ($this->_driver == 4 || $this->_driver == 3) { // Chrome or Firefox
                $path = "/Applications/XAMPP/htdocs/dummy/web/tests_output/menuTestAction/screenshots/iShouldSeeThePostTitle--" . $arg1 . "--" . $this->date . ".png";
                return $this->takeScreenshot($path, $this->menuDriver);
            }
            return true;
        }
    }

    /**
     * @Then I should see the welcome title :arg1
     */
    public function iShouldSeeTheWelcomeTitle($arg1)
    {
        $page = $this->menuPage; // menu
        if ($this->_userCase == "c") $page = $this->signupPage; // signup
        if (null == $page) {
            throw new \Exception('The element $menuRegisterForm is not found');
        }
        $welcomeTitle = $page->findById('welcomeTitle');

        if (null === $welcomeTitle) {
            throw new \Exception('The title ->' . $arg1 . '<- is not found');
        }
        if ($welcomeTitle->getText() != $arg1) {
            throw new \Exception('Title does not coincide; Title recieved: ' . $welcomeTitle->getText() . ' || Title should be: ' . $arg1);
        }
        else {
            if ($this->_driver == 4 || $this->_driver == 3) { // Chrome or Firefox
                if ($this->_userCase == "c") {  // signup
                    $path = "/Applications/XAMPP/htdocs/dummy/web/tests_output/signupTestAction/screenshots/iShouldSeeTheWelcomeTitle--" . $arg1 . "--" . $this->date . ".png";
                    return $this->takeScreenshot($path, $this->signupDriver);
                }
                else { // menu
                    $path = "/Applications/XAMPP/htdocs/dummy/web/tests_output/menuTestAction/screenshots/iShouldSeeTheWelcomeTitle--" . $arg1 . "--" . $this->date . ".png";
                    return $this->takeScreenshot($path, $this->menuDriver);
                }
            }
            return true;
        }
    }

    /**
     * @Then I should see the button :arg1
     */
    public function iShouldSeeTheButton($arg1)
    {
        if (null == $this->menuPage) {
            throw new \Exception('The element $menuRegisterForm is not found');
        }
        $button = $this->menuPage->findButton($arg1);

        if (null === $button) {
            throw new \Exception('The button ->' . $arg1 . '<- is not found');
        }
        if ($button->getText() != $arg1) {
            throw new \Exception('Title does not coincide; Button recieved: ' . $button->getText() . ' || Button should be: ' . $arg1);
        }
        else {
            if ($this->_driver == 4 || $this->_driver == 3) { // Chrome or Firefox
                $path = "/Applications/XAMPP/htdocs/dummy/web/tests_output/menuTestAction/screenshots/iShouldSeeTheButton--" . $arg1 . "--" . $this->date . ".png";
                return $this->takeScreenshot($path, $this->menuDriver);
            }
            return true;
        }
    }


//***********************************************************************************************
//                                         COMMENT
    // Choose a Mink driver.
    /*    private $driver = new \Behat\Mink\Driver\GoutteDriver();

        private $session = new \Behat\Mink\Session($driver);

            // start the session
        private $session->start();
        private $session->visit('http://localhost:8000/');

        private $page = $session->getPage();    //ahora podemos manipular la página
    */
//***********************************************************************************************


//    private function findField($locator)
//    {
//        return $this->find('named', array('field', $locator));
//    }


    private function killSeleniumServer()
    {
        $PID = exec("ps -xe | grep selenium");
        echo($PID . "\r\n");
        $PID = explode(" ", $PID);
        $PID = $PID[0];
        echo("Voy a jecutar el exec\r\n");
        exec("kill -9 " . $PID);
        $PID = exec("ps -xe | grep selenium");
        echo($PID . "\r\n"); // es el PID del comando exec("ps -xe | grep selenium");
    }

    /**
     * @When I try to comment the post with the title :arg1
     */
    public function iTryToCommentThePostWithTheTitle($arg1)
    {
        if (null === $this->commentRegisterForm) {
            throw new \Exception('The element is not found');
        }
        $this->commentRegisterForm->fillField('newCommentTitle', $arg1);
        $this->commentRegisterForm->pressButton('newCommentButton');
//        $path = "/Applications/XAMPP/htdocs/dummy/web/tests_output/commentTestAction/screenshots/iTryToCommentThePostWithTheTitle-" . $this->date . ".png";
//        $this->takeScreenshot($path);
        return $this->commentPage;
    }

    /**
     * @Then I should see the comment error message :arg1
     */
    public function iShouldSeeTheCommentErrorMessage($arg1)
    {
        if (null == $this->commentPage) {
            throw new \Exception('The element $commentPage is not found');
        }
        $errorMessage = $this->commentPage->findById('errores');
        if (! $errorMessage) {
            throw new \Exception('Message does not exist');
        }
        if ($errorMessage->getText() != $arg1) {
            throw new \Exception('Messages do not coincide; Error recieved: ->' . $errorMessage->getText() . '<- || Error should be: ' . $arg1);
        }
        else {
            if ($this->_driver == 4 || $this->_driver == 3) { // Chrome or Firefox
                $path = "/Applications/XAMPP/htdocs/dummy/web/tests_output/commentTestAction/screenshots/iShouldSeeTheCommentErrorMessage--" . $arg1 . "--" . $this->date . ".png";
                return $this->takeScreenshot($path, $this->commentDriver);
            }
            return true;
        }
    }

    /**
     * @When I try to comment the post with the body :arg1
     */
    public function iTryToCommentThePostWithTheBody($arg1)
    {
        if (null === $this->commentRegisterForm) {
            throw new \Exception('The element is not found');
        }
        $this->commentRegisterForm->fillField('newCommentBody', $arg1);
        $this->commentRegisterForm->pressButton('newCommentButton');
//        $path = "/Applications/XAMPP/htdocs/dummy/web/tests_output/commentTestAction/screenshots/iTryToCommentThePostWithTheBody-" . $this->date . ".png";
//        $this->takeScreenshot($path);
        return $this->commentPage;
    }

    /**
     * @When I try to comment the post with the title :arg1 and the body :arg2
     */
    public function iTryToCommentThePostWithTheTitleAndTheBody($arg1, $arg2)
    {
        if (null === $this->commentRegisterForm) {
            throw new \Exception('The element is not found');
        }
        $this->commentRegisterForm->fillField('newCommentTitle', $arg1);
        $this->commentRegisterForm->fillField('newCommentBody', $arg2);
        $this->commentRegisterForm->pressButton('newCommentButton');
//        $path = "/Applications/XAMPP/htdocs/dummy/web/tests_output/commentTestAction/screenshots/iTryToCommentThePostWithTheTitleAndTheBody-" . $this->date . ".png";
//        $this->takeScreenshot($path);
        return $this->commentPage;
    }

    /**
     * @Then I should see the comment with the title :arg1
     */
    public function iShouldSeeTheCommentWithTheTitle($arg1)
    {
        if (null == $this->commentPage) {
            throw new \Exception('The comment page is not found');
        }
        $this->_title = $arg1;

        if ($this->_driver == 4) { // Chrome
            $commentTitle = $this->spin(function ($context) {
                //            $context->getSession()->getPage()->findById('example')->click();
                return ($context->commentPage->find('css', 'td#listadoComments table tbody:first-child td:contains(' . $this->_title . ')'));
                //            return true;
            });

            //        $commentTitle = $this->commentPage->find('css', 'td#listadoComments table tbody:first-child tr td:contains(' . $arg1 . ')');
            if (null === $commentTitle) {
                throw new \Exception('Comment title not found');
            }
            else {
//                $this->killSeleniumServer();
                if ($this->_driver == 4 || $this->_driver == 3) {
                    $path = "/Applications/XAMPP/htdocs/dummy/web/tests_output/commentTestAction/screenshots/iShouldSeeTheCommentWithTheTitle--" . $arg1 . "--" . $this->date . ".png";
                    return $this->takeScreenshot($path, $this->commentDriver);
                }
                return true;
            }
        }
        else {
            throw new \Exception('This functionality works only with Chrome. Change the properties.txt file to do so.');
        }
    }

    /**
     * @Given I commented with the title :arg1 and the body :arg2
     */
    public function iCommentedWithTheTitleAndTheBody($arg1, $arg2)
    {
        if (null == $this->commentPage) {
            throw new \Exception('The comment page is not found');
        }
        $this->_title = $arg1;
        $this->_body = $arg2;

        if ($this->_driver == 4) { // Chrome
            $commentTitle = $this->spin(function ($context) {
                return ($context->commentPage->find('css', 'td#listadoComments table tbody:first-child td:contains(' . $this->_title . ')'));
            });
            $commentBody = $this->commentPage->find('css', 'td#listadoComments table tbody:first-child td:contains(' . $this->_body . ')');
            if (null === $commentTitle) {
                throw new \Exception('Chrome: Comment title not found');
            }
            else if (null === $commentBody) {
                throw new \Exception('Chrome: Comment body not found');
            }
            else {
//                $path = "/Applications/XAMPP/htdocs/dummy/web/tests_output/commentTestAction/screenshots/iCommentedWithTheTitleAndTheBody-" . $this->date . ".png";
//                return $this->takeScreenshot($path);
                return true;
            }
        }
        else {
            throw new \Exception('This functionality works only with Chrome. Change the properties.txt file to do so.');
        }
    }

    private function confirmPopup()
    {
        $this->commentSession->getDriver()->getWebDriverSession()->accept_alert();
    }

    private function takeScreenshot($path, $_driver) {
        $screenshot = $_driver->getScreenshot();
        if (null === $screenshot) {
            throw new \Exception('Screenshot not saved');
        }
        file_put_contents($path, $screenshot);
    }

    /**
     * @When I try to delete the post with title :arg1
     */
    public function iTryToDeleteThePostWithTitle($arg1)
    {
        if (null == $this->commentPage) {
            throw new \Exception('The comment page is not found');
        }
        $this->_title = $arg1;
//        $date = exec("date +%Y/%m/%d-%H:%M:%S");

        if ($this->_driver == 4) { //Chrome
            $commentTitle = $this->spin(function ($context) {
                return ($context->commentPage->find('css', 'td#listadoComments table tbody:first-child td:contains(' . $this->_title . ')'));
            });
            $deleteButton = $this->commentPage->find('css', 'td#listadoComments table tbody:first-child td:contains("Borrar")');
            if (null === $commentTitle) {
                throw new \Exception('Chrome: Comment title not found');
            }
            else if (null === $deleteButton) {
                throw new \Exception('Chrome: Comment body not found');
            }
            else {
                $deleteButton->click();
                $this->confirmPopup();

//                $path = "/Applications/XAMPP/htdocs/dummy/web/tests_output/commentTestAction/screenshots/iTryToDeleteThePostWithTitle-" . $this->date . ".png";
//                return $this->takeScreenshot($path);
                return true;
            }
        }
        else {
            throw new \Exception('This functionality works only with Chrome. Change the properties.txt file to do so.');
        }
    }

    /**
     * @Then I should not see the post with title :arg1
     */
    public function iShouldNotSeeThePostWithTitle($arg1)
    {
        if (null == $this->commentPage) {
            throw new \Exception('The comment page is not found');
        }
        $this->_title = $arg1;
        if ($this->_driver == 4) { //Chrome
            sleep(1);
            $path = "/Applications/XAMPP/htdocs/dummy/web/tests_output/commentTestAction/screenshots/iShouldNotSeeThePostWithTitle--" . $arg1 . "--" . $this->date . ".png";
            return $this->takeScreenshot($path, $this->commentDriver);
        }
        else {
            throw new \Exception('This functionality works only with Chrome. Change the properties.txt file to do so.');
        }
    }
}
