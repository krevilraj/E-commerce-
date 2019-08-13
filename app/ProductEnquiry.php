<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductEnquiry extends Model {
	protected $fillable = [
		'user_id',
		'product_id',
		'quantity',
		'enquiry_note',
	];

	public function user() {
		return $this->belongsTo( User::class );
	}

	public function product() {
		return $this->belongsTo( Product::class );
	}
}
