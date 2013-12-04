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
use CCDNUser\AdminBundle\Model\Model\ModelInterface;
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
class UpdateAccountFormHandler extends BaseFormHandler
{
    /**
     *
     * @access protected
     * @var \CCDNUser\AdminBundle\Form\Type\UpdateAccountFormType $updateAccountFormType
     */
    protected $updateAccountFormType;

    /**
     *
     * @access protected
     * @var \CCDNUser\AdminBundle\Model\Model\ModelInterface $userModel
     */
    protected $userModel;

    /**
     *
     * @access public
     * @param \Symfony\Component\EventDispatcher\ContainerAwareEventDispatcher $dispatcher
     * @param \Symfony\Component\Form\FormFactory                              $factory
     * @param \CCDNUser\AdminBundle\Form\Type\UpdateAccountFormType            $updateAccountFormType
     * @param \CCDNUser\AdminBundle\Model\Model\ModelInterface                 $userModel
     */
    public function __construct(ContainerAwareEventDispatcher $dispatcher, FormFactory $factory, $updateAccountFormType, ModelInterface $userModel)
    {
		$this->dispatcher = $dispatcher;
        $this->factory = $factory;
        $this->updateAccountFormType = $updateAccountFormType;
        $this->userModel = $userModel;
    }

    /**
     *
     * @access public
     * @return Form
     */
    public function getForm()
    {
        if (null == $this->form) {
            $this->dispatcher->dispatch(AdminEvents::ADMIN_USER_UPDATE_ACCOUNT_INITIALISE, new AdminUserEvent($this->request, $this->user));
			
            $this->form = $this->factory->create($this->updateAccountFormType, $this->user);
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
        $this->dispatcher->dispatch(AdminEvents::ADMIN_USER_UPDATE_ACCOUNT_SUCCESS, new AdminUserEvent($this->request, $user));
		
        $this->userModel->updateUser($user)->flush();
		
        $this->dispatcher->dispatch(AdminEvents::ADMIN_USER_UPDATE_ACCOUNT_COMPLETE, new AdminUserEvent($this->request, $user));
    }
}
