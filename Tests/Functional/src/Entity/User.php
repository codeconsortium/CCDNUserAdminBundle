<?php

namespace CCDNUser\AdminBundle\Tests\Functional\src\Entity;

use FOS\UserBundle\Model\User as BaseUser;

class User extends BaseUser
{
    /**
     *
     * @access protected
     * @var \DateTime $registeredDate
     */
    protected $registeredDate;

    public function __construct()
    {
        parent::__construct();
		
        // your own logic
    }

    /**
     * Add registration date before being persisted.
     *
     */
    public function prePersistSetRegistrationDate()
    {
        if (null == $this->registeredDate) {
            $this->registeredDate = new \DateTime('now');
        }
    }
}
