<?php
namespace SmartPage\Model;

use Illuminate\Database\Eloquent\Model;

class Custom extends Model
{
    protected $table;
    protected $primaryKey = 'id';

		public function __construct($table = null){
			if ($table) {
				$this->table = $table;
			}
			return $this;
		}

		public function __invoke($table = null){
			if ($table) {
				$this->table = $table;
			}
			return $table;
		}


}
