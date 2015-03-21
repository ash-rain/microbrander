<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Template extends Model {

	public $timestamps = false;
	protected $guarded = ['id'];

	public function products() {
		return $this->hasMany('App\Product');
	}

	public function images() {
		return $this->morphMany('App\Image', 'imageable');
	}

	public function getDrawConfigAttribute() {
		return json_decode($this->attributes['draw_data']);
	}

}
