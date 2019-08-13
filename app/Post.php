<?php

namespace App;

use App\Concern\Mediable;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Post extends Model {
	use Sluggable, Mediable;

	/**
	 * Return the sluggable configuration array for this model.
	 *
	 * @return array
	 */
	public function sluggable() {
		return [
			'slug' => [
				'source' => 'title'
			]
		];
	}

	protected $fillable = [
		'user_id',
		'title',
        'tags',

        'slug',
		'content',
		'status'
	];

	/**
	 * Return the post's author
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function user() {
		return $this->belongsTo( User::class );
	}

	public function comments() {
		return $this->hasMany( Comment::class );
	}

	public function allComments() {
		$comments = Comment::where( 'post_id', $this->attributes['id'] )->where( 'reply_id', 0 )->get();

		$comments = $this->addRelation( $comments );

		return $comments;
	}

	protected function addRelation( $comments ) {

		$comments->map( function ( $item, $key ) {

			$sub = $this->selectChild( $item->id );

			return $item = array_add( $item, 'replies', $sub );

		} );

		return $comments;
	}

	protected function selectChild( $id ) {
		$comments = Comment::where( 'post_id', $this->attributes['id'] )->where( 'reply_id', $id )->get();

		$comments = $this->addRelation( $comments );

		return $comments;

	}
}
