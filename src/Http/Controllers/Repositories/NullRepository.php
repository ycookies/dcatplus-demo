<?php

namespace Dcat\Admin\DcatplusDemo\Http\Controllers\Repositories;

use Dcat\Admin\Form;
use Dcat\Admin\Repositories\Repository;

class NullRepository extends Repository
{
    public function store(Form $form)
    {
        return true;
    }
}
