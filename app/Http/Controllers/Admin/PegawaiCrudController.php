<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PegawaiRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class PegawaiCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PegawaiCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        $this->crud->denyAccess(['list', 'show', 'create', 'update', 'delete']);

        if (backpack_user()->can('pegawai-create')) {
            $this->crud->allowAccess('create');
        }
        if (backpack_user()->can('pegawai-read')) {
            $this->crud->allowAccess('list');
        }
        if (backpack_user()->can('pegawai-update')) {
            $this->crud->allowAccess('update');
        }
        if (backpack_user()->can('pegawai-delete')) {
            $this->crud->allowAccess('delete');
        }

        $this->crud->setModel('App\Models\Pegawai');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/pegawai');
        $this->crud->setEntityNameStrings('pegawai', 'pegawai');
    }

    protected function setupListOperation()
    {
        // TODO: remove setFromDb() and manually define Columns, maybe Filters
        // $this->crud->setFromDb();
        $this->crud->addColumn(['name' => 'nip', 'type' => 'text', 'label' => 'NIP']);
        $this->crud->addColumn(['name' => 'nama', 'type' => 'text', 'label' => 'Nama']);
    }

    protected function setupCreateOperation()
    {
        $this->crud->setValidation(PegawaiRequest::class);

        // TODO: remove setFromDb() and manually define Fields
        // $this->crud->setFromDb();
        $this->crud->addField(['name' => 'nip', 'type' => 'number', 'label' => 'NIP']);
        $this->crud->addField(['name' => 'nama', 'type' => 'text', 'label' => 'Nama']);
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}