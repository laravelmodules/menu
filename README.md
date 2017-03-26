# Menu Module
This is a Required Module for LaravelModules

### Default Menus

- BackendMenu
- DashboardMenu

##### Facades

Each Menu has his own Facade with the same functions
###### SidebarServiceProvider
Each Module has a SidebarServiceProvider

- Add Item to the menu
In the Sidebar folder of each module there are one php file for each menu
Example
``` php
\BackendMenu::registerItem([
    'id' => 'Menu',
    'priority' => 20,
    'parent_id' => null,
    'heading' => null,
    'title' => 'Menus',
    'font_icon' => 'fa fa-bars',
    'link' => '',
    'css_class' => null,
    'permissions' => ['view-menus','view-backend']
]);
```
If you have a Resource route you can use
``` php
\BackendMenu::registerResource([
    'parent' => 'Users', // Module Name
    'prefix' => 'users', // Route prefix
    'resource' => 'user', // Resouce name
    'permissions' => 'view-backend', // Permissions Group
    'priority' => 12, // priority Group
]);
```
In "link" attribute you can set an url(), http:// or route()

- Render Menu in views
``` php
{!! BackendMenu::render() !!}
```

##### Commands

- `module-menu:list` Show list of all menu items.
    Options:
        [menu]

- `module-menu:menu:item` Generate new menu item for the specified module.
    Argument:
        [module]

    Options:
        [route]
        [link]
        [heading]
        [parent]
        [title]
        [menu]
