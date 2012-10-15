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

use CCDNComponent\DashboardBundle\Component\Integrator\BaseIntegrator;
use CCDNComponent\DashboardBundle\Component\Integrator\IntegratorInterface;

/**
 *
 * @author Reece Fowell <reece@codeconsortium.com>
 * @version 1.0
 */
class DashboardIntegrator extends BaseIntegrator implements IntegratorInterface
{

    /**
     *
     * Structure of $resources
     * 	[DASHBOARD_PAGE <string>]
     * 		[CATEGORY_NAME <string>]
     *			[ROUTE_FOR_LINK <string>]
     *				[AUTH <string>] (optional)
     *				[URL_LINK <string>]
     *				[URL_NAME <string>]
	 * 
	 * @access public
	 * @return array $resources
     */
    public function getResources()
    {
        $resources = array(
            'admin' => array(
                'User Administration' => array(
                    'ccdn_user_admin_show_unactivated' => array('auth' => 'ROLE_ADMIN', 'name' => 'Show Unactivated', 'icon' => $this->basePath . '/bundles/ccdncomponentcommon/images/icons/Black/32x32/32x32_users.png'),
                    'ccdn_user_admin_show_banned' => array('auth' => 'ROLE_ADMIN', 'name' => 'Show Banned', 'icon' => $this->basePath . '/bundles/ccdncomponentcommon/images/icons/Black/32x32/32x32_users.png'),
                    'ccdn_user_admin_show_newest' => array('auth' => 'ROLE_ADMIN', 'name' => 'Show Newest Users', 'icon' => $this->basePath . '/bundles/ccdncomponentcommon/images/icons/Black/32x32/32x32_users.png'),
                ),
            ),

        );

        return $resources;
    }

}
