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

namespace CCDNUser\AdminBundle\Controller;

use Symfony\Component\Security\Core\User\UserInterface;

use CCDNUser\AdminBundle\Controller\BaseController;

/**
 *
 * @author Reece Fowell <reece@codeconsortium.com>
 * @version 1.0
 */
class UserBaseController extends BaseController
{
	/**
	 *
	 * @access protected
	 * @return Array
	 */
	protected function getRoleHierarchy()
	{
        $roleHierarchy = $this->container->getParameter('security.role_hierarchy.roles');
        
        $roles = array();
		
        foreach ($roleHierarchy as $roleName => $roleSubs) {
            $subs = '<ul><li>' . implode('</li><li>', $roleSubs) . '</li></ul>';
            $roles[$roleName] = '<strong>' . $roleName . '</strong>' . ($subs != '<ul><li>' . $roleName . '</li></ul>' ? "\n" . $subs:'');
        }
		
		return $roles;	
	}
	
	public function getFormHandlerToUpdateAccount(UserInterface $user)
	{
        $formHandler = $this->container->get('ccdn_user_admin.form.handler.update_account');
			
		$formHandler->setUser($user);
		
		return $formHandler;
	}
	
	public function getFormHandlerToUpdateRolesForUser(UserInterface $user)
	{
        $formHandler = $this->container->get('ccdn_user_admin.form.handler.update_roles');
			
		$formHandler
			->setUser($user)
			->setRoleHierarchy($this->getRoleHierarchy())
		;
		
		return $formHandler;
	}
}