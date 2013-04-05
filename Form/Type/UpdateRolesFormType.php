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

use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

use Symfony\Component\Validator\Constraints\CallbackValidator;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Collection;

/**
 *
 * @author Reece Fowell <reece@codeconsortium.com>
 * @version 1.0
 */
class UpdateRolesFormType extends AbstractType
{
    /**
     *
     * @access public
     * @param FormBuilder $builder, array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
			->add('roles', 'choice',
            	array(
					'choices' => $options['available_roles'],
		            'required' => false,
		            'expanded' => true,
		            'multiple' => true,
					'label' => 'ccdn_user_admin.form.label.user.roles',
					'translation_domain' => 'CCDNUserAdminBundle',
				)
        	)
		;
    }

    /**
	 *
     * @access public
     * @param array $options
     */
    public function getDefaultOptions(array $options)
    {
		$collectionConstraint = new Collection(array(
			'new_role' => new NotNull(array('message' => 'oops')), 
		));
		
        return array(
            'data_class'      => 'CCDNUser\UserBundle\Entity\User',
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            // a unique key to help generate the secret token
            'intention'       => 'user_role_item',			
			'available_roles' => array(),
        );
    }

    /**
     *
     * @access public
     * @return string
     */
    public function getName()
    {
        return 'UpdateRoles';
    }
}