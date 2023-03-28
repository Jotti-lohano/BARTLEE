<?php 

namespace App\Core\Traits;

use App\Models\Translation;

trait Translatable {
	
	public function translations(){
		return $this->morphMany(Translation::class,'translatable');
	}
} 
?>