<?php

/*
 * This file is part of the CCDN UserAdminBundle
 *
 * (c) CCDN (c) CodeConsortium <http://www.codeconsortium.com/> 
 * 
 * Available on github <http://www.github.com/codeconsortium/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CCDNUser\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

/**
 * 
 * @author Reece Fowell <reece@codeconsortium.com> 
 * @version 1.0
 */
class RoleType extends AbstractType
{
	
	
	/**
	 *
	 * @access protected
	 */
	protected $options;
	
	
	/**
	 *
	 * @access public
	 * @param Array() $options
	 */
	public function setOptions($options)
	{
		$this->options = $options;
	}
	
	
	/**
	 *
	 * @access public
	 * @param FormBuilder $builder, Array() $options
	 */
	public function buildForm(FormBuilder $builder, array $options)
	{

		$user = $this->options['user'];
		
		$roles = array('ROLE_USER', 'ROLE_MODERATOR', 'ROLE_ADMIN', 'ROLE_SUPER_ADMIN');
		
		//echo '<pre>' . print_r($user->getRoles(), true) . '</pre>'; die();
		$role = $user->getRoles();
		
		$builder->add('role', 'choice', 
			array('choices' => $roles, 'preferred_choices' => array($role[0]) )
		);
	}
	
	
	/**
	 *
	 * for creating and replying to topics
	 *
	 * @access public
	 * @param Array() $options
	 */
	public function getDefaultOptions(array $options)
	{
		return array(
			'data_class' => 'CCDNUser\UserBundle\Entity\User',
			'csrf_protection' => true,
            'csrf_field_name' => '_token',
            // a unique key to help generate the secret token
            'intention'       => 'user_role_item',
		);
	}


	/**
	 *
	 * @access public
	 * @return string
	 */
	public function getName()
	{
		return 'Role';
	}
	
}
