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
class AdministrateAccountType extends AbstractType
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
     * @param array $defaults
     * @return self
     */
    public function setDefaults($defaults = array())
    {
        $this->defaults = $defaults;

        return $this;
    }

    /**
     *
     * @access public
     * @param array $options
     * @return self
     */
    public function setOptions($options)
    {
        $this->options = $options;

        return $this;
    }

    /**
     *
     * @access public
     * @param FormBuilder $builder, array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('username', 'text');
        $builder->add('email', 'text');
        $builder->add('locked'); // banning
        $builder->add('enabled'); // activation
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
            'intention'       => 'administrate_account_item',
        );
    }

    /**
     *
     * @access public
     * @return string
     */
    public function getName()
    {
        return 'AdministrateAccount';
    }

}
