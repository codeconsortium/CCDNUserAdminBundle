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

namespace CCDNUser\AdminBundle\Component\Helper;

use Symfony\Component\DependencyInjection\ContainerAware;

/**
 *
 * @author Reece Fowell <reece@codeconsortium.com>
 * @version 1.0
 */
class RoleHelper extends ContainerAware
{

	protected $container;
	protected $availableRoles;
	
	public function __construct($serviceContainer)
	{
		
		$this->container = $serviceContainer;
	}
	
	public function getAvailableRoles()
	{
		if (! $this->availableRoles || count($this->availableRoles) < 1) {
			$roles = $this->container->getParameter('security.role_hierarchy.roles');		
			
			// Remove the associate arrays.
			$this->availableRoles = array_keys($roles);
		}
		
		return $this->availableRoles;
	}
	
	public function getRoleFromIntKey($key)
	{
		
	}
	

	/**
	 *
	 * @return int $highestUsersRoleKey
	 */
	public function getUsersHighestRole($usersRoles)
	{
		$usersHighestRoleKey = 0;

		// Compare (A)vailable roles against (U)sers roles.		
		foreach($this->availableRoles as $aRoleKey => $aRole) {
			foreach($usersRoles as $uRoleKey => $uRole) {
				if ($uRole == $aRole && $aRoleKey > $usersHighestRoleKey) {
					$usersHighestRoleKey = $aRoleKey;
					
					break;
				}
			}			
		}
		
		return $usersHighestRoleKey;
	}

}