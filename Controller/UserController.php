<?php

/*
 * This file is part of the CCDN UserAdminBundle
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
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
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
	 * @param int $page
	 * @return RedirectResponse|RenderResponse
	 */
	public function showNewestUsersAction($page)
	{
		if ( ! $this->container->get('security.context')->isGranted('ROLE_ADMIN'))
		{
			throw new AccessDeniedException('You do not have access to this section.');
		}
				
		$users_paginated = $this->container->get('ccdn_user_user.user.repository')->findAllNewPaginated();

		$users_per_page = $this->container->getParameter('ccdn_user_member.members_per_page');
		$users_paginated->setMaxPerPage($users_per_page);
		$users_paginated->setCurrentPage($page, false, true);
		
		$users = $users_paginated->getCurrentPageResults();
		
		$crumb_trail = $this->container->get('ccdn_component_crumb_trail.crumb_trail')
			->add($this->container->get('translator')->trans('crumbs.dashboard', array(), 'CCDNUserAdminBundle'), $this->container->get('router')->generate('cc_dashboard_index'), "sitemap")
			->add($this->container->get('translator')->trans('crumbs.dashboard.admin', array(), 'CCDNUserAdminBundle'), $this->container->get('router')->generate('cc_dashboard_show', array('category' => 'admin')), "sitemap")
			->add($this->container->get('translator')->trans('crumbs.show_newest', array(), 'CCDNUserAdminBundle'), $this->container->get('router')->generate('cc_admin_user_show_newest'), "users");
		
		return $this->container->get('templating')->renderResponse('CCDNUserAdminBundle:User:show_newest_users.html.' . $this->getEngine(), array(
			'crumbs' => $crumb_trail,
			'user_profile_route' => $this->container->getParameter('ccdn_user_member.user.profile_route'),
//			'pager_route' => 'cc_members_paginated',
			'pager' => $users_paginated,
			'users' => $users,
		));
	}


 	/**
	 *
	 * @access public
	 * @param int $user_id
	 * @return RedirectResponse|RenderResponse
	 */
	public function showAction($user_id)
    {
		if ( ! $this->container->get('security.context')->isGranted('ROLE_ADMIN'))
		{
			throw new AccessDeniedException('You do not have access to this section.');
		}

		$user = $this->container->get('ccdn_user_user.user.repository')->findOneById($user_id);			

		if ( ! is_object($user) || ! $user instanceof UserInterface)
		{
            throw new NotFoundHttpException('the user does not exist.');
        }

		$crumb_trail = $this->container->get('ccdn_component_crumb_trail.crumb_trail')
			->add($this->container->get('translator')->trans('crumbs.dashboard', array(), 'CCDNUserAdminBundle'), $this->container->get('router')->generate('cc_dashboard_index'), "sitemap")
			->add($this->container->get('translator')->trans('crumbs.dashboard.admin', array(), 'CCDNUserAdminBundle'), $this->container->get('router')->generate('cc_dashboard_show', array('category' => 'admin')), "sitemap")
			->add($this->container->get('translator')->trans('crumbs.account', array('%user_name%' => $user->getUsername()), 'CCDNUserAdminBundle'), $this->container->get('router')->generate('cc_admin_user_show', array('user_id' => $user->getId())), "user");

        return $this->container->get('templating')->renderResponse('CCDNUserAdminBundle:User:show_user.html.' . $this->getEngine(), array(
			'crumbs' => $crumb_trail,
			'user' => $user,
		));
    }
	
	
	/**
	 *
	 * @access public
	 * @return RedirectResponse|RenderResponse
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
	 * @param int $user_id
	 * @return RedirectResponse|RenderResponse
	 */
	public function editAccountAction($user_id)
	{
		if ( ! $this->container->get('security.context')->isGranted('ROLE_ADMIN'))
		{
			throw new AccessDeniedException('You do not have access to this section.');
		}

		if ( ! $user_id || $user_id == 0)
		{
            throw new NotFoundHTTPException('The user does not exist.');
		}

		$user = $this->container->get('ccdn_user_user.user.repository')->findOneById($user_id);			

		if ( ! is_object($user) || ! $user instanceof UserInterface)
		{
            throw new NotFoundHTTPException('The user does not exist.');
        }

		if ($user->getId() == $this->container->get('security.context')->getToken()->getUser()->getId())
		{
		    throw new AccessDeniedException('You cannot administrate yourself.');
		}
		
        $formHandler = $this->container->get('ccdn_user_admin.administrate.account.form.handler')->setDefaults(array('user' => $user));

        if ($formHandler->process()) {
         //   $this->setFlash('fos_user_success', 'flash.account.updated');

            return new RedirectResponse($this->container->get('router')->generate('cc_admin_user_show', array('user_id' => $user_id)));
        }

		$crumb_trail = $this->container->get('ccdn_component_crumb_trail.crumb_trail')
			->add($this->container->get('translator')->trans('crumbs.dashboard', array(), 'CCDNUserAdminBundle'), $this->container->get('router')->generate('cc_dashboard_index'), "sitemap")
			->add($this->container->get('translator')->trans('crumbs.dashboard.admin', array(), 'CCDNUserAdminBundle'), $this->container->get('router')->generate('cc_dashboard_show', array('category' => 'admin')), "sitemap")
			->add($this->container->get('translator')->trans('crumbs.account', array('%user_name%' => $user->getUsername()), 'CCDNUserAdminBundle'), $this->container->get('router')->generate('cc_admin_user_show', array('user_id' => $user->getId())), "user")
			->add($this->container->get('translator')->trans('crumbs.account.edit', array(), 'CCDNUserAdminBundle'), $this->container->get('router')->generate('cc_admin_user_account_edit', array('user_id' => $user->getId())), "edit");		

        return $this->container->get('templating')->renderResponse('CCDNUserAdminBundle:User:edit_user_account.html.' . $this->getEngine(),
            array(
				'crumbs' => $crumb_trail,
				'form' => $formHandler->getForm()->createView(),
				'theme' => $this->container->getParameter('fos_user.template.theme'),
				'user' => $user,
			)
        );
    }
	
	
	
	/**
	 *
	 * @access public
	 * @param int $user_id
	 * @return RedirectResponse|RenderResponse
	 */
	public function editProfileAction($user_id)
	{
		if ( ! $this->container->get('security.context')->isGranted('ROLE_ADMIN'))
		{
			throw new AccessDeniedException('You do not have access to this section.');
		}

		if ( ! $user_id || $user_id == 0)
		{
            throw new NotFoundHTTPException('The user does not exist.');
		}

		$user = $this->container->get('ccdn_user_user.user.repository')->findOneById($user_id);			

		if ( ! is_object($user) || ! $user instanceof UserInterface)
		{
            throw new NotFoundHTTPException('The user does not exist.');
        }

		if ($user->getId() == $this->container->get('security.context')->getToken()->getUser()->getId())
		{
		    throw new AccessDeniedException('You cannot administrate yourself.');
		}

		// get the user associated profile
		$profile = $user->getProfile();

		// if the profile has no id then it
		// does not exist, so create one.
		if ( ! $profile->getId())
		{
			$this->container->get('ccdn_user_profile.profile.manager')->insert($profile)->flushNow();
		}
		
        $formHandler = $this->container->get('ccdn_user_admin.administrate.profile.form.handler')->setDefaults(array('profile' => $profile));

        if ($formHandler->process()) {
         //   $this->setFlash('fos_user_success', 'flash.account.updated');

            return new RedirectResponse($this->container->get('router')->generate('cc_admin_user_show', array('user_id' => $user_id)));
        }

		$crumb_trail = $this->container->get('ccdn_component_crumb_trail.crumb_trail')
			->add($this->container->get('translator')->trans('crumbs.dashboard', array(), 'CCDNUserAdminBundle'), $this->container->get('router')->generate('cc_dashboard_index'), "sitemap")
			->add($this->container->get('translator')->trans('crumbs.dashboard.admin', array(), 'CCDNUserAdminBundle'), $this->container->get('router')->generate('cc_dashboard_show', array('category' => 'admin')), "sitemap")
			->add($this->container->get('translator')->trans('crumbs.account', array('%user_name%' => $user->getUsername()), 'CCDNUserAdminBundle'), $this->container->get('router')->generate('cc_admin_user_show', array('user_id' => $user->getId())), "user")
			->add($this->container->get('translator')->trans('crumbs.profile.edit', array(), 'CCDNUserAdminBundle'), $this->container->get('router')->generate('cc_admin_user_profile_edit', array('user_id' => $user->getId())), "edit");		

        return $this->container->get('templating')->renderResponse('CCDNUserAdminBundle:User:edit_user_profile.html.' . $this->getEngine(),
            array(
				'crumbs' => $crumb_trail,
				'form' => $formHandler->getForm()->createView(),
				'theme' => $this->container->getParameter('fos_user.template.theme'),
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
