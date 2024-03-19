<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Page extends Model implements HasMedia
{
    use InteractsWithMedia, HasFactory;

    public $table = 'pages';

    protected $appends = [
        'page_image',
    ];

    public const SHOW_IN_MENU_SELECT = [
        '1' => 'Yes',
        '2' => 'No',
    ];

    public const SHOW_IN_FOOTER_SELECT = [
        '1' => 'Yes',
        '2' => 'No',
    ];

    public const STATUS_SELECT = [
        '1' => 'Enable',
        '2' => 'Disable',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'parent_page_id',
        'title',
        'heading',
        'show_in_menu',
        'show_in_footer',
        'status',
        'description',
        'slug',
        'meta_tag',
        'meta_title',
        'meta_description',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }

    public function parentPagePages()
    {
        return $this->hasMany(self::class, 'parent_page_id', 'id');
    }

    public function parent_page()
    {
        return $this->belongsTo(self::class, 'parent_page_id');
    }

    public function getPageImageAttribute()
    {
        $files = $this->getMedia('page_image');
        $files->each(function ($item) {
            $item->url       = $item->getUrl();
            $item->thumbnail = $item->getUrl('thumb');
            $item->preview   = $item->getUrl('preview');
        });

        return $files;
    }
}
