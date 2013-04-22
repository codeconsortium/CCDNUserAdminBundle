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

namespace CCDNUser\AdminBundle\Manager;

use Symfony\Component\Security\Core\User\UserInterface;

use CCDNUser\AdminBundle\Manager\BaseManagerInterface;
use CCDNUser\AdminBundle\Manager\BaseManager;

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
class UserManager extends BaseManager implements BaseManagerInterface
{
    /**
     *
     * @access public
     * @param  int                                          $page
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getUnactivatedUsersPaginated($page)
    {
        $qb = $this->createSelectQuery(array('u'));

        $qb
            ->where('u.enabled = FALSE')
            ->orderBy('u.registeredDate', 'DESC')
        ;

        return $this->gateway->paginateQuery($qb, $this->getUsersPerPage(), $page);
    }

    /**
     *
     * @access public
     * @param  int                                          $page
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getBannedUsersPaginated($page)
    {
        $qb = $this->createSelectQuery(array('u'));

        $qb
            ->where('u.locked = TRUE')
            ->orderBy('u.registeredDate', 'DESC')
        ;

        return $this->gateway->paginateQuery($qb, $this->getUsersPerPage(), $page);
    }

    /**
     *
     * @access public
     * @param  int                                          $page
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getNewestUsersPaginated($page, $dateLimit)
    {
        $qb = $this->createSelectQuery(array('u'));

        $params = array(':date' => $dateLimit);

        $qb
            ->where('u.registeredDate > :date')
            ->setParameters($params)
            ->orderBy('u.registeredDate', 'DESC')
        ;

        return $this->gateway->paginateQuery($qb, $this->getUsersPerPage(), $page);
    }

    /**
     *
     * @access public
     * @param  int                                          $userId
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function findOneById($userId)
    {
        if (null == $userId || ! is_numeric($userId) || $userId == 0) {
            throw new \Exception('User id "' . $userId . '" is invalid!');
        }

        $qb = $this->createSelectQuery(array('u'));

        $params = array(':userId' => $userId);

        $qb
            ->where('u.id = :userId')
        ;

        return $this->gateway->findUser($qb, $params);
    }

    /**
     *
     * @access public
     * @param  \Symfony\Component\Security\Core\User\UserInterface $user
     * @return \CCDNUser\AdminBundle\Manager\UserManager
     */
    public function updateUser(UserInterface $user)
    {
        $this->persist($user)->flush();

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

        $this->persist($user)->flush();

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

        $this->persist($user)->flush();

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

        $this->persist($user)->flush();

        return $this;
    }

    /**
     *
     * @access public
     * @param  \Symfony\Component\Security\Core\User\UserInterface $user
     * @return \CCDNUser\AdminBundle\Manager\UserManager
     */
    public function forceReActivateUser(UserInterface $user)
    {
        $user->setEnabled(false);

        $this->persist($user)->flush();

        return $this;
    }
}
