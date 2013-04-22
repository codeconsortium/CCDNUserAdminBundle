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

namespace CCDNUser\AdminBundle\Form\Handler;

use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;

use CCDNUser\AdminBundle\Manager\BaseManagerInterface;

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
class UpdateRolesFormHandler
{
    /**
     *
     * @access protected
     * @var \Symfony\Component\Form\FormFactory $factory
     */
    protected $factory;

    /**
     *
     * @access protected
     * @var \CCDNUser\AdminBundle\Form\Type\UpdateRolesFormType $updateRolesFormType
     */
    protected $updateRolesFormType;

    /**
     *
     * @access protected
     * @var \CCDNUser\AdminBundle\Form\Type\UpdateAccountFornType $form
     */
    protected $form;

    /**
     *
     * @access protected
     * @var \CCDNUser\AdminBundle\Manager\UserManagerInterface $manager
     */
    protected $manager;

    /**
     *
     * @access protected
     * @var \Symfony\Component\Security\Core\User\UserInterface $user
     */
    protected $user;

    /**
     *
     * @access protected
     * @var Array $roleHierarchy
     */
    protected $roleHierarchy;

    /**
     *
     * @access public
     * @param \Symfony\Component\Form\FormFactory                 $factory
     * @param \CCDNUser\AdminBundle\Form\Type\UpdateRolesFormType $updateRolesFormType
     * @param \CCDNUser\AdminBundle\Manager\UserManagerInterface  $manager
     * @param $roleHelper
     */
    public function __construct(FormFactory $factory, $updateRolesFormType, BaseManagerInterface $manager)
    {
        $this->factory = $factory;
        $this->updateRolesFormType = $updateRolesFormType;

        $this->manager = $manager;
    }

    /**
     *
     * @access public
     * @param  \Symfony\Component\Security\Core\User\UserInterface       $sender
     * @return \CCDNUser\AdminBundle\Form\Handler\UpdateRolesFormHandler
     */
    public function setUser(UserInterface $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     *
     * @access public
     * @param  Array                                                      $roleHierarchy
     * @return \CCDNForum\AdminBundle\Form\Handler\BoardCreateFormHandler
     */
    public function setRoleHierarchy(Array $roleHierarchy)
    {
        $this->roleHierarchy = $roleHierarchy;

        return $this;
    }

    /**
     *
     * @access public
     * @param  \Symfony\Component\HttpFoundation\Request $request
     * @return string
     */
    public function getSubmitAction(Request $request)
    {
        if ($request->request->has('submit')) {
            $action = key($request->request->get('submit'));
        } else {
            $action = 'post';
        }

        return $action;
    }

    /**
     *
     * @access public
     * @param  \Symfony\Component\HttpFoundation\Request $request
     * @return bool
     */
    public function process(Request $request)
    {
        $this->getForm();

        if ($request->getMethod() == 'POST') {
            $this->form->bindRequest($request);

            if ($this->form->isValid()) {
                $formData = $this->form->getData();

                if ($this->getSubmitAction($request) == 'save') {
                    $this->onSuccess($formData);

                    return true;
                }
            }
        }

        return false;
    }

    /**
     *
     * @access public
     * @return Form
     */
    public function getForm()
    {
        if (null == $this->form) {
            $params = array(
                'available_roles' => $this->roleHierarchy,
            );

            $this->form = $this->factory->create($this->updateRolesFormType, $this->user, $params);
        }

        return $this->form;
    }

    /**
     *
     * @access protected
     * @param  \Symfony\Component\Security\Core\User\UserInterface $user
     * @return \CCDNUser\AdminBundle\Manager\UserManager
     */
    protected function onSuccess(UserInterface $user)
    {
        return $this->manager->updateUser($user)->flush();
    }
}
