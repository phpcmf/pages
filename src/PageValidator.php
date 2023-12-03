<?php

namespace Cmf\Pages;

use Cmf\Foundation\AbstractValidator;

class PageValidator extends AbstractValidator
{
    /**
     * {@inheritdoc}
     */
    protected $rules = [
        'title' => [
            'required',
            'max:200',
        ],
        'slug' => [
            'required',
            'unique:pages,slug',
            'max:200',
        ],
        'content' => [
            'required',
            'max:16777215',
        ],
    ];
}
