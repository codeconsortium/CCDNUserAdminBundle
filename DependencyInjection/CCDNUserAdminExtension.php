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

namespace CCDNUser\AdminBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

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
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

		$container->setParameter('ccdn_user_admin.user.profile_route', $config['user']['profile_route']);
		$container->setParameter('ccdn_user_admin.template.engine', $config['template']['engine']);
		$container->setParameter('ccdn_user_admin.template.theme', $config['template']['theme']);
		
		$this->getActivationSection($container, $config);
		$this->getBanSection($container, $config);
		$this->getRoleSection($container, $config);
		$this->getAccountSection($container, $config);
    }
	
	
	
	/**
	 *
	 * @access private
	 * @param $container, $config
	 */
	private function getActivationSection($container, $config)
	{
		$container->setParameter('ccdn_user_admin.activation.layout_templates.show_unactivated_users', $config['activation']['layout_templates']['show_unactivated_users']);
	}
	
	
	
	/**
	 *
	 * @access private
	 * @param $container, $config
	 */
	private function getBanSection($container, $config)
	{
		$container->setParameter('ccdn_user_admin.ban.layout_templates.show_banned_users', $config['ban']['layout_templates']['show_banned_users']);
	}

	
	
	/**
	 *
	 * @access private
	 * @param $container, $config
	 */
	private function getRoleSection($container, $config)
	{
		$container->setParameter('ccdn_user_admin.role.layout_templates.set_users_role', $config['role']['layout_templates']['set_users_role']);
	}

		
	
	/**
	 *
	 * @access private
	 * @param $container, $config
	 */
	private function getAccountSection($container, $config)
	{
		$container->setParameter('ccdn_user_admin.account.layout_templates.edit_user', $config['account']['layout_templates']['edit_user']);
		$container->setParameter('ccdn_user_admin.account.layout_templates.show_newest_users', $config['account']['layout_templates']['show_newest_users']);
		$container->setParameter('ccdn_user_admin.account.layout_templates.show_user', $config['account']['layout_templates']['show_user']);
	}
	
}
