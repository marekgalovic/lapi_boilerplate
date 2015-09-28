<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DBTranslator;

abstract class BaseModel extends Model
{
	protected $translatable = [];
	protected $translationAttributes = [];

	public function __construct(array $attributes = [])
	{
		$this->appends = array_merge($this->appends, $this->translatable);
		$this->hidden[] = 'translation';

		if( $this->isTranslationModel() )
		{
			$this->fillable[] = 'language_id';
		}
		
		return parent::__construct( $attributes );
	}

	protected static function boot()
	{
		parent::boot();

		self::observe( new BaseObserver, 1 );
		self::setObserver();
	}

	private static function setObserver()
	{
		$observer = static::class . 'Observer';

		self::observe( new $observer );
	}

	public function newQuery()
	{
		$query = parent::newQuery();

		if( $this->isTranslatable() )
		{
			$query->with( 'translation' );
		}

		return $query;
	}

	//entity translations

	public function translation()
	{
		return $this->hasOne( $this->getTranslationModel(), $this->getTranslationColumn(), 'id' )->where( 'language_id', DBTranslator::getLangId() );
	}

	public function translate()
	{
		$translationModel = $this->getTranslationModel();

		if( !($translation = $this->translation) )
		{
			$translation = new $translationModel;
		}
		return $translation;
	}

	public function fill(array $attributes)
	{
		foreach($attributes as $key => $value)
		{
			if( $this->isTranslatable( $key ) )
			{
				$this->setTranslationAttribute( $key, $value );
				unset( $attributes[$key] );
			}
		}
		return parent::fill( $attributes );
	}

	public function saveTranslation()
	{
		if( $this->isTranslatable() )
		{
			$model = $this->translate();
			$model->fill( $this->getTranslationAttributes() );
			$this->translation()->save( $model );
		}
	}

	public function deleteTranslations()
	{
		if( $this->isTranslatable() )
		{
			$model = $this->getTranslationModelInstance();
			$model->where($this->getTranslationColumn(), $this->id)->delete();
		}
	}

	public function isTranslatable( $key = null )
	{
		if( $key !== null )
		{
			return in_array($key, $this->translatable);
		}
		return !empty( $this->translatable );
	}

	private function isTranslationModel()
	{
		$model = class_basename( static::class );
		return (strpos($model, 'Translation') !== false);
	}

	private function setTranslationAttribute( $key, $value )
	{
		$this->translationAttributes[$key] = $value;
		return $this;
	}

	private function getTranslationAttributes()
	{
		$this->setTranslationAttribute( 'language_id', DBTranslator::getLangId() ); 
		return $this->translationAttributes;
	}

	private function getTranslationModel()
	{
		$basename = class_basename( static::class );

		$translatedModel = $basename . 'Translation';

		return '\App\Models\\' . $translatedModel . '\\' . $translatedModel;
	}

	private function getTranslationModelInstance()
	{
		$model = $this->getTranslationModel();
		return new $model;
	}

	private function getTranslationColumn()
	{
		$basename = class_basename( static::class );

		$snaked = snake_case( $basename );

		return $snaked . '_id';
	}

	//is_default	

	public function hasDefaultAttribute()
	{
		return in_array('is_default', $this->fillable);
	}

	public function clearDefaults()
	{
		if( $this->hasDefaultAttribute() && ($this->is_default === true) )
		{
			$this->newQuery()->where('id', '!=', $this->id)->update(['is_default' => false]);
		}
	}

	public function __call( $method, $attributes )
	{
		$key = strtolower( str_replace(['get', 'Attribute'], '', $method) );

		if( $this->isTranslatable( $key ) )
		{
			return $this->translate()->$key;
		}

		return parent::__call( $method, $attributes );
	}

	public function __get( $key )
	{
		if( $this->isTranslatable( $key ) )
		{
			return $this->translate()->$key;
		}
		return parent::__get( $key );
	}

}