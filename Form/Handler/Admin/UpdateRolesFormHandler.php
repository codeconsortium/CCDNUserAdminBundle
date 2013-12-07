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

namespace CCDNUser\AdminBundle\Form\Handler\Admin;

use Symfony\Component\EventDispatcher\ContainerAwareEventDispatcher;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Security\Core\User\UserInterface;
use CCDNUser\AdminBundle\Model\FrontModel\ModelInterface;
use CCDNUser\AdminBundle\Form\Handler\BaseFormHandler;
use CCDNUser\AdminBundle\Component\Dispatcher\AdminEvents;
use CCDNUser\AdminBundle\Component\Dispatcher\Event\AdminUserEvent;

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
class UpdateRolesFormHandler extends BaseFormHandler
{
    /**
     *
     * @access protected
     * @var \CCDNUser\AdminBundle\Form\Type\UpdateRolesFormType $updateRolesFormType
     */
    protected $updateRolesFormType;

    /**
     *
     * @access protected
     * @var \CCDNUser\AdminBundle\Model\FrontModel\ModelInterface $userModel
     */
    protected $userModel;

    /**
     *
     * @access protected
     * @var Array $roleHierarchy
     */
    protected $roleHierarchy;

    /**
     *
     * @access public
     * @param \Symfony\Component\EventDispatcher\ContainerAwareEventDispatcher $dispatcher
     * @param \Symfony\Component\Form\FormFactory                              $factory
     * @param \CCDNUser\AdminBundle\Form\Type\UpdateRolesFormType              $updateRolesFormType
     * @param \CCDNUser\AdminBundle\Model\FrontModel\ModelInterface                 $userModel
     */
    public function __construct(ContainerAwareEventDispatcher $dispatcher, FormFactory $factory, $updateRolesFormType, ModelInterface $userModel)
    {
		$this->dispatcher = $dispatcher;
        $this->factory = $factory;
        $this->updateRolesFormType = $updateRolesFormType;
        $this->userModel = $userModel;
    }

    /**
     *
     * @access public
     * @param  Array                                                           $roleHierarchy
     * @return \CCDNUser\AdminBundle\Form\Handler\Admin\UpdateRolesFormHandler
     */
    public function setRoleHierarchy(Array $roleHierarchy)
    {
        $this->roleHierarchy = $roleHierarchy;

        return $this;
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

            $this->dispatcher->dispatch(AdminEvents::ADMIN_USER_UPDATE_ROLES_INITIALISE, new AdminUserEvent($this->request, $this->user));

            $this->form = $this->factory->create($this->updateRolesFormType, $this->user, $params);
        }

        return $this->form;
    }

    /**
     *
     * @access protected
     * @param  \Symfony\Component\Security\Core\User\UserInterface $user
     */
    protected function onSuccess(UserInterface $user)
    {
        $this->dispatcher->dispatch(AdminEvents::ADMIN_USER_UPDATE_ROLES_SUCCESS, new AdminUserEvent($this->request, $user));
		
        $this->userModel->updateUser($user)->flush();
		
        $this->dispatcher->dispatch(AdminEvents::ADMIN_USER_UPDATE_ROLES_COMPLETE, new AdminUserEvent($this->request, $user));
    }
}
