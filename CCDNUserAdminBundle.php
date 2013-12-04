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

namespace CCDNUser\AdminBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

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
class CCDNUserAdminBundle extends Bundle
{
    /**
     *
     * @access public
     */
    public function boot()
    {
        $twig = $this->container->get('twig');
		
        $twig->addGlobal(
			'ccdn_user_admin',
			array(
	            'seo' => array(
	                'title_length' => $this->container->getParameter('ccdn_user_admin.seo.title_length'),
	            ),
	            'activation' => array(
	                'show_unactivated_users' => array(
	                    'layout_template' => $this->container->getParameter('ccdn_user_admin.activation.show_unactivated_users.layout_template'),
	                    'member_since_datetime_format' => $this->container->getParameter('ccdn_user_admin.activation.show_unactivated_users.member_since_datetime_format'),
	                ),
	            ),
	            'ban' => array(
	                'show_banned_users' => array(
	                    'layout_template' => $this->container->getParameter('ccdn_user_admin.ban.show_banned_users.layout_template'),
	                    'member_since_datetime_format' => $this->container->getParameter('ccdn_user_admin.ban.show_banned_users.member_since_datetime_format'),
	                ),
	            ),
	            'account' => array(
	                'show_newest_users' => array(
	                    'layout_template' => $this->container->getParameter('ccdn_user_admin.account.show_newest_users.layout_template'),
	                    'member_since_datetime_format' => $this->container->getParameter('ccdn_user_admin.account.show_newest_users.member_since_datetime_format'),
	                ),
	                'show_user' => array(
	                    'layout_template' => $this->container->getParameter('ccdn_user_admin.account.show_user.layout_template'),
	                    'member_since_datetime_format' => $this->container->getParameter('ccdn_user_admin.account.show_user.member_since_datetime_format'),
	                ),
	                'edit_user_account' => array(
	                    'layout_template' => $this->container->getParameter('ccdn_user_admin.account.edit_user_account.layout_template'),
	                    'form_theme' => $this->container->getParameter('ccdn_user_admin.account.edit_user_account.form_theme'),
	                ),
	            ),
	            'role' => array(
	                'set_users_role' => array(
	                    'layout_template' => $this->container->getParameter('ccdn_user_admin.role.set_users_role.layout_template'),
	                    'form_theme' => $this->container->getParameter('ccdn_user_admin.role.set_users_role.form_theme'),
	                ),
	            ),
	            'sidebar' => array(
	                'links' => $this->container->getParameter('ccdn_user_admin.sidebar.links'),
	            ),
	        )
		); // End Twig Globals.
    }
}
