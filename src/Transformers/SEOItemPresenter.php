<?php

namespace Corals\Modules\Utility\SEO\Transformers;

use Corals\Foundation\Transformers\FractalPresenter;

class SEOItemPresenter extends FractalPresenter
{
    /**
     * @param array $extras
     * @return SEOItemTransformer|\League\Fractal\TransformerAbstract
     */
    public function getTransformer($extras = [])
    {
        return new SEOItemTransformer($extras);
    }
}
