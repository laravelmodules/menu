<?php

namespace Modules\Menu\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Illuminate\Filesystem\Filesystem;

class MenuItemCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'module-menu:menu:item';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate new menu item for the specified module.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Filesystem $filesystem)
    {
        parent::__construct();
        $this->filesystem = $filesystem;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $module = ucfirst($this->argument('module'));

        $menuName = $this->option('menu') === null ? 'Backend' :  ucfirst($this->option('menu')) ;

        $menuFileName = $this->option('menu') === null ? '/backend.php' : '/'.strtolower($this->option('menu')).'.php';

        $file = base_path('Modules/'.$module.'/Sidebar'.$menuFileName);

        $route = $this->option('route') !== null ? "route('".$this->option('route')."')" : null;
        $url = $this->option('link') !== null ? "url('".$this->option('link')."')" : "url('#')";
        $link = $route !== null ? $route : $url;

        $id = $route !== null ? $route : $link;

        $heading = $this->option('heading') !== null ? "'".$this->option('heading')."'" : null;
        $title = $this->option('title') !== null ? "'".$this->option('title')."'" : $module;

        $data =
"\\".$menuName."Menu::registerItem([
    'id' => ".$id.",
    'priority' => 1,
    'parent_id' => '".$module."',
    'heading' => '".$heading."',
    'title' => '".$title."',
    'font_icon' => 'fa fa-circle-o',
    'link' => ".$link.",
    'css_class' => null,
    'permissions' => 'view-backend'
]);\n";
        $this->filesystem->append($file,$data);
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['module', InputArgument::REQUIRED, 'Module Name.'],
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
            ['route', null, InputOption::VALUE_OPTIONAL, 'Menu item Route option.', null],
            ['link', null, InputOption::VALUE_OPTIONAL, 'Menu item Link option.', null],
            ['heading', null, InputOption::VALUE_OPTIONAL, 'Menu item Heading option.', null],
            ['parent', null, InputOption::VALUE_OPTIONAL, 'Menu item Parent option.', null],
            ['title', null, InputOption::VALUE_OPTIONAL, 'Menu item Title option.', null],
            ['menu', null, InputOption::VALUE_OPTIONAL, 'Menu name option.', null],
        ];
    }
}
