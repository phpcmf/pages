<?php

use Cmf\Database\Migration;

return Migration::addColumns('pages', [
    'is_restricted' => ['boolean', 'default' => 0],
]);
