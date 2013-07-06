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

namespace CCDNUser\AdminBundle\Gateway;

use Symfony\Component\Security\Core\User\UserInterface;

use Doctrine\ORM\QueryBuilder;

use CCDNUser\AdminBundle\Gateway\BaseGatewayInterface;
use CCDNUser\AdminBundle\Gateway\BaseGateway;

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
class UserGateway extends BaseGateway implements BaseGatewayInterface
{
    /**
     *
     * @access private
     * @var string $queryAlias
     */
    protected $queryAlias = 'u';

    /**
     *
     * @access public
     * @param  \Doctrine\ORM\QueryBuilder                          $qb
     * @param  Array                                               $parameters
     * @return \Symfony\Component\Security\Core\User\UserInterface
     */
    public function findUser(QueryBuilder $qb = null, $parameters = null)
    {
        if (null == $qb) {
            $qb = $this->createSelectQuery();
        }

        return $this->one($qb, $parameters);
    }

    /**
     *
     * @access public
     * @param  \Doctrine\ORM\QueryBuilder                   $qb
     * @param  Array                                        $parameters
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function findUsers(QueryBuilder $qb = null, $parameters = null)
    {
        if (null == $qb) {
            $qb = $this->createSelectQuery();
        }

        return $this->all($qb, $parameters);
    }

    /**
     *
     * @access public
     * @param  \Doctrine\ORM\QueryBuilder $qb
     * @param  Array                      $parameters
     * @return int
     */
    public function countUsers(QueryBuilder $qb = null, $parameters = null)
    {
        if (null == $qb) {
            $qb = $this->createCountQuery();
        }

        if (null == $parameters) {
            $parameters = array();
        }

        $qb->setParameters($parameters);

        try {
            return $qb->getQuery()->getSingleScalarResult();
        } catch (\Doctrine\ORM\NoResultException $e) {
            return 0;
        }
    }

    /**
     *
     * @access public
     * @param  \Symfony\Component\Security\Core\User\UserInterface $user
     * @return \CCDNUser\AdminBundle\Gateway\BaseGatewayInterface
     */
    public function persistUser(UserInterface $user)
    {
        $this->persist($user)->flush();

        return $this;
    }

    /**
     *
     * @access public
     * @param  \Symfony\Component\Security\Core\User\UserInterface $user
     * @return \CCDNUser\AdminBundle\Gateway\BaseGatewayInterface
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
     * @return \CCDNUser\AdminBundle\Gateway\BaseGatewayInterface
     */
    public function deleteUser(UserInterface $user)
    {
        $this->remove($user)->flush();

        return $this;
    }
}
