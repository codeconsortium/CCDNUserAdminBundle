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

namespace CCDNUser\AdminBundle\Form\Type\Admin;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

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
class UpdateRolesFormType extends AbstractType
{
    /**
     *
     * @access protected
     * @var string $userClass
     */
    protected $userClass;

    /**
     *
     * @access public
     * @var string $userClass
     */
    public function __construct($userClass)
    {
        $this->userClass = $userClass;
    }

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
                    'choices'            => $options['available_roles'],
                    'required'           => false,
                    'expanded'           => true,
                    'multiple'           => true,
                    'label'              => 'form.label.roles',
                    'translation_domain' => 'CCDNUserAdminBundle',
                )
            )
        ;
    }

	/**
	 * 
	 * @access public
	 * @param  \Symfony\Component\OptionsResolver\OptionsResolverInterface $resolver
	 */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
	    $resolver->setDefaults(array(
            'data_class'         => $this->userClass,
            'csrf_protection'    => true,
            'csrf_field_name'    => '_token',
            // a unique key to help generate the secret token
            'intention'          => 'user_role_item',
            'validation_groups'  => array('update_account_roles'),
            'available_roles'    => array(),
        ));
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
