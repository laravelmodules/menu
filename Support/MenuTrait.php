<?php namespace Modules\Menu\Support;

/**
 *
 */
trait MenuTrait
{
    /**
     * Get all registered links from package
     * @var array
     */
    protected $links = [];

    /**
     * Get all activated items
     * @var array
     */
    protected $active = [];

    /**
     * @var User
     */
    protected $loggedInUser;

    /**
     * @var string
     */
    protected $builtHtml;

    /**
     * @param User $user
     */
    public function setUser()
    {
        $this->loggedInUser = Auth::user();
    }
    /**
     * [registerResource description]
     * @method registerResource
     * @param  array            $options [description]
     * @return [type]           [description]
     */
    public function registerResource(array $options)
    {
        $parent = $options['prefix'].'-'.$options['resource'];
        $route = $options['prefix'].'.'.$options['resource'];

        $this->registerItem([
            'id' => $parent,
            'priority' => $options['priority'],
            'parent_id' => $options['parent'],
            'heading' => __(ucfirst($options['resource'])),
            'title' => __(ucfirst($options['resource'])),
            'font_icon' => 'fa fa-circle-o',
            'link' => route($route.'.index'),
            // 'link' => '',
            'css_class' => null,
            'permissions' => isset($options['permissions']) ? $options['permissions'] : ''
        ]);
        $this->registerItem([
            'id' => $options['resource'].'-index',
            'priority' => $options['priority'].'.1',
            'parent_id' => $parent,
            'heading' => __('Listado'),
            'title' => __('Listado'),
            'font_icon' => 'fa fa-circle-o',
            'link' => route($route.'.index'),
            // 'link' => '',
            'css_class' => null,
            'permissions' => isset($options['permissions']) ? $options['permissions'] : ''
        ]);
        $this->registerItem([
                'id' => $options['resource'].'-create',
                'priority' => $options['priority'].'.2',
                'parent_id' => $parent,
                'heading' => __('Crear'),
                'title' => __('Crear'),
                'font_icon' => 'fa fa-circle-o',
                'link' => route($route.'.create'),
                // 'link' => '',
                'css_class' => null,
                'permissions' => isset($options['permissions']) ? $options['permissions'] : ''
        ]);
    }
    /**
     * Add link
     * @param array $options
     * @return $this
     */
    public function registerItem(array $options)
    {
        if (isset($options['children'])) {
            unset($options['children']);
        }
        $defaultOptions = [
            'id' => null,
            'priority' => 99,
            'parent_id' => null,
            'heading' => null,
            'title' => null,
            'font_icon' => null,
            'link' => null,
            'css-class' => null,
            'children' => [],
            'permissions' => [],
        ];
        $options = array_merge($defaultOptions, $options);
        $id = $options['id'];

        if (!$id) {
            $calledClass = debug_backtrace()[2];
            throw new \RuntimeException('Menu id not specified: ' . $calledClass['class'] . '@' . $calledClass['function']);
        }
        if (isset($this->links[$id])) {
            $calledClass = debug_backtrace()[2];
            throw new \RuntimeException('Menu id already exists: ' . $id . ' on class ' . $calledClass['class'] . '@' . $calledClass['function']);
        }
        $parentId = $options['parent_id'];
        if ($parentId && !isset($this->links[$parentId])) {
            $calledClass = debug_backtrace()[2];
            throw new \RuntimeException('Parent id not exists: ' . $id . ' on class ' . $calledClass['class'] . '@' . $calledClass['function']);
        }

        $this->links[$id] = $options;

        return $this;
    }

    public function all()
    {
        return collect($this->links);
    }

    /**
     * @param $id
     * @return $this
     */
    public function removeItem($id)
    {
        array_forget($this->links, $id);

        return $this;
    }

    /**
     * Rearrange links
     * @return Collection
     */
    public function rearrangeLinks()
    {
        $links = $this->getChildren();
        $links = collect($links)->sortBy('priority');
        return $links;
    }

    /**
     * Get children items
     * @param null $id
     * @return Collection
     */
    protected function getChildren($id = null)
    {
        $children = collect([]);
        foreach ($this->links as $key => $row) {
            if ($row['parent_id'] == $id) {
                $row['children'] = $this->getChildren($row['id']);
                $children->push($row);
            }
        }
        return $children->sortBy('priority');
    }

    /**
     * Get activated items
     * @param $active
     */
    protected function setActiveItems($active)
    {
        foreach ($this->links as $key => $row) {
            if ($row['id'] == $active) {
                $this->active[] = $active;
                $this->setActiveItems($row['parent_id']);
            }
        }
    }

    /**
     * Render the menu
     * @param null|string $active
     * @return mixed
     * @throws \Exception
     * @throws \Throwable
     */
    public function setActiveItem($active = null)
    {
        $this->setActiveItems($active);

        return $this;
    }

    function mainGroups()
    {
        return $this->rearrangeLinks();
    }

    /**
     * Get table rows.
     *
     * @return array
     */
    public function getRows()
    {
        $menuList = $this->all();

        $rows = collect();
        foreach ($menuList as $key => $item) {
            $rows->push($this->getChildrenItem($item,$menuList));
        }

        return $rows;
    }

    /**
     * Get table children rows.
     *
     * @return array
     */
    public function getChildrenItem($item,$all)
    {
        $children = $all->where('parent_id',$item['id'])->all();
        // dd($children);
        $row = [
            'id' => isset($item['id']) ? $item['id'] : null,
            'priority' => isset($item['priority']) ? $item['priority'] : null,
            'parent_id' => isset($item['parent_id']) ? $item['parent_id'] : null,
            'heading' => isset($item['heading']) ? $item['heading'] : null,
            'title' => isset($item['title']) ? $item['title'] : null,
            'font_icon' => isset($item['font_icon']) ? $item['font_icon'] : null,
            'link' => isset($item['link']) ? $item['link'] : null,
            'css_class' => isset($item['css_class']) ? $item['css_class'] : null,
            'permissions' => isset($item['permissions']) ? (is_array($item['permissions']) ? "'".implode("',\n'",$item['permissions'])."'" : $item['permissions']) : null,
            'children' => count(array_keys($children))>0 ? "'".implode("',\n'",array_keys($children))."'" : null ,
        ];

        return $row;
    }

}
