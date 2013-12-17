<?php

/*
 * This file is part of the CCDNUser UserAdminBundle
 *
 * (c) CCDN (c) CodeConsortium <http://www.codeconsortium.com/>
 *
 * Available on github <http://www.github.com/codeconsortium/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CCDNUser\AdminBundle\Component\Dashboard;

use CCDNComponent\DashboardBundle\Component\Integrator\Model\BuilderInterface;

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
class DashboardIntegrator
{
    /**
     *
     * @access public
     * @param CCDNComponent\DashboardBundle\Component\Integrator\Model\BuilderInterface $builder
     */
    public function build(BuilderInterface $builder)
    {
        $builder
            ->addCategory('user_administration')
                ->setLabel('dashboard.categories.user_admin', array(), 'CCDNUserAdminBundle')
                ->addPages()
                    ->addPage('admin')
                        ->setLabel('dashboard.pages.admin', array(), 'CCDNUserAdminBundle')
                    ->end()
                ->end()
                ->addLinks()
                    ->addLink('show_unactivated')
                        ->setAuthRole('ROLE_ADMIN')
                        ->setRoute('ccdn_user_admin_member_unactivated_index')
                        ->setIcon('/bundles/ccdncomponentcommon/images/icons/Black/32x32/32x32_users.png')
                        ->setLabel('dashboard.links.unactivated', array(), 'CCDNUserAdminBundle')
                    ->end()
                    ->addLink('show_banned')
                        ->setAuthRole('ROLE_ADMIN')
                        ->setRoute('ccdn_user_admin_member_banned_index')
                        ->setIcon('/bundles/ccdncomponentcommon/images/icons/Black/32x32/32x32_users.png')
                        ->setLabel('dashboard.links.banned', array(), 'CCDNUserAdminBundle')
                    ->end()
                    ->addLink('show_newest')
                        ->setAuthRole('ROLE_ADMIN')
                        ->setRoute('ccdn_user_admin_member_newest_index')
                        ->setIcon('/bundles/ccdncomponentcommon/images/icons/Black/32x32/32x32_users.png')
                        ->setLabel('dashboard.links.newest', array(), 'CCDNUserAdminBundle')
                    ->end()
                ->end()
            ->end()
        ;
    }
}
