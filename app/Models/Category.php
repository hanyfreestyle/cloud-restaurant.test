<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\App;

class Category extends Model
{
    use HasFactory, SoftDeletes, Uuids, Translatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'restaurant_id',
        'slug',
        'position',
        'image',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'position' => 'integer',
        'is_active' => 'boolean',
    ];
    
    /**
     * The attributes that are translatable.
     *
     * @var array
     */
    public $translatedAttributes = ['name'];

    /**
     * Get the restaurant associated with the category.
     */
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    /**
     * Get the products associated with the category.
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
    
    /**
     * Get the translations relationship.
     */
    public function translations()
    {
        return $this->hasMany(CategoryTranslation::class);
    }
    
    /**
     * Get the default translation relationship.
     */
    public function defaultTranslation()
    {
        return $this->hasOne(CategoryTranslation::class)
            ->where('locale', App::getLocale())
            ->withDefault(['name' => $this->slug]);
    }
    
    /**
     * Apply a scope to get categories with their translated names.
     */
    public function scopeWithTranslation(Builder $query)
    {
        $locale = App::getLocale();
        
        return $query->addSelect([
            'categories.*',
            'category_translations.name',
        ])
        ->join('category_translations', function ($join) use ($locale) {
            $join->on('categories.id', '=', 'category_translations.category_id')
                 ->where('category_translations.locale', '=', $locale);
        });
    }
}
