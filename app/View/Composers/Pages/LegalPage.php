<?php

namespace App\View\Composers\Pages;

use App\View\Composers\SSM;

class LegalPage extends SSM
{

    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        'template-legal-page',
    ];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {

        $data = collect($this->fields())->toArray();

        return [
            'legal_editor'      => $data['legal_editor']
        ];
    }
}