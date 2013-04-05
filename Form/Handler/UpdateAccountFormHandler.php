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
 * @author Reece Fowell <reece@codeconsortium.com>
 * @version 1.0
 */
class UpdateAccountFormHandler
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
	 * @var \CCDNUser\AdminBundle\Form\Type\UpdateAccountFormType $updateAccountFormType
	 */
	protected $updateAccountFormType;
	
    /**
	 *
	 * @access protected
	 * @var \CCDNUser\AdminBundle\Manager\UserManagerInterface $manager
	 */
    protected $manager;

    /**
	 * 
	 * @access protected
	 * @var \CCDNUser\AdminBundle\Form\Type\UpdateAccountFornType $form 
	 */
    protected $form;

    /**
	 * 
	 * @access protected
	 * @var \Symfony\Component\Security\Core\User\UserInterface $user 
	 */
    protected $user;
	
    /**
     *
     * @access public
     * @param \Symfony\Component\Form\FormFactory $factory
	 * @param \CCDNUser\AdminBundle\Form\Type\UpdateAccountFormType $updateAccountFormType
	 * @param \CCDNUser\AdminBundle\Manager\UserManagerInterface $manager
     */
    public function __construct(FormFactory $factory, $updateAccountFormType, BaseManagerInterface $manager)
    {
        $this->factory = $factory;
		$this->updateAccountFormType = $updateAccountFormType;
		
        $this->manager = $manager;
    }

	/**
	 *
	 * @access public
	 * @param \Symfony\Component\Security\Core\User\UserInterface $sender
	 * @return \CCDNUser\AdminBundle\Form\Handler\UpdateAccountFormHandler
	 */
	public function setUser(UserInterface $user)
	{
		$this->user = $user;
		
		return $this;
	}
	
	/**
	 *
	 * @access public
	 * @param \Symfony\Component\HttpFoundation\Request $request
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
	 * @param \Symfony\Component\HttpFoundation\Request $request
     * @return bool
     */
    public function process(Request $request)
    {
        $this->getForm();

        if ($request->getMethod() == 'POST') {
			$this->form->bindRequest($request);

            if ($this->form->isValid()) {
	            $user = $this->form->getData();

				if ($this->getSubmitAction($request) == 'save') {
	                $this->onSuccess($user);

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
			$this->form = $this->factory->create($this->updateAccountFormType, $this->user);
        }

        return $this->form;
    }

    /**
     *
     * @access protected
     * @param \Symfony\Component\Security\Core\User\UserInterface $user
     * @return \CCDNUser\AdminBundle\Manager\UserManager
     */
    protected function onSuccess(UserInterface $user)
    {
        return $this->manager->updateUser($user)->flush();
    }
}