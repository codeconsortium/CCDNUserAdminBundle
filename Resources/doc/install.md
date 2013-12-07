Installing CCDNUser AdminBundle 2.x
===================================

## Dependencies:

> Note you will need a User Bundle so that you can map the UserInterface to your own User entity. You can use whatecer User Bundle you prefer. FOSUserBundle is highly rated.

## Installation:

Installation takes only 3 steps:

1. Download and install dependencies via Composer.
2. Register bundles with AppKernel.php.
3. Update your app/config/routing.yml.
4. Update your app/config/config.yml.
5. Update your user entity.

### Step 1: Download and install dependencies via Composer.

Append the following to end of your applications composer.json file (found in the root of your Symfony2 installation):

``` js
// composer.json
{
    // ...
    "require": {
        // ...
        "codeconsortium/ccdn-user-admin-bundle": "dev-master"
    }
}
```

NOTE: Please replace ``dev-master`` in the snippet above with the latest stable branch, for example ``2.0.*``.

Then, you can install the new dependencies by running Composer's ``update``
command from the directory where your ``composer.json`` file is located:

``` bash
$ php composer.phar update
```

### Step 2: Register bundles with AppKernel.php.

Now, Composer will automatically download all required files, and install them
for you. All that is left to do is to update your ``AppKernel.php`` file, and
register the new bundle:

``` php
// app/AppKernel.php
public function registerBundles()
{
    $bundles = array(
		new CCDNUser\AdminBundle\CCDNUserAdminBundle(),
		...
	);
}
```

### Step 3: Update your app/config/routing.yml.

In your app/config/routing.yml add:

``` yml
# app/config/routing.yml
CCDNUserAdminBundle:
    resource: "@CCDNUserAdminBundle/Resources/config/routing.yml"
    prefix: /
```

### Step 4: Update your app/config/config.yml.

In your app/config/config.yml add:

``` yml
# app/config/config.yml
ccdn_user_admin:
    entity:
        user:
            class: Acme\YourUserBundle\Entity\User
```

Replace Acme\YourUserBundle\Entity\User with the user class of your chosen user bundle.

### Step 5: Update your user entity.

In order for the bundle to function correctly you need to add the following to your user entity:

``` php
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
	$this->registeredDate = new \Datetime('now');
}

/**
 * Get registeredDate
 *
 * @return \Datetime
 */
public function getRegisteredDate()
{
    return $this->registeredDate;
}

/**
 * Set registeredDate
 *
 * @param  \Datetime $registeredDate
 */
public function setRegisteredDate(\Datetime $registeredDate)
{
    $this->registeredDate = $registeredDate;
}
```

### Translations

If you wish to use default texts provided in this bundle, you have to make sure you have translator enabled in your config.

``` yaml
# app/config/config.yml
framework:
    translator: ~
```

## Next Steps.

Installation should now be complete!

If you need further help/support, have suggestions or want to contribute please join the community at [Code Consortium](http://www.codeconsortium.com)

- [Return back to the docs index](index.md).
- [Configuration Reference](configuration_reference.md).
