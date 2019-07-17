<?php

namespace Finder;

use Finder\ObjectFinder\FindService;

return [
    'default_finder_algorithm' => FindService\TwoPointsFinder::class,
];

