<?php

namespace Modules\Seo\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Seo\Repositories\SeoRuleRepository;

class SeoRuleController extends Controller
{
    public function __construct(
        protected SeoRuleRepository $seoRuleRepository
    ) {}

    public function index()
    {

    }

    public function show(int $seo_rule)
    {

    }
}
