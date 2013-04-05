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

namespace CCDNUser\AdminBundle\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\Config\FileLocator;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 *
 * @author Reece Fowell <reece@codeconsortium.com>
 * @version 1.0
 */
class CCDNUserAdminExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function getAlias()
    {
        return 'ccdn_user_admin';
    }

    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        $container->setParameter('ccdn_user_admin.template.engine', $config['template']['engine']);

    	$container->setParameter('ccdn_user_admin.users_per_page', $config['users_per_page']);
	
        $this->getSEOSection($container, $config);
        $this->getUserSection($container, $config);
        $this->getBanSection($container, $config);
        $this->getActivationSection($container, $config);
        $this->getRoleSection($container, $config);
        $this->getSidebarSection($container, $config);
    }

    /**
     *
     * @access protected
     * @param $container, $config
     */
    protected function getSEOSection($container, $config)
    {
        $container->setParameter('ccdn_user_admin.seo.title_length', $config['seo']['title_length']);
    }

    /**
     *
     * @access private
     * @param $container, $config
     */
    private function getActivationSection($container, $config)
    {
        $container->setParameter('ccdn_user_admin.activation.show_unactivated_users.layout_template', $config['activation']['show_unactivated_users']['layout_template']);
        $container->setParameter('ccdn_user_admin.activation.show_unactivated_users.member_since_datetime_format', $config['activation']['show_unactivated_users']['member_since_datetime_format']);
    }

    /**
     *
     * @access private
     * @param $container, $config
     */
    private function getBanSection($container, $config)
    {
        $container->setParameter('ccdn_user_admin.ban.show_banned_users.layout_template', $config['ban']['show_banned_users']['layout_template']);
        $container->setParameter('ccdn_user_admin.ban.show_banned_users.member_since_datetime_format', $config['ban']['show_banned_users']['member_since_datetime_format']);
    }

    /**
     *
     * @access private
     * @param $container, $config
     */
    private function getRoleSection($container, $config)
    {
        $container->setParameter('ccdn_user_admin.role.set_users_role.layout_template', $config['role']['set_users_role']['layout_template']);
        $container->setParameter('ccdn_user_admin.role.set_users_role.form_theme', $config['role']['set_users_role']['form_theme']);
    }

    /**
     *
     * @access private
     * @param $container, $config
     */
    private function getUserSection($container, $config)
    {
        $container->setParameter('ccdn_user_admin.account.show_newest_users.layout_template', $config['account']['show_newest_users']['layout_template']);
        $container->setParameter('ccdn_user_admin.account.show_newest_users.member_since_datetime_format', $config['account']['show_newest_users']['member_since_datetime_format']);

        $container->setParameter('ccdn_user_admin.account.show_user.layout_template', $config['account']['show_user']['layout_template']);
        $container->setParameter('ccdn_user_admin.account.show_user.member_since_datetime_format', $config['account']['show_user']['member_since_datetime_format']);

        $container->setParameter('ccdn_user_admin.account.edit_user_account.layout_template', $config['account']['edit_user_account']['layout_template']);
        $container->setParameter('ccdn_user_admin.account.edit_user_account.form_theme', $config['account']['edit_user_account']['form_theme']);

        $container->setParameter('ccdn_user_admin.account.edit_user_profile.layout_template', $config['account']['edit_user_profile']['layout_template']);
        $container->setParameter('ccdn_user_admin.account.edit_user_profile.form_theme', $config['account']['edit_user_profile']['form_theme']);
    }

    /**
     *
     * @access private
     * @param $container, $config
     */
    private function getSidebarSection($container, $config)
    {
        $container->setParameter('ccdn_user_admin.sidebar.links', $config['sidebar']['links']);
    }
}