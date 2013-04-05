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

use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use CCDNUser\AdminBundle\Controller\UserBaseController;

/**
 *
 * @author Reece Fowell <reece@codeconsortium.com>
 * @version 1.0
 */
class UserController extends UserBaseController
{
    /**
     *
     * @access public
     * @param  int $page
     * @return RedirectResponse|RenderResponse
     */
    public function showNewestUsersAction($page)
    {
        $this->isAuthorised('ROLE_ADMIN');

        $usersPager = $this->getUserManager()->getNewestUsersPaginated($page, new \DateTime('-7 days'));

        $crumbs = $this->getCrumbs()
            ->add($this->trans('ccdn_user_admin.crumbs.show_newest'), $this->path('ccdn_user_admin_show_newest'));

        return $this->renderResponse('CCDNUserAdminBundle:Newest:show_newest_users.html.', array(
            'crumbs' => $crumbs,
            'pager' => $usersPager,
            'users' => $usersPager->getCurrentPageResults(),
        ));
    }

     /**
     *
     * @access public
     * @param  int $userId
     * @return RedirectResponse|RenderResponse
     */
    public function showAction($userId)
    {
        $this->isAuthorised('ROLE_ADMIN');
		
        $user = $this->getUserManager()->findOneById($userId);
		$this->isFound($user);
		
        $crumbs = $this->getCrumbs()
            ->add($this->trans('ccdn_user_admin.crumbs.account.show', array('%user_name%' => $user->getUsername())), $this->path('ccdn_user_admin_account_show', array('userId' => $user->getId())));

        return $this->renderResponse('CCDNUserAdminBundle:User:show_user.html.', array(
            'crumbs' => $crumbs,
            'user' => $user,
        ));
    }

    /**
     *
     * @access public
     */
    public function findUserAction()
    {
        $this->isAuthorised('ROLE_ADMIN');
    }

    /**
     *
     * @access public
     * @param  int $userId
     * @return RedirectResponse|RenderResponse
     */
    public function editAccountAction($userId)
    {
        $this->isAuthorised('ROLE_ADMIN');

        $user = $this->getUserManager()->findOneById($userId);
		$this->isFound($user);
		
        if ($user->getId() == $this->getUser()->getId()) {
            throw new AccessDeniedException('You cannot administrate yourself.');
        }

        $formHandler = $this->container->get('ccdn_user_admin.form.handler.administrate_account')->setDefaults(array('user' => $user));

        if ($formHandler->process()) {
            return $this->redirectResponse($this->path('ccdn_user_admin_account_show', array('userId' => $userId)));
        }

        $crumbs = $this->getCrumbs()
            ->add($this->trans('ccdn_user_admin.crumbs.account.show', array('%user_name%' => $user->getUsername())), $this->path('ccdn_user_admin_account_show', array('userId' => $user->getId())))
			->add($this->trans('ccdn_user_admin.crumbs.account.edit'), $this->path('ccdn_user_admin_account_edit', array('userId' => $user->getId())));

        return $this->renderResponse('CCDNUserAdminBundle:User:edit_user_account.html.',
            array(
                'crumbs' => $crumbs,
                'form' => $formHandler->getForm()->createView(),
                'theme' => $this->container->getParameter('ccdn_user_admin.account.edit_user_account.form_theme'),
                'user' => $user,
            )
        );
    }
	
    /**
     *
     * @access public
     * @param  int $userId
     * @return RedirectResponse|RenderResponse
     */
    public function changeUserRolesAction($userId)
    {
        $this->isAuthorised('ROLE_SUPER_ADMIN');

        $user = $this->getUserManager()->findOneById($userId);
		$this->isFound($user);

        if ($user->getId() == $this->getUser()->getId()) {
            throw new AccessDeniedException('You cannot administrate yourself.');
        }

        $formHandler = $this->container->get('ccdn_user_admin.form.handler.role_change')->setOptions(array('user' => $user));

        if ($formHandler->process()) {
            $this->setFlash('notice', $this->trans('ccdn_user_admin.flash.user.set_roles.success', array('%user_name%' => $user->getUsername())));

            return $this->redirectResponse($this->path('ccdn_user_admin_account_show', array(
                'userId' => $user->getId(),
            )));
        } else {
	
	        $crumbs = $this->getCrumbs()
	            ->add($this->trans('ccdn_user_admin.crumbs.account.show', array('%user_name%' => $user->getUsername())), $this->path('ccdn_user_admin_account_show', array('userId' => $user->getId())))
            	->add($this->trans('ccdn_user_admin.crumbs.account.set_roles', array('%user_name%' => $user->getUsername())), $this->path('ccdn_user_admin_set_roles', array('userId' => $user->getId())));

            return $this->renderResponse('CCDNUserAdminBundle:Role:set_users_role.html.',
				array(
					'crumbs' => $crumbs,
	                'user' => $user,
	                'form' => $formHandler->getForm()->createView(),
	            )
			);
        }
    }
}