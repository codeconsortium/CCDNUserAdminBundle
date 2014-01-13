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
class UpdateAccountFormType extends AbstractType
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
            ->add('username', 'text',
                array(
                    'required'           => true,
                    'label'              => 'form.label.username',
                    'translation_domain' => 'CCDNUserAdminBundle'
                )
            )
            ->add('email', 'text',
                array(
                    'required'           => true,
                    'label'              => 'form.label.email',
                    'translation_domain' => 'CCDNUserAdminBundle'
                )
            )
            ->add('locked', null,
                array(
                    'required'           => false,
                    'label'              => 'form.label.locked',
                    'translation_domain' => 'CCDNUserAdminBundle'
                )
            )
            ->add('enabled', null,
                array(
                    'required'           => false,
                    'label'              => 'form.label.enabled',
                    'translation_domain' => 'CCDNUserAdminBundle'
                )
            )
        ;
    }

    /**
     *
     * @access public
     * @param \Symfony\Component\OptionsResolver\OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'         => $this->userClass,
            'csrf_protection'    => true,
            'csrf_field_name'    => '_token',
            // a unique key to help generate the secret token
            'intention'          => 'update_account',
            'validation_groups'  => array('update_account'),
        ));
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
