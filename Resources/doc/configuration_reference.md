CCDNUser AdminBundle Configuration Reference.
=============================================

All available configuration options are listed below with their default values.

``` yml
#
# for CCDNUser AdminBundle   
#
ccdn_user_admin:                      # Required
    template:
        engine:                       twig
        pager_theme:                  CCDNUserAdminBundle:Common:Paginator/twitter_bootstrap.html.twig
    users_per_page:                   30
    entity:                           # Required
        user:                         # Required
            class:                    Acme\YourUserBundle\Entity\User # Required
    gateway:
        user:
            class:                    CCDNUser\AdminBundle\Model\Component\Gateway\UserGateway
    repository:
        user:
            class:                    CCDNUser\AdminBundle\Model\Component\Repository\UserRepository
    manager:
        user:
            class:                    CCDNUser\AdminBundle\Model\Component\Manager\UserManager
    model:
        user:
            class:                    CCDNUser\AdminBundle\Model\FrontModel\UserModel
    form:
        type:
            update_account:
                class:                CCDNUser\AdminBundle\Form\Type\Admin\UpdateAccountFormType
            update_roles:
                class:                CCDNUser\AdminBundle\Form\Type\Admin\UpdateRolesFormType
        handler:
            update_account:
                class:                CCDNUser\AdminBundle\Form\Handler\Admin\UpdateAccountFormHandler
            update_roles:
                class:                CCDNUser\AdminBundle\Form\Handler\Admin\UpdateRolesFormHandler
    component:
        dashboard:
            integrator:
                class:                CCDNUser\AdminBundle\Component\Dashboard\DashboardIntegrator
    seo:
        title_length:                 67
    account:
        show_newest_users:
            layout_template:          CCDNUserAdminBundle::base.html.twig
            member_since_datetime_format:  d-m-Y - H:i
        show_user:
            layout_template:          CCDNUserAdminBundle::base.html.twig
            member_since_datetime_format:  d-m-Y - H:i
        edit_user_account:
            layout_template:          CCDNUserAdminBundle::base.html.twig
            form_theme:               CCDNUserAdminBundle:Common:Form/fields.html.twig
    ban:
        show_banned_users:
            layout_template:          CCDNUserAdminBundle::base.html.twig
            member_since_datetime_format:  d-m-Y - H:i
    activation:
        show_unactivated_users:
            layout_template:          CCDNUserAdminBundle::base.html.twig
            member_since_datetime_format:  d-m-Y - H:i
    role:
        set_users_role:
            layout_template:          CCDNUserAdminBundle::base.html.twig
            form_theme:               CCDNUserAdminBundle:Common:Form/fields.html.twig
```

Replace Acme\YourUserBundle\Entity\User with the user class of your chosen user bundle.

- [Return back to the docs index](index.md).
