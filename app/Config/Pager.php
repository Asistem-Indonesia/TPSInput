<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Pager extends BaseConfig
{
	/*
	|--------------------------------------------------------------------------
	| Templates
	|--------------------------------------------------------------------------
	|
	| Pagination links are rendered out using views to configure their
	| appearance. This array contains aliases and the view names to
	| use when rendering the links.
	|
	| Within each view, the Pager object will be available as $pager,
	| and the desired group as $pagerGroup;
	|
	*/
	public $templates = [
		'default_full'   => 'CodeIgniter\Pager\Views\default_full',
		'default_simple' => 'CodeIgniter\Pager\Views\default_simple',
		'default_head'   => 'CodeIgniter\Pager\Views\default_head',
		'kelurahan_pagination' => 'CodeIgniter\Pager\Views\kelurahan_pagination',
		'kecamatan_pagination' => 'CodeIgniter\Pager\Views\kecamatan_pagination',
		'tps_pagination' => 'CodeIgniter\Pager\Views\tps_pagination'
	];

	/*
	|--------------------------------------------------------------------------
	| Items Per Page
	|--------------------------------------------------------------------------
	|
	| The default number of results shown in a single page.
	|
	*/
	public $perPage = 20;
}
