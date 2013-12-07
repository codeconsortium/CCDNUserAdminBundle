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

namespace CCDNUser\AdminBundle\Model\Component\Repository;

use CCDNUser\AdminBundle\Model\Component\Repository\BaseRepository;
use CCDNUser\AdminBundle\Model\Component\Repository\RepositoryInterface;

/**
 * UserRepository
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
class UserRepository extends BaseRepository implements RepositoryInterface
{
    /**
     *
     * @access public
     * @param  int                                          $page
     * @param  int                                          $itemsPerPage
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function findAllUsersPaginated($page = 1, $itemsPerPage = 25)
    {
        $qb = $this->createSelectQuery(array('u'));
		
        return $this->gateway->paginateQuery($qb, $itemsPerPage, $page);
    }

    /**
     *
     * @access public
     * @param  char                                         $alpha
     * @param  int                                          $page
     * @param  int                                          $itemsPerPage
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function findAllUsersFilteredAtoZPaginated($alpha, $page = 1, $itemsPerPage = 25)
    {
        $qb = $this->createSelectQuery(array('u'));

        $params = array(':filter' => $alpha . '%');

        $qb
            ->where('u.username LIKE :filter')
            ->setParameters($params)
        ;

        return $this->gateway->paginateQuery($qb, $itemsPerPage, $page);
    }

    /**
     *
     * @access public
     * @param  int                                          $page
     * @param  int                                          $itemsPerPage
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function findAllUnactivatedUsersPaginated($page = 1, $itemsPerPage = 25)
    {
        $qb = $this->createSelectQuery(array('u'));

        $qb
            ->where('u.enabled = FALSE')
        ;

        return $this->gateway->paginateQuery($qb, $itemsPerPage, $page);
    }

    /**
     *
     * @access public
     * @param  int                                          $page
     * @param  int                                          $itemsPerPage
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function findAllBannedUsersPaginated($page = 1, $itemsPerPage = 25)
    {
        $qb = $this->createSelectQuery(array('u'));

        $qb
            ->where('u.locked = TRUE')
        ;

        return $this->gateway->paginateQuery($qb, $itemsPerPage, $page);
    }

    /**
     *
     * @access public
     * @param  \Datetime                                    $dateLimit
     * @param  int                                          $page
     * @param  int                                          $itemsPerPage
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function findAllNewestUsersPaginated(\Datetime $dateLimit, $page = 1, $itemsPerPage = 25)
    {
        $qb = $this->createSelectQuery(array('u'));

        $params = array(':date' => $dateLimit);

        $qb
            ->where('u.registeredDate > :date')
            ->setParameters($params)
        ;

        return $this->gateway->paginateQuery($qb, $itemsPerPage, $page);
    }

    /**
     *
     * @access public
     * @param  int                                          $userId
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function findOneUserById($userId)
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
}
