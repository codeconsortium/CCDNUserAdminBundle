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

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

use FOS\UserBundle\Model\UserInterface;

/**
 *
 * @author Reece Fowell <reece@codeconsortium.com>
 * @version 1.0
 */
class BanController extends ContainerAware
{

    /**
     *
     * @access public
     * @param  int $page
     * @return RenderResponse
     */
    public function showBannedUsersAction($page)
    {
        if ( ! $this->container->get('security.context')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException('You do not have access to this section.');
        }

        $usersPager = $this->container->get('ccdn_user_user.repository.user')->findAllBannedPaginated();

        $usersPerPage = $this->container->getParameter('ccdn_user_admin.ban.show_banned_users.users_per_page');
        $usersPager->setMaxPerPage($usersPerPage);
        $usersPager->setCurrentPage($page, false, true);

        $users = $usersPager->getCurrentPageResults();

        $crumbs = $this->container->get('ccdn_component_crumb.trail')
            ->add($this->container->get('translator')->trans('ccdn_user_admin.crumbs.dashboard.admin', array(), 'CCDNUserAdminBundle'), $this->container->get('router')->generate('ccdn_component_dashboard_show', array('category' => 'admin')), "sitemap")
            ->add($this->container->get('translator')->trans('ccdn_user_admin.crumbs.show_banned', array(), 'CCDNUserAdminBundle'), $this->container->get('router')->generate('ccdn_user_admin_show_banned'), "users");

        return $this->container->get('templating')->renderResponse('CCDNUserAdminBundle:Banning:show_banned_users.html.' . $this->getEngine(), array(
            'crumbs' => $crumbs,
            'pager' => $usersPager,
            'users' => $users,
        ));
    }

    /**
     *
     * @access public
     * @param  int $userId
     * @return RedirectResponse
     */
    public function banUserAction($userId)
    {
        if ( ! $this->container->get('security.context')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException('You do not have permission to access this page!');
        }

        $user = $this->container->get('ccdn_user_user.repository.user')->findOneById($userId);

        if ( ! is_object($user) || ! $user instanceof UserInterface) {
            throw new NotFoundHttpException('the user does not exist.');
        }

        if ($user->getId() == $this->container->get('security.context')->getToken()->getUser()->getId()) {
            throw new AccessDeniedException('You cannot administrate yourself.');
        }

        $this->container->get('ccdn_user_user.manager.user')->ban($user)->flush();

        $this->container->get('session')->setFlash('notice', $this->container->get('translator')->trans('ccdn_user_admin.flash.user.ban.success', array('%user_name%' => $user->getUsername()), 'CCDNUserAdminBundle'));

        return new RedirectResponse($this->container->get('router')->generate('ccdn_user_admin_account_show', array('userId' => $userId)));

    }

    /**
     *
     * @access public
     * @param  int $userId
     * @return RedirectResponse
     */
    public function unbanUserAction($userId)
    {
        if ( ! $this->container->get('security.context')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException('You do not have permission to access this page!');
        }

        $user = $this->container->get('ccdn_user_user.repository.user')->findOneById($userId);

        if ( ! is_object($user) || ! $user instanceof UserInterface) {
            throw new NotFoundHttpException('the user does not exist.');
        }

        if ($user->getId() == $this->container->get('security.context')->getToken()->getUser()->getId()) {
            throw new AccessDeniedException('You cannot administrate yourself.');
        }

        $this->container->get('ccdn_user_user.manager.user')->unban($user)->flush();

        $this->container->get('session')->setFlash('notice', $this->container->get('translator')->trans('ccdn_user_admin.flash.user.unban.success', array('%user_name%' => $user->getUsername()), 'CCDNUserAdminBundle'));

        return new RedirectResponse($this->container->get('router')->generate('ccdn_user_admin_account_show', array('userId' => $userId)));

    }

    /**
     *
     * @access public
     */
    public function banIPAction()
    {
        if ( ! $this->container->get('security.context')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException('You do not have permission to access this page!');
        }

    }

    /**
     *
     * @access public
     */
    public function banEMailAddressAction()
    {
        if ( ! $this->container->get('security.context')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException('You do not have permission to access this page!');
        }

    }

    /**
     *
     * @access protected
     * @return string
     */
    protected function getEngine()
    {
        return $this->container->getParameter('ccdn_user_admin.template.engine');
    }

}
