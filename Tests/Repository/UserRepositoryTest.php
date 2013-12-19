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

namespace CCDNUser\AdminBundle\Tests\Repository;

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
class UserRepositoryTest extends TestBase
{
    public function testFindAllUsersPaginated()
    {
		$this->addFixturesForUsers();
        $pager = $this->getUserModel()->findAllUsersPaginated(1, 25);
		$usersFound = $pager->getItems();

		$this->assertCount(4, $usersFound);
    }

    public function testFindAllUsersFilteredAtoZPaginated()
	{
		$this->addFixturesForUsers();
        $pager = $this->getUserModel()->findAllUsersFilteredAtoZPaginated('h', 1, 25);
		$usersFound = $pager->getItems();

		$this->assertCount(1, $usersFound);
	}

    public function testFindAllUnactivatedUsersPaginated()
    {
		$this->addFixturesForUsers();
		$this->addNewUser('foo1', 'foo1@bar.com', 'pass', false, true, true, true);
		$this->addNewUser('foo2', 'foo2@bar.com', 'pass', false, false, true, true);
        $pager = $this->getUserModel()->findAllUnactivatedUsersPaginated(1, 25);
		$usersFound = $pager->getItems();

		$this->assertCount(2, $usersFound);
    }

    public function testFindAllBannedUsersPaginated()
    {
		$this->addFixturesForUsers();
		$this->addNewUser('foo1', 'foo1@bar.com', 'pass', false, true, true, true);
		$this->addNewUser('foo2', 'foo2@bar.com', 'pass', true, true, true, true);
        $pager = $this->getUserModel()->findAllBannedUsersPaginated(1, 25);
		$usersFound = $pager->getItems();

		$this->assertCount(2, $usersFound);
    }

    public function testFindAllNewestUsersPaginated()
    {
		$this->addFixturesForUsers();
        $pager = $this->getUserModel()->findAllNewestUsersPaginated(new \Datetime('-7 days'), 1, 25);
		$usersFound = $pager->getItems();

		$this->assertCount(4, $usersFound);
    }

    public function testFindOneUserById()
    {
		$users = $this->addFixturesForUsers();
        $userFound = $this->getUserModel()->findOneUserById($users['harry']->getId());
		
		$this->assertNotNull($userFound);
    }
}