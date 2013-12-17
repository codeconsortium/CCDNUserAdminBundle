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

use Symfony\Component\Security\Core\User\UserInterface;

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
class AccountBaseController extends BaseController
{
    /**
     *
     * @access protected
     * @return Array
     */
    protected function getRoleHierarchy()
    {
        $roleHierarchy = $this->container->getParameter('security.role_hierarchy.roles');

        $roles = array();

        foreach ($roleHierarchy as $roleName => $roleSubs) {
            $subs = '<ul><li>' . implode('</li><li>', $roleSubs) . '</li></ul>';
            $roles[$roleName] = '<strong>' . $roleName . '</strong>' . ($subs != '<ul><li>' . $roleName . '</li></ul>' ? "\n" . $subs:'');
        }

        return $roles;
    }

    protected function getFormHandlerToUpdateAccount(UserInterface $user)
    {
        $formHandler = $this->container->get('ccdn_user_admin.form.handler.update_account');
        $formHandler
            ->setUser($user)
            ->setRequest($this->getRequest())
        ;

        return $formHandler;
    }

    protected function getFormHandlerToUpdateRolesForUser(UserInterface $user)
    {
        $formHandler = $this->container->get('ccdn_user_admin.form.handler.update_roles');

        $formHandler
            ->setUser($user)
            ->setRequest($this->getRequest())
            ->setRoleHierarchy($this->getRoleHierarchy())
        ;

        return $formHandler;
    }
}
