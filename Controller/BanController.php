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
class BanController extends BaseController
{
    /**
     *
     * @access public
     * @return RenderResponse
     */
    public function showBannedUsersAction()
    {
        $this->isAuthorised('ROLE_ADMIN');

		$page = $this->getQuery('page', 1);
        $usersPager = $this->getUserManager()->getBannedUsersPaginated($page);

        $crumbs = $this->getCrumbs()
            ->add($this->trans('crumbs.show_banned'), $this->path('ccdn_user_admin_show_banned'));

        return $this->renderResponse('CCDNUserAdminBundle:Banning:show_banned_users.html.',
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
    public function banUserAction($userId)
    {
        $this->isAuthorised('ROLE_ADMIN');

        $user = $this->getUserManager()->findOneById($userId);
        $this->isFound($user);

        if ($user->getId() == $this->getUser()->getId()) {
            throw new AccessDeniedException('You cannot administrate yourself.');
        }

        $this->getUserManager()->banUser($user)->flush();

        $this->setFlash('notice', $this->trans('flash.success.user.ban', array('%name%' => $user->getUsername())));

        return $this->redirectResponse($this->path('ccdn_user_admin_account_show', array('userId' => $userId)));
    }

    /**
     *
     * @access public
     * @param  int              $userId
     * @return RedirectResponse
     */
    public function unbanUserAction($userId)
    {
        $this->isAuthorised('ROLE_ADMIN');

        $user = $this->getUserManager()->findOneById($userId);
        $this->isFound($user);

        if ($user->getId() == $this->getUser()->getId()) {
            throw new AccessDeniedException('You cannot administrate yourself.');
        }

        $this->getUserManager()->unbanUser($user)->flush();

        $this->setFlash('notice', $this->trans('flash.success.user.unban', array('%name%' => $user->getUsername())));

        return $this->redirectResponse($this->path('ccdn_user_admin_account_show', array('userId' => $userId)));
    }
}
