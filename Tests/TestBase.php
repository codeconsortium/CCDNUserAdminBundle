<?php

/*
 * This file is part of the CCDNUser AdminBundle
 *
 * (c) CCDN (c) CodeConsortium <http://www.codeconsortium.com/>
 *
 * Available on github <http://www.github.com/codeconsortium/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CCDNUser\AdminBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;

use CCDNUser\AdminBundle\Tests\Functional\src\Entity\User;
use CCDNUser\AdminBundle\Entity\Security;

class TestBase extends WebTestCase
{
    /**
	 *
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

	/**
	 *
	 * @var $container
	 */
	private $container;

	/**
	 *
	 * @access public
	 */
    public function setUp()
    {
        $kernel = static::createKernel();

        $kernel->boot();
		
		$this->container = $kernel->getContainer();

        $this->em = $this->container->get('doctrine.orm.entity_manager');
		
		$this->purge();
    }

	/*
     *
     * Close doctrine connections to avoid having a 'too many connections'
     * message when running many tests
     */
	public function tearDown(){
		$this->container->get('doctrine')->getConnection()->close();
	
		parent::tearDown();
	}

    protected function purge()
    {
        $purger = new ORMPurger($this->em);
        $executor = new ORMExecutor($this->em, $purger);
        $executor->purge();
	}

	protected function addNewUser($username, $email, $password, $active = true, $banned = false, $persist = true, $andFlush = true)
	{
		$user = new User();
		
		$user->setUsername($username);
		$user->setEmail($email);
		$user->setPlainPassword($password);
		$user->setEnabled($active);
		$user->setLocked($banned);
		
		if ($persist) {
			$this->em->persist($user);
			
			if ($andFlush) {
				$this->em->flush();
				$this->em->refresh($user);
			}
		}
		
		return $user;
	}

	protected function addFixturesForUsers($persist = true, $andFlush = true)
	{
		$userNames = array('admin', 'tom', 'dick', 'harry');
		$users = array();
		
		foreach ($userNames as $username) {
			$users[$username] = $this->addNewUser($username, $username . '@foobar.com', 'password', true, false, $persist, $andFlush);
		}

		if ($persist && $andFlush) {
			$this->em->flush();
		}
	
		return $users;
	}

    /**
     *
     * @var \CCDNUser\AdminBundle\Model\Model\UserModel $userModel
     */
    private $userModel;

    /**
     *
     * @access protected
     * @return \CCDNUser\AdminBundle\Model\Model\UserModel
     */
    protected function getUserModel()
    {
        if (null == $this->userModel) {
            $this->userModel = $this->container->get('ccdn_user_admin.model.user');
        }

        return $this->userModel;
    }
}
