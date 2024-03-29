<?php

namespace Corals\Utility\SEO\Models;

use Corals\Foundation\Models\BaseModel;
use Corals\Foundation\Traits\ModelPropertiesTrait;
use Corals\Foundation\Transformers\PresentableTrait;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class SEOItem extends BaseModel implements HasMedia
{
    use PresentableTrait;
    use LogsActivity;
    use InteractsWithMedia ;
    use ModelPropertiesTrait;

    protected $table = 'utilities_seo_items';


    public $mediaCollectionName = 'utility-seo-manager-image';
    /**
     *  Model configuration.
     * @var string
     */
    public $config = 'utility-seo.models.seo_item';

    protected $casts = [
        'properties' => 'json',
    ];

    protected $guarded = ['id'];

    /**
     * @return string
     */
    public function getImageAttribute()
    {
        $media = $this->getFirstMedia($this->mediaCollectionName);

        if ($media) {
            return $media->getFullUrl();
        }

        return null;
    }

    public function getIdentifier($key = null)
    {
        if ($title = $this->attributes['title']) {
            return \Str::limit($title, 50);
        }

        if ($slug = $this->attributes['slug']) {
            return \Str::limit($slug, 50);
        }

        if ($route = $this->attributes['route']) {
            return \Str::limit($route, 50);
        }

        return 'SEO Item';
    }
}
