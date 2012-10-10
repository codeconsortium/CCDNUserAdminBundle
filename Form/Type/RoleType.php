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
	 * @access protected
	 */
	protected $roleHelper;
	
	/**
     *
     * @access public
     * @param RoleHelper $roleHelper
     */
    public function __construct($roleHelper)
    {
        $this->options = array();
		$this->roleHelper = $roleHelper;
    }

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

		$availableRoles = $this->roleHelper->getAvailableRoles();
		$currentRole = $this->roleHelper->getUsersHighestRole($user->getRoles());
				
        $builder->add('new_role', 'choice',
            array('choices' => $availableRoles, 'multiple' => false, 'expanded' => false, 'preferred_choices' => array($currentRole), 'property_path' => false)
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
