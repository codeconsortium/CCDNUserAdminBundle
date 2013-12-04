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

namespace CCDNUser\AdminBundle\Tests\Manager;

use CCDNUser\AdminBundle\Tests\TestBase;

/**
 *
 * @category CCDNUser
 * @package  AdminBundle
 *
 * @author   Reece Fowell <reece@codeconsortium.com>
 * @license  http://opensource.org/licenses/MIT MIT
 * @version  Release: 1.0
 * @link     https://github.com/codeconsortium/CCDNUserAdminBundle
 *
 */
class UserManagerTest extends TestBase
{
    public function testUpdateUser()
    {
		$users = $this->addFixturesForUsers();
		
		$users['harry']->setEmail('baz@baz.com');
		
        $this->getUserModel()->updateUser($users['harry']);
        $userFound = $this->getUserModel()->findOneUserById($users['harry']->getId());
		
		$this->assertNotNull($userFound);
		$this->assertSame('baz@baz.com', $userFound->getEmail());
    }

    public function testBanUser()
    {
		$users = $this->addFixturesForUsers();
		
        $this->getUserModel()->banUser($users['harry']);
        $userFound = $this->getUserModel()->findOneUserById($users['harry']->getId());

		$this->assertNotNull($userFound);
		$this->assertTrue($userFound->isLocked());
    }

    public function testUnbanUser()
    {
		$users = $this->addFixturesForUsers();

        $this->getUserModel()->unbanUser($users['harry']);
        $userFound = $this->getUserModel()->findOneUserById($users['harry']->getId());

		$this->assertNotNull($userFound);
		$this->assertFalse($userFound->isLocked());
    }

    public function testActivateUser()
    {
		$users = $this->addFixturesForUsers();
		
        $this->getUserModel()->activateUser($users['harry']);
        $userFound = $this->getUserModel()->findOneUserById($users['harry']->getId());

		$this->assertNotNull($userFound);
		$this->assertTrue($userFound->isEnabled());
    }

    public function testDeactivateUser()
    {
		$users = $this->addFixturesForUsers();
		
        $this->getUserModel()->deactivateUser($users['harry']);
        $userFound = $this->getUserModel()->findOneUserById($users['harry']->getId());
		
		$this->assertNotNull($userFound);
		$this->assertFalse($userFound->isEnabled());
    }
}