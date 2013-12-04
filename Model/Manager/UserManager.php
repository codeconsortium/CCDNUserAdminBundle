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

namespace CCDNUser\AdminBundle\Model\Manager;

use Symfony\Component\Security\Core\User\UserInterface;

use CCDNUser\AdminBundle\Model\Manager\ManagerInterface;
use CCDNUser\AdminBundle\Model\Manager\BaseManager;

/**
 *
 * @category CCDNUser
 * @package  AdminBundle
 *
 * @author   Reece Fowell <reece@codeconsortium.com>
 * @license  http://opensource.org/licenses/MIT MIT
 * @version  Release: 2.0
 * @link     https://github.com/codeconsortium/CCDNUserAdminBundle
 *
 */
class UserManager extends BaseManager implements ManagerInterface
{
    /**
     *
     * @access public
     * @param  \Symfony\Component\Security\Core\User\UserInterface $user
     * @return \CCDNUser\AdminBundle\Manager\UserManager
     */
    public function updateUser(UserInterface $user)
    {
        $this->gateway->updateUser($user);

        return $this;
    }

    /**
     *
     * @access public
     * @param  \Symfony\Component\Security\Core\User\UserInterface $user
     * @return \CCDNUser\AdminBundle\Manager\UserManager
     */
    public function banUser(UserInterface $user)
    {
        $user->setLocked(true);

        $this->gateway->updateUser($user);

        return $this;
    }

    /**
     *
     * @access public
     * @param  \Symfony\Component\Security\Core\User\UserInterface $user
     * @return \CCDNUser\AdminBundle\Manager\UserManager
     */
    public function unbanUser(UserInterface $user)
    {
        $user->setLocked(false);

        $this->gateway->updateUser($user);

        return $this;
    }

    /**
     *
     * @access public
     * @param  \Symfony\Component\Security\Core\User\UserInterface $user
     * @return \CCDNUser\AdminBundle\Manager\UserManager
     */
    public function activateUser(UserInterface $user)
    {
        $user->setEnabled(true);

        $this->gateway->updateUser($user);

        return $this;
    }

    /**
     *
     * @access public
     * @param  \Symfony\Component\Security\Core\User\UserInterface $user
     * @return \CCDNUser\AdminBundle\Manager\UserManager
     */
    public function deactivateUser(UserInterface $user)
    {
        $user->setEnabled(false);

        $this->gateway->updateUser($user);

        return $this;
    }
}
