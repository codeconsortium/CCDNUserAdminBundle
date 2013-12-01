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
class ActivationController extends BaseController
{
    /**
     *
     * @access public
     * @return RedirectResponse|RenderResponse
     */
    public function showUnactivatedUsersAction()
    {
        $this->isAuthorised('ROLE_ADMIN');

		$page = $this->getQuery('page', 1);
        $usersPager = $this->getUserModel()->findAllUnactivatedUsersPaginated($page, 25);

        $crumbs = $this->getCrumbs()
            ->add($this->trans('crumbs.show_unactivated'), $this->path('ccdn_user_admin_show_unactivated'));

        return $this->renderResponse('CCDNUserAdminBundle:User:Activation/show_unactivated_users.html.',
            array(
                'crumbs' => $crumbs,
                'pager' => $usersPager,
            )
        );
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
}
