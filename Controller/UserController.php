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
 * @category CCDNUser
 * @package  AdminBundle
 *
 * @author   Reece Fowell <reece@codeconsortium.com>
 * @license  http://opensource.org/licenses/MIT MIT
 * @version  Release: 2.0
 * @link     https://github.com/codeconsortium/CCDNUserAdminBundle
 *
 */
class UserController extends UserBaseController
{
    /**
     *
     * @access public
     * @return RedirectResponse|RenderResponse
     */
    public function showNewestUsersAction()
    {
        $this->isAuthorised('ROLE_ADMIN');

		$page = $this->getQuery('page', 1);
        $usersPager = $this->getUserModel()->findAllNewestUsersPaginated($page, 25, new \DateTime('-7 days'));

        return $this->renderResponse('CCDNUserAdminBundle:User:Newest/show_newest_users.html.', array(
            'crumbs' => $this->getCrumbs()->add($this->trans('crumbs.show_newest'), $this->path('ccdn_user_admin_show_newest')),
            'pager' => $usersPager,
        ));
    }

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
            'crumbs' => $this->getCrumbs()->add($this->trans('crumbs.account.show', array('%name%' => $user->getUsername())), $this->path('ccdn_user_admin_account_show', array('userId' => $user->getId()))),
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
     * @param  int                             $userId
     * @return RedirectResponse|RenderResponse
     */
    public function editAccountAction($userId)
    {
        $this->isAuthorised('ROLE_ADMIN');

        $user = $this->getUserModel()->findOneUserById($userId);
        $this->isFound($user);

        if ($user->getId() == $this->getUser()->getId()) {
            throw new AccessDeniedException('You cannot administrate yourself.');
        }

        $formHandler = $this->getFormHandlerToUpdateAccount($user);

        if ($formHandler->process($this->getRequest())) {
            return $this->redirectResponse($this->path('ccdn_user_admin_account_show', array('userId' => $userId)));
        }

        $crumbs = $this->getCrumbs()
            ->add($this->trans('crumbs.account.show', array('%name%' => $user->getUsername())), $this->path('ccdn_user_admin_account_show', array('userId' => $user->getId())))
            ->add($this->trans('crumbs.account.edit'), $this->path('ccdn_user_admin_account_edit', array('userId' => $user->getId())));

        return $this->renderResponse('CCDNUserAdminBundle:User:User/update_account.html.',
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
     * @param  int                             $userId
     * @return RedirectResponse|RenderResponse
     */
    public function changeUserRolesAction($userId)
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

            return $this->redirectResponse($this->path('ccdn_user_admin_account_show', array('userId' => $user->getId())));
        } else {

            $crumbs = $this->getCrumbs()
                ->add($this->trans('crumbs.account.show', array('%name%' => $user->getUsername())), $this->path('ccdn_user_admin_account_show', array('userId' => $user->getId())))
                ->add($this->trans('crumbs.account.set_roles', array('%name%' => $user->getUsername())), $this->path('ccdn_user_admin_set_roles', array('userId' => $user->getId())));

            return $this->renderResponse('CCDNUserAdminBundle:User:User/update_roles.html.',
                array(
                    'crumbs' => $crumbs,
                    'form' => $formHandler->getForm()->createView(),
                    'theme' => $this->container->getParameter('ccdn_user_admin.account.edit_user_account.form_theme'),
                    'user' => $user,
                )
            );
        }
    }
}
