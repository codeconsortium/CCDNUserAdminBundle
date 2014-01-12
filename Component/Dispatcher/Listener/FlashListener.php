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

namespace CCDNUser\AdminBundle\Component\Dispatcher\Listener;

use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Bundle\FrameworkBundle\Translation\Translator;

use CCDNUser\AdminBundle\Component\Dispatcher\AdminEvents;
use CCDNUser\AdminBundle\Component\Dispatcher\Event\AdminUserEvent;
use CCDNUser\AdminBundle\Component\Dispatcher\Event\AdminUserResponseEvent;

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
class FlashListener implements EventSubscriberInterface
{
    /**
     *
     * @access private
     * @var \Symfony\Component\HttpFoundation\Session\Session $session
     */
    protected $session;

    /**
     *
     * @var \Symfony\Bundle\FrameworkBundle\Translation\Translator $translator
     */
    private $translator;

    /**
     *
     * @access public
     * @param \Symfony\Component\HttpFoundation\Session\Session      $session
     * @param \Symfony\Bundle\FrameworkBundle\Translation\Translator $translator
     */
    public function __construct(Session $session, Translator $translator)
    {
        $this->session = $session;
        $this->translator = $translator;
    }

    /**
     *
     * {@inheritDoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            AdminEvents::ADMIN_USER_UPDATE_ACCOUNT_COMPLETE => 'onUpdateAccountComplete',
            AdminEvents::ADMIN_USER_UPDATE_ROLES_COMPLETE => 'onUpdateRolesComplete',
            AdminEvents::ADMIN_USER_ACTIVATE_RESPONSE => 'onActivateComplete',
            AdminEvents::ADMIN_USER_DEACTIVATE_RESPONSE => 'onDeactivateComplete',
            AdminEvents::ADMIN_USER_BAN_RESPONSE => 'onBanComplete',
            AdminEvents::ADMIN_USER_UNBAN_RESPONSE => 'onUnbanComplete',
        );
    }

    public function onUpdateAccountComplete(AdminUserEvent $event)
    {
        if ($user = $event->getUser()) {
            $this->session->getFlashBag()->add('success', $this->translator->trans('ccdn_user_admin.flash.success.user.update_account', array('%name%' => $user->getUsername())));
        }
    }

    public function onUpdateRolesComplete(AdminUserEvent $event)
    {
        if ($user = $event->getUser()) {
            $this->session->getFlashBag()->add('success', $this->translator->trans('ccdn_user_admin.flash.success.user.update_roles', array('%name%' => $user->getUsername())));
        }
    }

    public function onActivateComplete(AdminUserResponseEvent $event)
    {
        if ($user = $event->getUser()) {
            $this->session->getFlashBag()->add('success', $this->translator->trans('ccdn_user_admin.flash.success.user.activate', array('%name%' => $user->getUsername())));
        }
    }

    public function onDeactivateComplete(AdminUserResponseEvent $event)
    {
        if ($user = $event->getUser()) {
            $this->session->getFlashBag()->add('success', $this->translator->trans('ccdn_user_admin.flash.success.user.force_reactivation', array('%name%' => $user->getUsername())));
        }
    }

    public function onBanComplete(AdminUserResponseEvent $event)
    {
        if ($user = $event->getUser()) {
            $this->session->getFlashBag()->add('success', $this->translator->trans('ccdn_user_admin.flash.success.user.ban', array('%name%' => $user->getUsername())));
        }
    }

    public function onUnbanComplete(AdminUserResponseEvent $event)
    {
        if ($user = $event->getUser()) {
            $this->session->getFlashBag()->add('success', $this->translator->trans('ccdn_user_admin.flash.success.user.unban', array('%name%' => $user->getUsername())));
        }
    }
}
