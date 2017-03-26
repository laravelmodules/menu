<?php

\DashboardMenu::registerItem([
    'id' => 'Menu',
    'priority' => 20,
    'parent_id' => null,
    'heading' => '',
    // 'heading' => 'Menu',
    'title' => 'Menu',
    'font_icon' => 'fa fa-bars',
    // 'link' => route('menu.menu.index.get'),
    'link' => '',
    'css_class' => null,
    'permissions' => ['view-menus']
]);

// \DashboardMenu::registerResource([
//      'parent' => 'Menu', // Module Name
//      'prefix' => 'menu', // Route prefix
//      'resource' => 'menu', // Resouce name
//      'permissions' => 'view-backend', // Permissions Group
//      'priority' => 31, // priority Group
// ]);

// \MenuDashboard::registerItem([
//         'id' => route('menu.menu.index'),
//         'priority' => 1,
//         'parent_id' => 'Menu',
//         'heading' => 'Claro',
//         'title' => 'Claro',
//         'font_icon' => 'fa fa-plus-circle',
//         'link' => route('menu.menu.index'),
//         // 'link' => '',
//         'css_class' => null,
//         'permissions' => 'view-backend'
// ]);

includeFiles(__DIR__.'/Dashboard/');
