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

namespace CCDNUser\AdminBundle\Component\Dispatcher;

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
final class AdminEvents
{
    /**
     *
     * The ADMIN_USER_UPDATE_ACCOUNT_INITIALISE event occurs when the User account updating process is initalised.
     *
     * This event allows you to modify the default values of the User entity object before binding the form.
     * The event listener method receives a CCDNUser\AdminBundle\Component\Dispatcher\Event\AdminUserEvent instance.
     */
    const ADMIN_USER_UPDATE_ACCOUNT_INITIALISE = 'ccdn_user_admin.user.update_account.initialise';

    /**
     *
     * The ADMIN_USER_UPDATE_ACCOUNT_SUCCESS event occurs when the User account updating process is successful before persisting.
     *
     * This event allows you to modify the values of the User entity object after form submission before persisting.
     * The event listener method receives a CCDNUser\AdminBundle\Component\Dispatcher\Event\AdminUserEvent instance.
     */
    const ADMIN_USER_UPDATE_ACCOUNT_SUCCESS = 'ccdn_user_admin.user.update_account.success';

    /**
     *
     * The ADMIN_USER_UPDATE_ACCOUNT_COMPLETE event occurs when the User account updating process is completed successfully after persisting.
     *
     * This event allows you to modify the values of the User entity after persisting.
     * The event listener method receives a CCDNUser\AdminBundle\Component\Dispatcher\Event\AdminUserEvent instance.
     */
    const ADMIN_USER_UPDATE_ACCOUNT_COMPLETE = 'ccdn_user_admin.user.update_account.complete';

    /**
     *
     * The ADMIN_USER_UPDATE_ACCOUNT_RESPONSE event occurs when the User account updating process finishes and returns a HTTP response.
     *
     * This event allows you to modify the default values of the response object returned from the controller action.
     * The event listener method receives a CCDNUser\AdminBundle\Component\Dispatcher\Event\AdminUserResponseEvent instance.
     */
    const ADMIN_USER_UPDATE_ACCOUNT_RESPONSE = 'ccdn_user_admin.user.update_account.response';

    /**
     *
     * The ADMIN_USER_UPDATE_ROLES_INITIALISE event occurs when the User role updating process is initalised.
     *
     * This event allows you to modify the default values of the User entity object before binding the form.
     * The event listener method receives a CCDNUser\AdminBundle\Component\Dispatcher\Event\AdminUserEvent instance.
     */
    const ADMIN_USER_UPDATE_ROLES_INITIALISE = 'ccdn_user_admin.user.update_roles.initialise';

    /**
     *
     * The ADMIN_USER_UPDATE_ROLES_SUCCESS event occurs when the User role updating process is successful before persisting.
     *
     * This event allows you to modify the values of the User entity object after form submission before persisting.
     * The event listener method receives a CCDNUser\AdminBundle\Component\Dispatcher\Event\AdminUserEvent instance.
     */
    const ADMIN_USER_UPDATE_ROLES_SUCCESS = 'ccdn_user_admin.user.update_roles.success';

    /**
     *
     * The ADMIN_USER_UPDATE_ROLES_COMPLETE event occurs when the User role updating process is completed successfully after persisting.
     *
     * This event allows you to modify the values of the User entity after persisting.
     * The event listener method receives a CCDNUser\AdminBundle\Component\Dispatcher\Event\AdminUserEvent instance.
     */
    const ADMIN_USER_UPDATE_ROLES_COMPLETE = 'ccdn_user_admin.user.update_roles.complete';

    /**
     *
     * The ADMIN_USER_UPDATE_ROLES_RESPONSE event occurs when the User role updating process finishes and returns a HTTP response.
     *
     * This event allows you to modify the default values of the response object returned from the controller action.
     * The event listener method receives a CCDNUser\AdminBundle\Component\Dispatcher\Event\AdminUserResponseEvent instance.
     */
    const ADMIN_USER_UPDATE_ROLES_RESPONSE = 'ccdn_user_admin.user.update_roles.response';

    /**
     *
     * The ADMIN_USER_ACTIVATE_RESPONSE event occurs when the User activation process finishes and returns a HTTP response.
     *
     * This event allows you to modify the default values of the response object returned from the controller action.
     * The event listener method receives a CCDNUser\AdminBundle\Component\Dispatcher\Event\AdminUserResponseEvent instance.
     */
    const ADMIN_USER_ACTIVATE_RESPONSE = 'ccdn_user_admin.user.activate.response';

    /**
     *
     * The ADMIN_USER_DEACTIVATE_RESPONSE event occurs when the User deactivation process finishes and returns a HTTP response.
     *
     * This event allows you to modify the default values of the response object returned from the controller action.
     * The event listener method receives a CCDNUser\AdminBundle\Component\Dispatcher\Event\AdminUserResponseEvent instance.
     */
    const ADMIN_USER_DEACTIVATE_RESPONSE = 'ccdn_user_admin.user.deactivate.response';

    /**
     *
     * The ADMIN_USER_BAN_RESPONSE event occurs when the User banning process finishes and returns a HTTP response.
     *
     * This event allows you to modify the default values of the response object returned from the controller action.
     * The event listener method receives a CCDNUser\AdminBundle\Component\Dispatcher\Event\AdminUserResponseEvent instance.
     */
    const ADMIN_USER_BAN_RESPONSE = 'ccdn_user_admin.user.ban.response';

    /**
     *
     * The ADMIN_USER_UNBAN_RESPONSE event occurs when the User unbanning process finishes and returns a HTTP response.
     *
     * This event allows you to modify the default values of the response object returned from the controller action.
     * The event listener method receives a CCDNUser\AdminBundle\Component\Dispatcher\Event\AdminUserResponseEvent instance.
     */
    const ADMIN_USER_UNBAN_RESPONSE = 'ccdn_user_admin.user.unban.response';
}
