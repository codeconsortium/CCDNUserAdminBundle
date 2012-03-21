<?php

/*
 * This file is part of the CCDN ProfileBundle
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
class AdministrateProfileType extends AbstractType
{
	
	
	
	/**
	 *
	 * @access protected
	 */
	protected $options;
	
	
	
	/**
	 *
	 * @access protected
	 */	
	protected $defaults;
	
	
	
	/**
	 * Use this to set default entity values.
	 *
	 * @access public
	 * @param Array() $options
	 * @return $this
	 */
	public function setDefaults($defaults = array())
	{
		$this->defaults = $defaults;
		
		return $this;
	}
	
	
	
	/**
	 *
	 * @access public
	 * @param Array() $options
	 * @return $this
	 */
	public function setOptions($options)
	{
		$this->options = $options;
		
		return $this;
	}
	
		
	
	/**
	 *
	 * @access public
	 * @param FormBuilder $builder, Array() $options
	 */
	public function buildForm(FormBuilder $builder, array $options)
	{
		$builder
			->add('avatar_is_remote')
			->add('avatar')
			->add('aim')
			->add('aim_is_public')
			->add('msn')
			->add('msn_is_public')
			->add('icq')
			->add('icq_is_public')
			->add('yahoo')
			->add('yahoo_is_public')
			->add('website')
			->add('bio')
			->add('location')
			->add('signature');
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
			'data_class' => 'CCDNUser\ProfileBundle\Entity\Profile',
			'csrf_protection' => true,
            'csrf_field_name' => '_token',
            // a unique key to help generate the secret token
            'intention'       => 'administrate_profile_item',
		);
	}


	/**
	 *
	 * @access public
	 * @return string
	 */
	public function getName()
	{
		return 'AdministrateProfile';
	}
	
}