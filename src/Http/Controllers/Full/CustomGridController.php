<?php

namespace Dcat\Admin\DcatplusDemo\Http\Controllers\Full;

use Dcat\Admin\DcatplusDemo\Http\Controllers\Actions\Grid\SwitchGridView;
use Dcat\Admin\DcatplusDemo\Http\Controllers\Repositories\Image;
use Dcat\Admin\Grid;
use Dcat\Admin\Layout\Content;

class CustomGridController
{
    use PreviewCode;

    public function index(Content $content)
    {
        return $content
            ->title('自定义视图')
            ->description('Grid View')
            ->body($this->grid());
    }

    protected function grid()
    {
        return Grid::make(new Image(), function (Grid $grid) {
            if (request()->get('_view_') !== 'list') {
                // 设置自定义视图
                $grid->view('ycookies.dcatplus-demo::grid.custom');

                $grid->setActionClass(Grid\Displayers\Actions::class);
            }

            $grid->tools([
                $this->buildPreviewButton('btn-primary'),
                new SwitchGridView(),
            ]);

            $grid->disableCreateButton();

            $grid->column('id', __('ID'));

            $grid->column('name');
            $grid->column('url')->image();
            $grid->column('comment');
            $grid->column('created_at');
            $grid->column('updated_at');
        });
    }
}
