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

namespace CCDNUser\AdminBundle\Model\FrontModel;

use Symfony\Component\EventDispatcher\ContainerAwareEventDispatcher;
use CCDNUser\AdminBundle\Model\Component\Manager\ManagerInterface;
use CCDNUser\AdminBundle\Model\Component\Repository\RepositoryInterface;

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
 * @abstract
 */
abstract class BaseModel
{
    /**
     *
     * @access protected
     * @var \CCDNUser\AdminBundle\Model\Component\Repository\RepositoryInterface
     */
    protected $repository;

    /**
     *
     * @access protected
     * @var \CCDNUser\AdminBundle\Model\Component\Manager\ManagerInterface
     */
    protected $manager;

    /**
     *
     * @access protected
     * @var \Symfony\Component\EventDispatcher\ContainerAwareEventDispatcher $dispatcher
     */
    protected $dispatcher;

    /**
     *
     * @access public
     * @param  \Symfony\Component\EventDispatcher\ContainerAwareEventDispatcher     $dispatcher
     * @param  \CCDNUser\AdminBundle\Model\Component\Repository\RepositoryInterface $repository
     * @param  \CCDNUser\AdminBundle\Model\Component\Manager\ManagerInterface       $manager
     */
    public function __construct(ContainerAwareEventDispatcher $dispatcher, RepositoryInterface $repository, ManagerInterface $manager)
    {
		$this->dispatcher = $dispatcher;
		
        $repository->setModel($this);
        $this->repository = $repository;

        $manager->setModel($this);
        $this->manager = $manager;
    }

    /**
     *
     * @access public
     * @return \CCDNUser\AdminBundle\Model\Component\Repository\RepositoryInterface
     */
    public function getRepository()
    {
        return $this->repository;
    }

    /**
     *
     * @access public
     * @return \CCDNUser\AdminBundle\Model\Component\Manager\ManagerInterface
     */
    public function getManager()
    {
        return $this->manager;
    }
}
