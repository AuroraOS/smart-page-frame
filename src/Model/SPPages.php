<?php
namespace SmartPage\Model;

use Illuminate\Database\Eloquent\Model;

class SPPages extends Model
{
    protected $table = 'sp_pages';
    protected $primaryKey = 'id';
    protected $fillable = [
		    'name',
				'title',
        'html',
        'data',
        'visible',
		    'meta',
		    'modules',
		    'patern',
        'permission',
        'status',
        'plugin',
        'type'
    ];


}
