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

namespace CCDNUser\AdminBundle\Controller;

use CCDNUser\AdminBundle\Controller\BaseController;

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
class AccountController extends BaseController
{
	 /**
	 *
	 * @access public
	 * @param  int                             $userId
	 * @return RedirectResponse|RenderResponse
	 */
	public function showAction($userId)
	{
	    $this->isAuthorised('ROLE_ADMIN');
	    $user = $this->getUserModel()->findOneUserById($userId);
	    $this->isFound($user);
   	
	    return $this->renderResponse('CCDNUserAdminBundle:User:User/show_user.html.', array(
	        'crumbs' => $this->getCrumbs()->addAccountShow($user),
	        'user' => $user,
	    ));
	}

	/**
	 *
	 * @access public
	 * @param  int                             $userId
	 * @return RedirectResponse|RenderResponse
	 */
	public function editAction($userId)
	{
	    $this->isAuthorised('ROLE_ADMIN');
	    $user = $this->getUserModel()->findOneUserById($userId);
	    $this->isFound($user);
   	
	    if ($user->getId() == $this->getUser()->getId()) {
	        throw new AccessDeniedException('You cannot administrate yourself.');
	    }
   	
	    $formHandler = $this->getFormHandlerToUpdateAccount($user);
   	
	    if ($formHandler->process($this->getRequest())) {
	        $response = $this->redirectResponse($this->path('ccdn_user_admin_account_show', array('userId' => $userId)));
	    } else {
	     $response = $this->renderResponse('CCDNUserAdminBundle:User:User/update_account.html.', array(
	            'crumbs' => $this->getCrumbs()->addAccountEdit($user),
	            'form' => $formHandler->getForm()->createView(),
	            'theme' => $this->container->getParameter('ccdn_user_admin.account.edit_user_account.form_theme'),
	            'user' => $user,
	        ));
	    }

        return $response;
	}

   /**
    *
    * @access public
    * @param  int                             $userId
    * @return RedirectResponse|RenderResponse
    */
   public function changeRolesAction($userId)
   {
       $this->isAuthorised('ROLE_SUPER_ADMIN');
       $user = $this->getUserModel()->findOneUserById($userId);
       $this->isFound($user);

       if ($user->getId() == $this->getUser()->getId()) {
           throw new AccessDeniedException('You cannot administrate yourself.');
       }

       $formHandler = $this->getFormHandlerToUpdateRolesForUser($user);

       if ($formHandler->process($this->getRequest())) {
           $this->setFlash('notice', $this->trans('ccdn_user_admin.flash.user.set_roles.success', array('%user_name%' => $user->getUsername())));

           $response = $this->redirectResponse($this->path('ccdn_user_admin_account_show', array('userId' => $user->getId())));
       } else {
           $response = $this->renderResponse('CCDNUserAdminBundle:User:User/update_roles.html.', array(
               'crumbs' => $this->getCrumbs()->addAccountChangeRoles($user),
               'form' => $formHandler->getForm()->createView(),
               'theme' => $this->container->getParameter('ccdn_user_admin.account.edit_user_account.form_theme'),
               'user' => $user,
           ));
       }
	
	return $response;
   }

    /**
     *
     * @access public
     * @param  int              $userId
     * @return RedirectResponse
     */
    public function activateAction($userId)
    {
        $this->isAuthorised('ROLE_ADMIN');
        $user = $this->getUserModel()->findOneUserById($userId);
        $this->isFound($user);

        if ($user->getId() == $this->getUser()->getId()) {
            throw new AccessDeniedException('You cannot administrate yourself.');
        }

        $this->getUserModel()->activateUser($user)->flush();

        $this->setFlash('notice', $this->trans('flash.success.user.activate', array('%name%' => $user->getUsername())));

        return $this->redirectResponse($this->path('ccdn_user_admin_account_show', array('userId' => $userId)));
    }

    /**
     *
     * @access public
     * @param  int              $userId
     * @return RedirectResponse
     */
    public function forceReActivationAction($userId)
    {
        $this->isAuthorised('ROLE_ADMIN');
        $user = $this->getUserModel()->findOneUserById($userId);
        $this->isFound($user);

        if ($user->getId() == $this->getUser()->getId()) {
            throw new AccessDeniedException('You cannot administrate yourself.');
        }

        $this->getUserModel()->forceReActivateUser($user)->flush();

        $this->setFlash('notice', $this->trans('flash.success.user.force_reactivation', array('%name%' => $user->getUsername())));

        return $this->redirectResponse($this->path('ccdn_user_admin_account_show', array('userId' => $userId)));
    }

    /**
     *
     * @access public
     * @param  int              $userId
     * @return RedirectResponse
     */
    public function banAction($userId)
    {
        $this->isAuthorised('ROLE_ADMIN');
        $user = $this->getUserModel()->findOneUserById($userId);
        $this->isFound($user);

        if ($user->getId() == $this->getUser()->getId()) {
            throw new AccessDeniedException('You cannot administrate yourself.');
        }

        $this->getUserModel()->banUser($user)->flush();

        $this->setFlash('notice', $this->trans('flash.success.user.ban', array('%name%' => $user->getUsername())));

        return $this->redirectResponse($this->path('ccdn_user_admin_account_show', array('userId' => $userId)));
    }

    /**
     *
     * @access public
     * @param  int              $userId
     * @return RedirectResponse
     */
    public function unbanAction($userId)
    {
        $this->isAuthorised('ROLE_ADMIN');
        $user = $this->getUserModel()->findOneUserById($userId);
        $this->isFound($user);

        if ($user->getId() == $this->getUser()->getId()) {
            throw new AccessDeniedException('You cannot administrate yourself.');
        }

        $this->getUserModel()->unbanUser($user)->flush();

        $this->setFlash('notice', $this->trans('flash.success.user.unban', array('%name%' => $user->getUsername())));

        return $this->redirectResponse($this->path('ccdn_user_admin_account_show', array('userId' => $userId)));
    }
}
