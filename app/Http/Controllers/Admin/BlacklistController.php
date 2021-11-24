<?php
/**
 

 *

 *

 * -------




 */

namespace App\Http\Controllers\Admin;

use Larapen\Admin\app\Http\Controllers\PanelController;
use App\Http\Requests\Admin\Request as StoreRequest;
use App\Http\Requests\Admin\Request as UpdateRequest;

class BlacklistController extends PanelController
{
	public function setup()
	{
		/*
		|--------------------------------------------------------------------------
		| BASIC CRUD INFORMATION
		|--------------------------------------------------------------------------
		*/
		$this->xPanel->setModel('App\Models\Blacklist');
		$this->xPanel->setRoute(admin_uri('blacklists'));
		$this->xPanel->setEntityNameStrings(trans('admin::messages.blacklist'), trans('admin::messages.blacklists'));
		$this->xPanel->orderBy('id', 'DESC');
		
		$this->xPanel->addButtonFromModelFunction('top', 'bulk_delete_btn', 'bulkDeleteBtn', 'end');
		
		/*
		|--------------------------------------------------------------------------
		| COLUMNS AND FIELDS
		|--------------------------------------------------------------------------
		*/
		// COLUMNS
		$this->xPanel->addColumn([
			'name'  => 'id',
			'label' => '',
			'type'  => 'checkbox',
			'orderable' => false,
		]);
		$this->xPanel->addColumn([
			'name'  => 'type',
			'label' => trans("admin::messages.Type"),
		]);
		$this->xPanel->addColumn([
			'name'  => 'entry',
			'label' => trans("admin::messages.Entry"),
		]);
		
		// FIELDS
		$this->xPanel->addField([
			'name'  => 'type',
			'label' => trans("admin::messages.Type"),
			'type'  => 'enum',
		]);
		$this->xPanel->addField([
			'name'       => 'entry',
			'label'      => trans("admin::messages.Entry"),
			'type'       => 'text',
			'attributes' => [
				'placeholder' => trans("admin::messages.Entry"),
			],
		]);
	}
	
	public function store(StoreRequest $request)
	{
		return parent::storeCrud();
	}
	
	public function update(UpdateRequest $request)
	{
		return parent::updateCrud();
	}
}
