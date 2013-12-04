<?php

/*
 * This file is part of the CCDNUser SecurityBundle
 *
 * (c) CCDN (c) CodeConsortium <http://www.codeconsortium.com/>
 *
 * Available on github <http://www.github.com/codeconsortium/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CCDNUser\AdminBundle\features\bootstrap;

use Behat\MinkExtension\Context\RawMinkContext;
use Behat\Mink\Element\NodeElement;

use Behat\Symfony2Extension\Context\KernelAwareInterface;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Symfony\Component\HttpKernel\KernelInterface;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 *
 * Features context.
 *
 * @category CCDNUser
 * @package  SecurityBundle
 *
 * @author   Reece Fowell <reece@codeconsortium.com>
 * @license  http://opensource.org/licenses/MIT MIT
 * @version  Release: 2.0
 * @link     https://github.com/codeconsortium/CCDNUserSecurityBundle
 *
 */
class FeatureContext extends RawMinkContext implements KernelAwareInterface
{
    /**
     *
     * Kernel.
     *
     * @var KernelInterface
     */
    private $kernel;

    /**
     *
     * Parameters.
     *
     * @var array
     */
    private $parameters;

    /**
     *
     * Initializes context.
     * Every scenario gets it's own context object.
     *
     * @param array $parameters context parameters (set them up through behat.yml)
     */
    public function __construct(array $parameters)
    {
        // Initialize your context here
        $this->parameters = $parameters;

        // Web user context.
        $this->useContext('web-user', new WebUser());
    }

    /**
     *
     * {@inheritdoc}
     */
    public function setKernel(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     *
     * @BeforeScenario
     */
    public function purgeDatabase()
    {
        $entityManager = $this->kernel->getContainer()->get('doctrine.orm.entity_manager');

        $purger = new ORMPurger($entityManager);
        $purger->purge();
    }

    private function getPage()
    {
        return $this->getMainContext()->getSession()->getPage();
    }

    /**
     *
     * @Given /^I am logged in as "([^"]*)"$/
     */
    public function iAmLoggedInAs($user)
    {
        $session = $this->getMainContext()->getSession();
        $session->setBasicAuth($user . '@foo.com', 'root');
    }

	const RESULT_BANNED = 1;
	const RESULT_ACTIVE = 2;

    /**
     * @Given /^the user should not be banned$/
     */
    public function shouldNotBeBanned()
    {
        $elements = $this->getPage()->findAll('css', 'table > tbody > tr');
        $didFindBanStatus = false;
		$result = 0;

        foreach ($elements as $element) {
			$cells = $element->findAll('css', 'td');
            if (strpos(strtolower($cells[0]->getText()), 'ban status') !== false) {
                $didFindBanStatus = true;
				$banStatus = strtolower($cells[1]->getText());
	            if (strpos($banStatus, 'banned') !== false) {
					$result = self::RESULT_BANNED;
				}
	            if (strpos($banStatus, 'active') !== false) {
					$result = self::RESULT_ACTIVE;
				}
				
				break;
            }
        }
        
        WebTestCase::assertTrue($didFindBanStatus, "ban status was not found.");
        WebTestCase::assertSame(self::RESULT_ACTIVE, $result, "user should is banned but should be active.");
    }

    /**
     * @Given /^the user should be banned$/
     */
    public function shouldBeBanned()
    {
        $elements = $this->getPage()->findAll('css', 'table > tbody > tr');
        $didFindBanStatus = false;
		$result = 0;

        foreach ($elements as $element) {
			$cells = $element->findAll('css', 'td');
            if (strpos(strtolower($cells[0]->getText()), 'ban status') !== false) {
				//ldd($cells[1]->getText());
                $didFindBanStatus = true;
				$banStatus = strtolower($cells[1]->getText());
	            if (strpos($banStatus, 'banned') !== false) {
					$result = self::RESULT_BANNED;
				}
	            if (strpos($banStatus, 'active') !== false) {
					$result = self::RESULT_ACTIVE;
				}
				
				break;
            }
        }

        WebTestCase::assertTrue($didFindBanStatus, "ban status was not found.");
        WebTestCase::assertSame(self::RESULT_BANNED, $result, "user should is active but should be banned.");
    }

    /**
     * @Given /^I "([^"]*)" the user$/
     */
    public function iUpdateTheUser($buttonLabel)
    {
		$label = strtolower($buttonLabel);
        $elements = $this->getPage()->findAll('css', 'a.btn');
		$didFindButton = false;
		$button = null;
		
        foreach ($elements as $element) {
            if (strtolower($element->getText()) == $label) {
                $didFindButton = true;
				$button = $element;
            }
        }
        
        WebTestCase::assertTrue($didFindButton, "the ban button was not found.");
		$button->click();
    }
}
