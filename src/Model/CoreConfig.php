<?php
namespace SmartPage\Model;

use Illuminate\Database\Eloquent\Model;

class CoreConfig extends Model {

    protected $table = 'core_config';
    protected $primaryKey = 'id';
    protected $fillable = [
    	  'name',
    	  'data',
        'env',
		    'type',
        'tag',
        'configlayout',
				'group'
    ];



}
