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

/**
 *
 * @author Reece Fowell <reece@codeconsortium.com>
 * @version 1.0
 */
class UpdateAccountFormType extends AbstractType
{
    /**
     *
     * @access public
     * @param FormBuilder $builder, array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
			->add('username', 'text',
				array(
					'required' => true,
		        	'label' => 'ccdn_user_admin.form.label.account.username',
					'translation_domain' => 'CCDNUserAdminBundle'
		        )
			)
			->add('email', 'text',
				array(
					'required' => true,
		        	'label' => 'ccdn_user_admin.form.label.account.email',
					'translation_domain' => 'CCDNUserAdminBundle'
		        )
			)
	        ->add('locked', null,
				array(
					'required' => false,
		        	'label' => 'ccdn_user_admin.form.label.account.locked',
					'translation_domain' => 'CCDNUserAdminBundle'
		        )
			)
	        ->add('enabled', null,
				array(
					'required' => false,
		        	'label' => 'ccdn_user_admin.form.label.account.enabled',
					'translation_domain' => 'CCDNUserAdminBundle'
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
        return array(
            'data_class' => 'CCDNUser\UserBundle\Entity\User',
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            // a unique key to help generate the secret token
            'intention'       => 'update_account',
        );
    }

    /**
     *
     * @access public
     * @return string
     */
    public function getName()
    {
        return 'UpdateAccount';
    }
}