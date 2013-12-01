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

namespace CCDNUser\AdminBundle\Model\Repository;

use CCDNUser\AdminBundle\Model\Repository\BaseRepository;
use CCDNUser\AdminBundle\Model\Repository\RepositoryInterface;

/**
 * ProfileRepository
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

        $qb
			->addOrderBy('u.username', 'DESC')
            ->addOrderBy('u.registeredDate', 'DESC')
        ;

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
            ->addOrderBy('u.username', 'DESC')
            ->addOrderBy('u.registeredDate', 'DESC')
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
    public function findAllUnactivatedUsersPaginated($page, $itemsPerPage = 25)
    {
        $qb = $this->createSelectQuery(array('u'));

        $qb
            ->where('u.enabled = FALSE')
            ->orderBy('u.registeredDate', 'DESC')
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
    public function findAllBannedUsersPaginated($page, $itemsPerPage = 25)
    {
        $qb = $this->createSelectQuery(array('u'));

        $qb
            ->where('u.locked = TRUE')
            ->orderBy('u.registeredDate', 'DESC')
        ;

        return $this->gateway->paginateQuery($qb, $itemsPerPage, $page);
    }

    /**
     *
     * @access public
     * @param  int                                          $page
     * @param  int                                          $itemsPerPage
     * @param  \Datetime                                    $dateLimit
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function findAllNewestUsersPaginated($page, $itemsPerPage = 25, \Datetime $dateLimit)
    {
        $qb = $this->createSelectQuery(array('u'));

        $params = array(':date' => $dateLimit);

        $qb
            ->where('u.registeredDate > :date')
            ->setParameters($params)
            ->orderBy('u.registeredDate', 'DESC')
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
