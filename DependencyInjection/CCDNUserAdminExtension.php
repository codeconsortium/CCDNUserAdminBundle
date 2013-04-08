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
     *
     * @access private
	 * @param array $config
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

		// Class file namespaces.
        $this->getEntitySection($config, $container);
        $this->getGatewaySection($config, $container);
        $this->getManagerSection($config, $container);
		$this->getFormSection($config, $container);
		$this->getComponentSection($config, $container);
		
		// Configuration stuff.
        $container->setParameter('ccdn_user_admin.template.engine', $config['template']['engine']);
    	$container->setParameter('ccdn_user_admin.users_per_page', $config['users_per_page']);
        $this->getSEOSection($config, $container);
        $this->getUserSection($config, $container);
        $this->getBanSection($config, $container);
        $this->getActivationSection($config, $container);
        $this->getRoleSection($config, $container);
        $this->getSidebarSection($config, $container);
		
		// Load Service definitions.
        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
    }

    /**
     *
     * @access private
	 * @param array $config
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     */
    private function getEntitySection(array $config, ContainerBuilder $container)
    {
		if (! array_key_exists('class', $config['entity']['user'])) {
			throw new \Exception('You must set the class of the User entity in "app/config/config.yml" or some imported configuration file.');
		}

        $container->setParameter('ccdn_user_admin.entity.user.class', $config['entity']['user']['class']);				
	}
	
    /**
     *
     * @access private
	 * @param array $config
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     */
    private function getGatewaySection(array $config, ContainerBuilder $container)
    {
        $container->setParameter('ccdn_user_admin.gateway.user.class', $config['gateway']['user']['class']);
	}
	
    /**
     *
     * @access private
	 * @param array $config
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     */
    private function getManagerSection(array $config, ContainerBuilder $container)
    {
        $container->setParameter('ccdn_user_admin.manager.user.class', $config['manager']['user']['class']);		
	}
	
    /**
     *
     * @access private
	 * @param array $config
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     */
    private function getFormSection(array $config, ContainerBuilder $container)
    {
        $container->setParameter('ccdn_user_admin.form.type.update_account.class', $config['form']['type']['update_account']['class']);
        $container->setParameter('ccdn_user_admin.form.type.update_roles.class', $config['form']['type']['update_roles']['class']);
        $container->setParameter('ccdn_user_admin.form.handler.update_account.class', $config['form']['handler']['update_account']['class']);
        $container->setParameter('ccdn_user_admin.form.handler.update_roles.class', $config['form']['handler']['update_roles']['class']);
	}
	
    /**
     *
     * @access private
     * @param array $config
	 * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     */
    private function getComponentSection(array $config, ContainerBuilder $container)
    {
        $container->setParameter('ccdn_user_admin.component.dashboard.integrator.class', $config['component']['dashboard']['integrator']['class']);		
	}
	
    /**
     *
     * @access private
	 * @param array $config
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     */
    protected function getSEOSection(array $config, ContainerBuilder $container)
    {
        $container->setParameter('ccdn_user_admin.seo.title_length', $config['seo']['title_length']);
    }

    /**
     *
     * @access private
	 * @param array $config
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     */
    private function getActivationSection(array $config, ContainerBuilder $container)
    {
        $container->setParameter('ccdn_user_admin.activation.show_unactivated_users.layout_template', $config['activation']['show_unactivated_users']['layout_template']);
        $container->setParameter('ccdn_user_admin.activation.show_unactivated_users.member_since_datetime_format', $config['activation']['show_unactivated_users']['member_since_datetime_format']);
    }

    /**
     *
     * @access private
	 * @param array $config
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     */
    private function getBanSection(array $config, ContainerBuilder $container)
    {
        $container->setParameter('ccdn_user_admin.ban.show_banned_users.layout_template', $config['ban']['show_banned_users']['layout_template']);
        $container->setParameter('ccdn_user_admin.ban.show_banned_users.member_since_datetime_format', $config['ban']['show_banned_users']['member_since_datetime_format']);
    }

    /**
     *
     * @access private
	 * @param array $config
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     */
    private function getRoleSection(array $config, ContainerBuilder $container)
    {
        $container->setParameter('ccdn_user_admin.role.set_users_role.layout_template', $config['role']['set_users_role']['layout_template']);
        $container->setParameter('ccdn_user_admin.role.set_users_role.form_theme', $config['role']['set_users_role']['form_theme']);
    }

    /**
     *
     * @access private
	 * @param array $config
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     */
    private function getUserSection(array $config, ContainerBuilder $container)
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
	 * @param array $config
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     */
    private function getSidebarSection(array $config, ContainerBuilder $container)
    {
        $container->setParameter('ccdn_user_admin.sidebar.links', $config['sidebar']['links']);
    }
}