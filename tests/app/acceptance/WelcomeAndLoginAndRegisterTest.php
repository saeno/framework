<?php

/**
 * Saeno\Framework.
 *
 * @copyright 2015-2016 Daison Carino <daison12006013@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      https://github.com/saeno/framework
 */

namespace Saeno\Acceptance;

use Components\Model\User;
use Saeno\TestSuite\Behat\Mink\Mink;

/*
+------------------------------------------------------------------------------+
|\ ONCE UPON A TIME:                                                          /|
+------------------------------------------------------------------------------+
| I want to visit 'http://saeno.app'
| this is my first visit, so I must see the font logo which is 'Saeno'
| then upon clicking the 'Try sample forms' link
| I should be redirected to 'http://saeno.app/auth/registration'
| I have option to register an account
| Upon register, I should activate my account
| I should go back to the main welcome page
| Then click again the 'Try sample forms'
| I should be redirected to 'http://saeno.app/auth/login'
| I have an option to log-in using the registered account
+-------------------------------------------------------------------------------
*/
class AppTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var mixed|\Saeno\TestSuite\Behat\Mink\Mink
     */
    private $session;

    /**
     * @var string
     */
    private $url;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $password;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        $this->session = (new Mink)->get('goutte');
        $this->url = 'http://'.env('SERVE_HOST').':'.env('SERVE_PORT');
        $this->email = 'daison12006013@gmail.com';
        $this->password = '123qwe';
    }

    /**
     * Check the welcome page.
     *
     * @return void
     */
    private function triggerWelcomeProcess()
    {
        $this->session->visit($this->url);

        $this->assertEquals('200', $this->session->getStatusCode()); // === 200
        $this->assertContains($this->url, $this->session->getCurrentUrl()); // === $this->url

        $welcome_page = $this->session->getPage();

        $saeno_logo = $welcome_page->find(
            'named',
            ['id', 'frameworkTitle']
        );

        $this->assertContains('<span title="Solid">S</span>.<span title="Layer">layer</span>', $saeno_logo->getHtml()); // === "Saeno"

        $try_sample_forms = $welcome_page->find('xpath', '//a[@href="'.$this->url.'/try-sample-forms"]');
        $try_sample_forms->click();

        sleep(5);
    }

    /**
     * Test the registration page.
     *
     * @return void
     */
    public function testRegistration()
    {
        if (User::count()) {
            $this->testLogin();

            return;
        }

        $this->triggerWelcomeProcess();

        # REGISTRATION
        $this->assertEquals('200', $this->session->getStatusCode()); // === 200
        $this->assertContains($this->url.'/auth/register', $this->session->getCurrentUrl()); // === $this->url.'auth/register'

        $register_page = $this->session->getPage();

        $register_btn = $register_page->find(
            'named',
            ['id', 'register-btn']
        );

        $register_page->fillField('email', $this->email);
        $register_page->fillField('password', $this->password);
        $register_page->fillField('repassword', $this->password);
        $register_btn->press();
        // $register_page->pressButton('register-btn');

        sleep(5);

        $user = User::query()->where('email = :email: AND activated = :activated:')
            ->bind([
                'email' => $this->email,
                'activated' => (int) false,
            ])
            ->execute()
            ->getFirst();

        $this->session->visit($this->url.'/auth/activation/'.$user->token);
    }

    /**
     * Test the login page.
     *
     * @return void
     */
    public function testLogin()
    {
        if (! User::count()) {
            $this->testRegistration();
        }

        $this->triggerWelcomeProcess();

        # LOGIN
        $this->assertEquals('200', $this->session->getStatusCode()); // === 200
        $this->assertContains($this->url.'/auth/login', $this->session->getCurrentUrl()); // === $this->url.'auth/register'

        $login_page = $this->session->getPage();

        $login_btn = $login_page->find(
            'named',
            ['id', 'login-btn']
        );

        $login_page->fillField('email', $this->email);
        $login_page->fillField('password', $this->password);
        $login_btn->press();
        // $login_page->pressButton('login-btn');

        sleep(5);

        $this->assertContains($this->url.'/newsfeed', $this->session->getCurrentUrl()); // === $this->url.'newsfeed'
    }
}
