<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Media extends Model
{
    use Sluggable;
	protected $fillable = ['name', 'type'];
	
	const PUBLISH = 'PUBLISH';
	const DRAFT = 'DRAFT';
	const TRASH = 'TRASH';
	
	public function user(){
		return $this->belongsTo('\App\User');
	}
	
	/**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source'        => 'name',
                'separator'     => '-',
                'unique'        => true,
            ]
        ];
    }
}
