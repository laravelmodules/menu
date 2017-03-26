<?php

\BackendMenu::registerItem([
    'id' => 'Menu',
    'priority' => 2,
    'parent_id' => null,
    'heading' => '',
    // 'heading' => 'Menu',
    'title' => 'Menu',
    'font_icon' => 'fa fa-bars',
    // 'link' => route('menu::menus.index.get'),
    'link' => '',
    'css_class' => null,
    'permissions' => ['view-menus']
]);

\BackendMenu::registerResource([
     'parent' => 'Menu', // Module Name
     'prefix' => 'admin', // Route prefix
     'resource' => 'menu', // Resouce name
     'permissions' => ['manage-users', 'manage-roles'], // Permissions Group
     'priority' => 2.1, // priority Group
]);

// \BackendMenu::registerItem([
//         'id' => route('Menu.usuario.index'),
//         'priority' => 1,
//         'parent_id' => 'Menu',
//         'heading' => 'Claro',
//         'title' => 'Claro',
//         'font_icon' => 'fa fa-plus-circle',
//         'link' => route('Menu.usuario.index'),
//         // 'link' => '',
//         'css_class' => null,
//         'permissions' => 'view-backend'
// ]);

includeFiles(__DIR__.'/Backend/');
