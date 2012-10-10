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
class RoleController extends ContainerAware
{

    /**
     *
     * @access public
     * @param  Int $userId
     * @return RedirectResponse|RenderResponse
     */
    public function setUserRolesAction($userId)
    {
        if ( ! $this->container->get('security.context')->isGranted('ROLE_SUPER_ADMIN')) {
            throw new AccessDeniedException('You do not have permission to access this page!');
        }

        $user = $this->container->get('ccdn_user_user.user.repository')->findOneById($userId);

        if ( ! is_object($user) || ! $user instanceof UserInterface) {
            throw new NotFoundHttpException('the user does not exist.');
        }

        if ($user->getId() == $this->container->get('security.context')->getToken()->getUser()->getId()) {
            throw new AccessDeniedException('You cannot administrate yourself.');
        }

        $formHandler = $this->container->get('ccdn_user_admin.role.form.change.handler')->setOptions(array('user' => $user));

        if ($formHandler->process()) {
            $this->container->get('session')->setFlash('notice', $this->container->get('translator')->trans('ccdn_user_admin.flash.user.set_roles.success', array('%username%' => $user->getUsername()), 'CCDNUserAdminBundle'));

            return new RedirectResponse($this->container->get('router')->generate('ccdn_user_admin_account_show', array(
                'userId' => $user->getId(),
            )));
        } else {
	
	        $crumbs = $this->container->get('ccdn_component_crumb.trail')
	            ->add($this->container->get('translator')->trans('ccdn_user_admin.crumbs.dashboard.admin', array(), 'CCDNUserAdminBundle'), $this->container->get('router')->generate('ccdn_component_dashboard_show', array('category' => 'admin')), "sitemap")
	            ->add($this->container->get('translator')->trans('ccdn_user_admin.crumbs.profile.show', array('%username%' => $user->getUsername()), 'CCDNUserAdminBundle'), $this->container->get('router')->generate('ccdn_user_profile_show', array('userId' => $user->getId())), "user")
	            ->add($this->container->get('translator')->trans('ccdn_user_admin.crumbs.account.show', array('%user_name%' => $user->getUsername()), 'CCDNUserAdminBundle'), $this->container->get('router')->generate('ccdn_user_admin_account_show', array('userId' => $user->getId())), "user");

            return $this->container->get('templating')->renderResponse('CCDNUserAdminBundle:Role:set_users_role.html.' . $this->getEngine(), array(
                'user_profile_route' => $this->container->getParameter('ccdn_forum_admin.user.profile_route'),
				'crumbs' => $crumbs,
                'user' => $user,
                'form' => $formHandler->getForm()->createView(),
            ));
        }

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
