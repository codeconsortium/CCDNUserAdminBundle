CCDNUser AdminBundle Configuration Reference.
=============================================

All available configuration options are listed below with their default values.

``` yml
#
# for CCDNUser AdminBundle   
#
ccdn_user_admin:
    user:
        profile_route: cc_profile_show_by_id 
    template:
        engine: twig
	seo:
		title_length: 67
    activation:
        show_unactivated_users:
            layout_template: CCDNComponentCommonBundle:Layout:layout_body_right.html.twig
            users_per_page: 30
            member_since_datetime_format: "d-m-Y - H:i"
    ban:
        show_banned_users:
            layout_template: CCDNComponentCommonBundle:Layout:layout_body_right.html.twig
            users_per_page: 30
            member_since_datetime_format: "d-m-Y - H:i"
    role:
        set_users_role:
            layout_template: CCDNComponentCommonBundle:Layout:layout_body_right.html.twig
            form_theme: CCDNUserAdminBundle:Form:fields.html.twig
    account:
        show_newest_users:
            layout_template: CCDNComponentCommonBundle:Layout:layout_body_right.html.twig
            users_per_page: 30
            member_since_datetime_format: "d-m-Y - H:i"
        show_user:
            layout_template: CCDNComponentCommonBundle:Layout:layout_body_right.html.twig
            member_since_datetime_format: "d-m-Y - H:i"
        edit_user_account:
            layout_template: CCDNComponentCommonBundle:Layout:layout_body_right.html.twig
            form_theme: CCDNUserAdminBundle:Form:fields.html.twig
        edit_user_profile:
            layout_template: CCDNComponentCommonBundle:Layout:layout_body_right.html.twig
            form_theme: CCDNUserAdminBundle:Form:fields.html.twig

```

- [Return back to the docs index](index.md).
