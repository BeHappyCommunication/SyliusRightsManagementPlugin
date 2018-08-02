# Sylius Rights Management Plugin
A rights management plugin for Sylius.

# Installation

1. Run 
```bash
$ composer require behappy/rights-management-plugin
```

2. Enable the plugin in app/AppKernel.php:
```php
public function registerBundles(): array
{
    $bundles = [
        // ...
        new \BeHappy\SyliusRightsManagementPlugin\BeHappySyliusRightsManagementPlugin()
    ];
    
    // ...
}
```


2. Add the following import to config.yml:
```yaml
imports:
    # ...
    - { resource: '@BeHappySyliusRightsManagementPlugin/Resources/config/app/config.yml' }
```

3. Add the following route to routing.yml:
```yaml
be_happy_rights_management:
    resource: '@BeHappySyliusRightsManagementPlugin/Resources/config/routing.yaml'
    prefix: /admin
```

4. Update your database schema: 
```bash
$ php bin/console doctrine:schema:update --force
```

5. Override AdminUser template to add group select:
    1) Create a file: app/Resources/SyliusAdminBundle/views/AdminUser/_form.html.twig
    
    2) In the freshly created file, put the content of [_form.html.twig](https://github.com/Sylius/SyliusAdminBundle/blob/master/Resources/views/AdminUser/_form.html.twig)
    
    3) Then add the following snippet:
    ```twig
    <div class="ui segment">
        <h4 class="ui dividing header">{{ 'be_happy_rights_management.ui.group'|trans }}</h4>
        {{ form_widget(form.group) }}
    </div>
    ```
    
# Usage
Group can only grant or deny access to listed routes.
To list route, add to your config.yml.

Example:
```yaml
be_happy_sylius_rights_management:
    rights:
        product:
            all:
                name: 'be_happy_rights_management.rights.product.all'
                routes: ['sylius_admin_product_*']
                exclude: ['sylius_admin_product_review_*']
                redirect_to: sylius_admin_dashboard
                redirect_message: "be_happy_rights_management.message.access_denied"
        customer:
            list:
                name: 'be_happy_rights_management.rights.customer.list'
                routes: ['sylius_admin_customer_index']
                redirect_to: sylius_admin_dashboard
                redirect_message: "be_happy_rights_management.message.access_denied"
```
Architecture is:
```yaml
be_happy_sylius_rights_management:
    rights:
        <family>:
            <action>:
                name: 'Feel free to set what you want. This string is translated by Symfony.'
                route: 'The name of the route in the routing.yml.'
                routes: 'An array of routes. This syntax is preferred to "route"'
                exclude: 'An array of excluded routes (useful if you define routes with a *).'
                redirect_to: 'The route to redirect if not granted.'
                redirect_message: 'A message if not granted.'
```
Family and Action can be set to what you want, they are only used to get a nice and beautiful architecture.

The syntax with an "\*" is allowed, making the firewall to take everything starting by the given string. The "\*" is only allowed at the end of a string.

# Caution

We advice you to create an Admin Group with full right, otherwise when you will edit an user, it will take the first group in the list. And you will need to unlock the user directly in MySQL.
You manually need to update and save groups if new routes are added in config.yml.

# Feel free to contribute
You can also ask your questions at the mail address in the composer.json mentioning this package.

# Other
You can also check our other packages (including Sylius plugins) at https://github.com/BeHappyCommunication
