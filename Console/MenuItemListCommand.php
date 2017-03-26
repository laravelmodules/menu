<?php

namespace Modules\Menu\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class MenuItemListCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'module-menu:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Show list of all menu items.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        // dd(\BackendMenu::all());
        $this->table([
            'id',
            'priority',
            'parent_id',
            'heading',
            'title',
            // 'font_icon',
            'link',
            // 'css_class',
            'permissions',
            'children',
        ], $this->getRows());
        // $this->table(['Name', 'Status', 'Order', 'Path'], $this->getRows());
    }
    /**
     * Get table rows.
     *
     * @return array
     */
    public function getRows()
    {

        $menuName = $this->option('menu') !== null ?: 'Menu'.ucfirst($this->option('menu'));

        if ($this->option('menu') === null) {
            $menuList = \BackendMenu::all();
        } elseif ($this->option('menu') === 'Dashboard') {
            $menuList = \DashboardMenu::all();
        } else {
            return 'El menú no está registrado';
        }

        $rows = [];
        foreach ($menuList as $key => $item) {
            $rows[] = $this->getChildren($item,$menuList);
        }

        return $rows;
    }

    /**
     * Get table children rows.
     *
     * @return array
     */
    public function getChildren($item,$all)
    {
        $children = $all->where('parent_id',$item['id'])->all();
        // dd($children);
        $row = [
            isset($item['id']) ? $item['id'] : null,
            isset($item['priority']) ? $item['priority'] : null,
            isset($item['parent_id']) ? $item['parent_id'] : null,
            isset($item['heading']) ? $item['heading'] : null,
            isset($item['title']) ? $item['title'] : null,
            // isset($item['font_icon']) ? $item['font_icon'] : null,
            isset($item['link']) ? $item['link'] : null,
            // isset($item['css_class']) ? $item['css_class'] : null,
            isset($item['permissions']) ? (is_array($item['permissions']) ? "'".implode("',\n'",$item['permissions'])."'" : $item['permissions']) : null,
            // $children,
            count(array_keys($children))>0 ? "'".implode("',\n'",array_keys($children))."'" : null ,
        ];
        return $row;
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            // ['module', InputArgument::REQUIRED, 'Module Name.'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['menu', 'Dashboard', InputOption::VALUE_OPTIONAL, 'Menu type option.', null],
        ];
    }
}
