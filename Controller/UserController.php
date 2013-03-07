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
class UserController extends ContainerAware
{

    /**
     *
     * @access public
     * @param  int $page
     * @return RedirectResponse|RenderResponse
     */
    public function showNewestUsersAction($page)
    {
        if ( ! $this->container->get('security.context')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException('You do not have access to this section.');
        }

        $usersPager = $this->container->get('ccdn_user_user.repository.user')->findAllNewPaginated();

        $usersPerPage = $this->container->getParameter('ccdn_user_admin.account.show_newest_users.users_per_page');
        $usersPager->setMaxPerPage($usersPerPage);
        $usersPager->setCurrentPage($page, false, true);

        $users = $usersPager->getCurrentPageResults();

        $crumbs = $this->container->get('ccdn_component_crumb.trail')
            ->add($this->container->get('translator')->trans('ccdn_user_admin.crumbs.dashboard.admin', array(), 'CCDNUserAdminBundle'), $this->container->get('router')->generate('ccdn_component_dashboard_show', array('category' => 'admin')), "sitemap")
            ->add($this->container->get('translator')->trans('ccdn_user_admin.crumbs.show_newest', array(), 'CCDNUserAdminBundle'), $this->container->get('router')->generate('ccdn_user_admin_show_newest'), "users");

        return $this->container->get('templating')->renderResponse('CCDNUserAdminBundle:Newest:show_newest_users.html.' . $this->getEngine(), array(
            'crumbs' => $crumbs,
            'pager' => $usersPager,
            'users' => $users,
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
        if ( ! $this->container->get('security.context')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException('You do not have access to this section.');
        }

        $user = $this->container->get('ccdn_user_user.repository.user')->findOneById($userId);

        if ( ! is_object($user) || ! $user instanceof UserInterface) {
            throw new NotFoundHttpException('the user does not exist.');
        }

        $crumbs = $this->container->get('ccdn_component_crumb.trail')
            ->add($this->container->get('translator')->trans('ccdn_user_admin.crumbs.dashboard.admin', array(), 'CCDNUserAdminBundle'), $this->container->get('router')->generate('ccdn_component_dashboard_show', array('category' => 'admin')), "sitemap")
            ->add($this->container->get('translator')->trans('ccdn_user_admin.crumbs.profile.show', array('%user_name%' => $user->getUsername()), 'CCDNUserAdminBundle'), $this->container->get('router')->generate('ccdn_user_profile_show', array('userId' => $user->getId())), "user")
            ->add($this->container->get('translator')->trans('ccdn_user_admin.crumbs.account.show', array('%user_name%' => $user->getUsername()), 'CCDNUserAdminBundle'), $this->container->get('router')->generate('ccdn_user_admin_account_show', array('userId' => $user->getId())), "user");

        return $this->container->get('templating')->renderResponse('CCDNUserAdminBundle:User:show_user.html.' . $this->getEngine(), array(
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
        if ( ! $this->container->get('security.context')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException('You do not have permission to access this page!');
        }
    }

    /**
     *
     * @access public
     * @param  int $userId
     * @return RedirectResponse|RenderResponse
     */
    public function editAccountAction($userId)
    {
        if ( ! $this->container->get('security.context')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException('You do not have access to this section.');
        }

        if (! $userId || $userId == 0) {
            throw new NotFoundHTTPException('The user does not exist.');
        }

        $user = $this->container->get('ccdn_user_user.repository.user')->findOneById($userId);

        if ( ! is_object($user) || ! $user instanceof UserInterface) {
            throw new NotFoundHTTPException('The user does not exist.');
        }

        if ($user->getId() == $this->container->get('security.context')->getToken()->getUser()->getId()) {
            throw new AccessDeniedException('You cannot administrate yourself.');
        }

        $formHandler = $this->container->get('ccdn_user_admin.form.handler.administrate_account')->setDefaults(array('user' => $user));

        if ($formHandler->process()) {
            return new RedirectResponse($this->container->get('router')->generate('ccdn_user_admin_account_show', array('userId' => $userId)));
        }

        $crumbs = $this->container->get('ccdn_component_crumb.trail')
            ->add($this->container->get('translator')->trans('ccdn_user_admin.crumbs.dashboard.admin', array(), 'CCDNUserAdminBundle'), $this->container->get('router')->generate('ccdn_component_dashboard_show', array('category' => 'admin')), "sitemap")
            ->add($this->container->get('translator')->trans('ccdn_user_admin.crumbs.profile.show', array('%user_name%' => $user->getUsername()), 'CCDNUserAdminBundle'), $this->container->get('router')->generate('ccdn_user_profile_show', array('userId' => $user->getId())), "user")
            ->add($this->container->get('translator')->trans('ccdn_user_admin.crumbs.account.show', array('%user_name%' => $user->getUsername()), 'CCDNUserAdminBundle'), $this->container->get('router')->generate('ccdn_user_admin_account_show', array('userId' => $user->getId())), "user")
            ->add($this->container->get('translator')->trans('ccdn_user_admin.crumbs.account.edit', array(), 'CCDNUserAdminBundle'), $this->container->get('router')->generate('ccdn_user_admin_account_edit', array('userId' => $user->getId())), "edit");

        return $this->container->get('templating')->renderResponse('CCDNUserAdminBundle:User:edit_user_account.html.' . $this->getEngine(),
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
    public function editProfileAction($userId)
    {
        if ( ! $this->container->get('security.context')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException('You do not have access to this section.');
        }

        if (! $userId || $userId == 0) {
            throw new NotFoundHTTPException('The user does not exist.');
        }

        $user = $this->container->get('ccdn_user_user.repository.user')->findOneById($userId);

        if ( ! is_object($user) || ! $user instanceof UserInterface) {
            throw new NotFoundHTTPException('The user does not exist.');
        }

        if ($user->getId() == $this->container->get('security.context')->getToken()->getUser()->getId()) {
            throw new AccessDeniedException('You cannot administrate yourself.');
        }

        // get the user associated profile
        $profile = $user->getProfile();

        // if the profile has no id then it
        // does not exist, so create one.
        if ( ! $profile->getId()) {
            $this->container->get('ccdn_user_profile.manager.profile')->insert($profile)->flush();
        }

        $formHandler = $this->container->get('ccdn_user_admin.form.handler.administrate_profile')->setDefaults(array('profile' => $profile));

        if ($formHandler->process()) {
            return new RedirectResponse($this->container->get('router')->generate('ccdn_user_admin_account_show', array('userId' => $userId)));
        }

        $crumbs = $this->container->get('ccdn_component_crumb.trail')
            ->add($this->container->get('translator')->trans('ccdn_user_admin.crumbs.dashboard.admin', array(), 'CCDNUserAdminBundle'), $this->container->get('router')->generate('ccdn_component_dashboard_show', array('category' => 'admin')), "sitemap")
            ->add($this->container->get('translator')->trans('ccdn_user_admin.crumbs.profile.show', array('%user_name%' => $user->getUsername()), 'CCDNUserAdminBundle'), $this->container->get('router')->generate('ccdn_user_profile_show', array('userId' => $user->getId())), "user")
            ->add($this->container->get('translator')->trans('ccdn_user_admin.crumbs.profile.edit', array(), 'CCDNUserAdminBundle'), $this->container->get('router')->generate('ccdn_user_admin_profile_edit', array('userId' => $user->getId())), "edit");

        return $this->container->get('templating')->renderResponse('CCDNUserAdminBundle:User:edit_user_profile.html.' . $this->getEngine(),
            array(
                'crumbs' => $crumbs,
                'form' => $formHandler->getForm()->createView(),
                'theme' => $this->container->getParameter('ccdn_user_admin.account.edit_user_profile.form_theme'),
                'user' => $user,
            )
        );
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
