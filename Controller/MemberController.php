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
class MemberController extends BaseController
{
    /**
     *
     * @access public
     * @return RenderResponse
     */
    public function showAction()
    {
        $this->isAuthorised('ROLE_ADMIN');
        $page = $this->getQuery('page', 1);
        $alpha = $this->getQuery('alpha', null);

        if ($alpha) {
            $membersPager = $this->getUserModel()->findAllUsersFilteredAtoZPaginated($page, $alpha);
        } else {
            $membersPager = $this->getUserModel()->findAllUsersPaginated($page);
        }

        return $this->renderResponse('CCDNUserAdminBundle:Admin:Member/list.html.', array(
            'crumbs' => $this->getCrumbs()->addMemberIndex(),
            'pager' => $membersPager,
            'alpha' => $alpha,
        ));
    }

    /**
     *
     * @access public
     * @return RedirectResponse|RenderResponse
     */
    public function showNewestAction()
    {
        $this->isAuthorised('ROLE_ADMIN');
        $page = $this->getQuery('page', 1);
        $usersPager = $this->getUserModel()->findAllNewestUsersPaginated(new \DateTime('-7 days'), $page, 25);

        return $this->renderResponse('CCDNUserAdminBundle:Admin:Member/list_newest.html.', array(
            'crumbs' => $this->getCrumbs()->addMemberNewestIndex(),
            'pager' => $usersPager,
        ));
    }

    /**
     *
     * @access public
     * @return RedirectResponse|RenderResponse
     */
    public function showUnactivatedAction()
    {
        $this->isAuthorised('ROLE_ADMIN');
        $page = $this->getQuery('page', 1);
        $usersPager = $this->getUserModel()->findAllUnactivatedUsersPaginated($page, 25);

        return $this->renderResponse('CCDNUserAdminBundle:Admin:Member/list_unactivated.html.', array(
            'crumbs' => $this->getCrumbs()->addMemberUnactivatedIndex(),
            'pager' => $usersPager,
        ));
    }

    /**
     *
     * @access public
     * @return RenderResponse
     */
    public function showBannedAction()
    {
        $this->isAuthorised('ROLE_ADMIN');
        $page = $this->getQuery('page', 1);
        $usersPager = $this->getUserModel()->findAllBannedUsersPaginated($page, 25);

        return $this->renderResponse('CCDNUserAdminBundle:Admin:Member/list_banned.html.', array(
            'crumbs' => $this->getCrumbs()->addMemberBannedIndex(),
            'pager' => $usersPager,
        ));
    }
}
