<?php
namespace SmartPage\Model;

use Illuminate\Database\Eloquent\Model;

class SPConfigGroups extends Model {

    protected $table = 'sp_config_groups';
    protected $primaryKey = 'id';
    protected $fillable = [
				'parent_id',
        'name',
        'description',
        'type',
				'ico'
    ];



		public function sub() {
        return $this->hasMany('\SmartPage\Model\SPConfigGroups', 'parent_id')->with('sub')->with('config');
    }

		public function config() {
        return $this->hasMany('\SmartPage\Model\SPConfig', 'group_id');
    }



}
