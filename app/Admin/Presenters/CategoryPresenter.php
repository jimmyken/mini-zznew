<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/9/009
 * Time: 11:54
 */
namespace App\Admin\Presenters;

class CategoryPresenter
{
    public function showLabel($category)
    {
        return '<span class="badge bg-green">' . $category->label . '</span>';
    }

}