<?php

namespace Modules\Menu\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Modules\Menu\Http\Controllers\Backend\MenuDataTable;
use Modules\Menu\Http\Requests\Backend\MenuFormRequest;
use Modules\Menu\Models\Menu;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(MenuDataTable $dataTable)
    {
        return $dataTable->render('menu::datatable',['title' => 'Menu','subtitle' => 'Listado']);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $model = new Menu ;
        $fields = [''];
        $storeRoute = 'menu.menu.store';
        return view('menu::create')->with('model', $model)->with('fields', $fields)->with('storeRoute', $storeRoute);
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(MenuFormRequest $request)
    {
        $model = Menu::create($request->all());
        return redirect()->route('menu.menu.show',$model->id)->with('flash_success', 'Creado!');
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show($id)
    {
        $model = Menu::findOrFail($id);
        $fields = [''];
        return view('menu::show')->with('model', $model)->with('fields', $fields);
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit($id)
    {
        $model = Menu::findOrFail($id);
        $fields = [''];
        $updateRoute = 'menu.menu.update';
        return view('menu::edit')->with('model', $model)->with('fields', $fields)->with('updateRoute', $updateRoute);
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(MenuFormRequest $request,$id)
    {
        $model = Menu::findOrFail($id);
        $model->update($request->all());
        return redirect()->route('menu.menu.show',$model->id)->with('flash_success', 'Guardado');
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy($id)
    {
        $model = Menu::findOrFail($id);
        $model->delete();
        return redirect()->route('menu.menu.index')->with('flash_success', 'Eliminado');
    }
}
