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
class ActivationController extends ContainerAware
{

    /**
     *
     * @access public
     * @param  Int $page
     * @return RedirectResponse|RenderResponse
     */
    public function showUnactivatedUsersAction($page)
    {
        if ( ! $this->container->get('security.context')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException('You do not have access to this section.');
        }

        $usersPager = $this->container->get('ccdn_user_user.repository.user')->findAllUnactivatedPaginated();

        $usersPerPage = $this->container->getParameter('ccdn_user_admin.activation.show_unactivated_users.users_per_page');
        $usersPager->setMaxPerPage($usersPerPage);
        $usersPager->setCurrentPage($page, false, true);

        $users = $usersPager->getCurrentPageResults();

        $crumbs = $this->container->get('ccdn_component_crumb.trail')
            ->add($this->container->get('translator')->trans('ccdn_user_admin.crumbs.dashboard.admin', array(), 'CCDNUserAdminBundle'), $this->container->get('router')->generate('ccdn_component_dashboard_show', array('category' => 'admin')), "sitemap")
            ->add($this->container->get('translator')->trans('ccdn_user_admin.crumbs.show_unactivated', array(), 'CCDNUserAdminBundle'), $this->container->get('router')->generate('ccdn_user_admin_show_unactivated'), "users");

        return $this->container->get('templating')->renderResponse('CCDNUserAdminBundle:Activation:show_unactivated_users.html.' . $this->getEngine(), array(
            'crumbs' => $crumbs,
            'user_profile_route' => $this->container->getParameter('ccdn_user_admin.user.profile_route'),
            'pager' => $usersPager,
            'users' => $users,
        ));
    }

    /**
     *
     * @access public
     * @param  Int $userId
     * @return RedirectResponse
     */
    public function activateAction($userId)
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

        $this->container->get('ccdn_user_user.manager.user')->activate($user)->flush();

        $this->container->get('session')->setFlash('notice', $this->container->get('translator')->trans('ccdn_user_admin.flash.user.activate.success', array('%user_name%' => $user->getUsername()), 'CCDNUserAdminBundle'));

        return new RedirectResponse($this->container->get('router')->generate('ccdn_user_admin_account_show', array('userId' => $userId)));

    }

    /**
     *
     * @access public
     * @param  Int $userId
     * @return RedirectResponse
     */
    public function forceReActivationAction($userId)
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

        $this->container->get('ccdn_user_user.manager.user')->forceReActivate($user)->flush();

        $this->container->get('session')->setFlash('notice', $this->container->get('translator')->trans('ccdn_user_admin.flash.user.force_reactivation.success', array('%user_name%' => $user->getUsername()), 'CCDNUserAdminBundle'));

        return new RedirectResponse($this->container->get('router')->generate('ccdn_user_admin_account_show', array('userId' => $userId)));

    }

    /**
     *
     * @access protected
     * @return String
     */
    protected function getEngine()
    {
        return $this->container->getParameter('ccdn_user_admin.template.engine');
    }

}
