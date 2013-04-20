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
 * @author Reece Fowell <reece@codeconsortium.com>
 * @version 2.0
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
				->setLabel('ccdn_user_admin.dashboard.categories.user_admin', array(), 'CCDNUserAdminBundle')
				->addPages()
					->addPage('admin')
						->setLabel('ccdn_user_admin.dashboard.pages.admin', array(), 'CCDNUserAdminBundle')
					->end()
				->end()
				->addLinks()
					->addLink('show_unactivated')
						->setAuthRole('ROLE_ADMIN')
						->setRoute('ccdn_user_admin_show_unactivated')
						->setIcon('/bundles/ccdncomponentcommon/images/icons/Black/32x32/32x32_users.png')
						->setLabel('ccdn_user_admin.title.users.unactivated', array(), 'CCDNUserAdminBundle')
					->end()
					->addLink('show_banned')
						->setAuthRole('ROLE_ADMIN')
						->setRoute('ccdn_user_admin_show_banned')
						->setIcon('/bundles/ccdncomponentcommon/images/icons/Black/32x32/32x32_users.png')
						->setLabel('ccdn_user_admin.title.users.banned', array(), 'CCDNUserAdminBundle')
					->end()
					->addLink('show_newest')
						->setAuthRole('ROLE_ADMIN')
						->setRoute('ccdn_user_admin_show_newest')
						->setIcon('/bundles/ccdncomponentcommon/images/icons/Black/32x32/32x32_users.png')
						->setLabel('ccdn_user_admin.title.users.newest', array(), 'CCDNUserAdminBundle')
					->end()
				->end()
			->end()
		;
    }
}
