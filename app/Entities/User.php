<?php

namespace App\Entities;
use function array_merge;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use function rand;
use function time;
use Vinelab\NeoEloquent\Eloquent\Model as NeoEloquent;
use Illuminate\Auth\Authenticatable as AuthenticableTrait;

/**
 * @property \Carbon\Carbon $created_at
 */
class User extends NeoEloquent implements Authenticatable
{
	use HasApiTokens, Notifiable, AuthenticableTrait;
	protected $label = 'User';
	protected static $defaultParams;

	function __construct (array $attributes = [])
	{

		parent::__construct($attributes);
		self::$defaultParams = [
			'id' => rand(100000000,999999999).time(),
			'name' => '',
			'fb_user_id' => '',
			'fb_refresh_token' => '',
			'fb_profile_link' => '',
			'fb_token' => '',
			'email' => '',
			'password' => '',
			'gender' => '',
			'birthday' => '',
			'sell_phone' => '',
			'business_phone' => '',
			'ranking' => 0,
			'score' => 0,
			'total_received' => 0,
			'total_giver' => 0,
			'flower' => 0,
			'remember_token' => '',
			'fb_token_expired_at' => '',
			'created_at' => time(),
			'updated_at' => time()
		];
	}

	public function routeNotificationForSlack() {
		return env('SLACK_WEBHOOK_URL');
	}

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'id',
		'name',
		'fb_user_id',
		'fb_refresh_token',
		'fb_profile_link',
		'fb_token',
		'email',
		'password',
		'gender',
		'birthday',
		'sell_phone',
		'business_phone',
		'ranking',
		'score',
		'total_received',
		'total_giver',
		'flower',
		'remember_token',
		'fb_token_expired_at',
		'created_at',
		'updated_at'
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password', 'remember_token',
	];

	public function setGiveBook(){
		return $this->hasOne(Book::class,'GIVE_BOOK');
	}

	public function giveBook(){
		return $this->hasMany(Book::class,'GIVE_BOOK');
	}

	public function setReceiver(){
		return $this->hasMany(Book::class,'NEED_BOOK');
	}

	public function receiver(){
		return $this->hasMany(Book::class,'NEED_BOOK');
	}

	public function received(){
		return $this->hasMany(Book::class,'HAS_BOOK');
	}

	public function setHasBook(){
		return $this->hasOne(Book::class,'HAS_BOOK');
	}

	public function hasBook(){
		return $this->hasMany(Book::class,'HAS_BOOK');
	}

	public function setRequest(){
		return $this->hasOne(Book::class,'REQUEST_BOOK');
	}

	public function bookRequest(){
		return $this->hasMany(Book::class,'REQUEST_BOOK');
	}


	public function dropRelation($relation){

	}
	public static function createOrUpdate ($user)
	{
		$existUser = static::where('fb_user_id', $user->id)->first();
		$params = array(
			'name' => $user->name,
			'fb_token' => $user->token,
			'fb_refresh_token' => $user->refreshToken ? $user->refreshToken : '',
			'fb_user_id' => $user->id,
			'fb_token_expired_at' => $user->expiresIn,
			'email' => $user->email,
			'fb_avatar' => $user->avatar,
			'gender' => $user->user['gender'],
			'fb_profile_link' => $user->user['link'],
			'created_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s')
		);

		if ($existUser) {
			Auth::login($existUser);
		} else {
			static::create(array_merge(self::$defaultParams, $params));
			$user = static::where('fb_user_id', '=', $params['fb_user_id'])->first();
			Auth::login($user);
		}
	}
}

