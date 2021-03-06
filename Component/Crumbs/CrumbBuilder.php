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

namespace CCDNUser\AdminBundle\Component\Crumbs;

use Symfony\Component\Security\Core\User\UserInterface;

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
class CrumbBuilder extends BaseCrumbBuilder
{
    /**
     *
     * @access public
     * @return \CCDNUser\AdminBundle\Component\Crumbs\Factory\CrumbTrail
     */
    public function addMemberIndex()
    {
        return $this->createCrumbTrail()
            ->add('crumbs.show-all', 'ccdn_user_admin_member_index')
        ;
    }

    /**
     *
     * @access public
     * @return \CCDNUser\AdminBundle\Component\Crumbs\Factory\CrumbTrail
     */
    public function addMemberUnactivatedIndex()
    {
        return $this->createCrumbTrail()
            ->add('crumbs.show_unactivated', 'ccdn_user_admin_member_unactivated_index')
        ;
    }

    /**
     *
     * @access public
     * @return \CCDNUser\AdminBundle\Component\Crumbs\Factory\CrumbTrail
     */
    public function addMemberBannedIndex()
    {
        return $this->createCrumbTrail()
            ->add('crumbs.show_banned', 'ccdn_user_admin_member_banned_index')
        ;
    }

    /**
     *
     * @access public
     * @return \CCDNUser\AdminBundle\Component\Crumbs\Factory\CrumbTrail
     */
    public function addMemberNewestIndex()
    {
        return $this->createCrumbTrail()
            ->add('crumbs.show_newest', 'ccdn_user_admin_member_newest_index')
        ;
    }

    /**
     *
     * @access public
     * @return \CCDNUser\AdminBundle\Component\Crumbs\Factory\CrumbTrail
     */
    public function addAccountShow(UserInterface $user)
    {
        return $this->addMemberIndex()
            ->add(
                array(
                    'label' => 'crumbs.account.show',
                    'params' => array('%name%' => $user->getUsername())
                ),
                array(
                    'route' => 'ccdn_user_admin_account_show',
                    'params' => array('userId' => $user->getId()),
                )
            )
        ;
    }

    /**
     *
     * @access public
     * @return \CCDNUser\AdminBundle\Component\Crumbs\Factory\CrumbTrail
     */
    public function addAccountEdit(UserInterface $user)
    {
        return $this->addAccountShow($user)
            ->add(
                array(
                    'label' => 'crumbs.account.edit',
                ),
                array(
                    'route' => 'ccdn_user_admin_account_edit',
                    'params' => array('userId' => $user->getId())
                )
            )
        ;
    }

    /**
     *
     * @access public
     * @return \CCDNUser\AdminBundle\Component\Crumbs\Factory\CrumbTrail
     */
    public function addAccountChangeRoles(UserInterface $user)
    {
        return $this->addAccountShow($user)
            ->add(
                array(
                    'label' => 'crumbs.account.set_roles',
                ),
                array(
                    'route' => 'ccdn_user_admin_account_set_roles',
                    'params' => array('userId' => $user->getId())
                )
            )
        ;
    }
}
