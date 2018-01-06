<?php
namespace App\Entities;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Vinelab\NeoEloquent\Eloquent\Model as NeoEloquent;
use Vinelab\NeoEloquent\Eloquent\SoftDeletes as SoftDeletes;
class Category extends NeoEloquent
{
	use SoftDeletes,HasApiTokens,Notifiable;
	protected $label = 'Category';
	protected $dates = ['deleted_at'];
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'id',
		'name',
	];
	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password', 'remember_token',
	];
	public function routeNotificationForSlack() {
		return env('SLACK_WEBHOOK_URL');
	}
	public function hasManyBook(){
		return $this->hasMany(Book::class,'HAS_CATEGORY');
	}
	public function books(){
		return $this->hasMany(Book::class,'BELONGSTO_CATEGORY');
	}
	public function create (array $attributes = []){
		$attributes['id'] = rand(100000000,999999999).time();
		$attributes['created_at'] = time();
		$attributes['updated_at'] = time();
		return parent::create($attributes); // TODO: Change the autogenerated stub
	}
	public function update(array $attributes = [], array $options = []){
		$attributes['updated_at'] = time();
		return parent::update($attributes, $options); // TODO: Change the autogenerated stub
	}
	/**
	 * @return mixed
	 */
	public function getLabel()
	{
		return $this->label;
	}
	/**
	 * @param mixed $label
	 *
	 * @return self
	 */
	public function setLabel($label)
	{
		$this->label = $label;
		return $this;
	}
	/**
	 * @return mixed
	 */
	public function getDates()
	{
		return $this->dates;
	}
	/**
	 * @param mixed $dates
	 *
	 * @return self
	 */
	public function setDates($dates)
	{
		$this->dates = $dates;
		return $this;
	}
	/**
	 * @return array
	 */
	public function getFillable()
	{
		return $this->fillable;
	}
	/**
	 * @param array $fillable
	 *
	 * @return self
	 */
	public function setFillable(array $fillable)
	{
		$this->fillable = $fillable;
		return $this;
	}
	/**
	 * @return array
	 */
	public function getHidden()
	{
		return $this->hidden;
	}
	/**
	 * @param array $hidden
	 *
	 * @return self
	 */
	public function setHidden(array $hidden)
	{
		$this->hidden = $hidden;
		return $this;
	}
}