<?php

namespace Modules\Menu\Http\Controllers\Backend;

use Yajra\Datatables\Services\DataTable;

class MenuDataTable extends DataTable
{
    /**
     * Display ajax response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        $query = $this->query();

        return $this->datatables
            ->of($query)
            // ->editColumn('action', function ($query) {
            //     return $query->action_buttons;
            // })
        ->make(true);
    }

    /**
     * Get the query object to be processed by dataTables.
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|\Illuminate\Support\Collection
     */
    public function query()
    {
        $query = \BackendMenu::getRows();
        // $query = \BackendMenu::mainGroups();
        // $query = \BackendMenu::rearrangeLinks();
        // $query = \BackendMenu::all()->sortBy('id');

        return $query;
        return $this->applyScopes($query);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\Datatables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->columns($this->getColumns())
            // ->addColumn(['data' => 'action', 'name' => 'action', 'title' => 'action','searchable' => false, 'orderable' => false])
            // ->columns([
            // ])
            ->ajax('')
            // ->addAction(['width' => '80px'])
            ->parameters([
                // 'dom' => 'Bfrtip',
                'dom' => 'Blfrtip',
                // 'buttons' => ['export','reset', 'reload'],
                'buttons' => ['csv', 'excel', 'print', 'reset', 'reload'],
                // 'buttons' => ['csv', 'excel', 'pdf', 'print', 'reset', 'reload'],
                'pageLength' => 30,
                "lengthMenu" => [ 10, 25,30, 50, 75, 100 ,150],
            ]);
            // ->parameters($this->getBuilderParameters());
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'id',
            'priority',
            'parent_id',
            'heading',
            'title',
            'font_icon',
            'link',
            'css_class',
            'permissions',
            'children',
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'menu_' . time();
    }
}
