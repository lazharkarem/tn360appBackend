<?php

namespace App\Admin\Controllers;

use App\Models\Marque;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class MarquesController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Marques';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Marque());
        $grid->model()->latest();
        $grid->column('id_marque', __('ID'));
        $grid->column('nom_marque', __('Name'));
        $grid->column('statut', __('Status'))->display(function ($status) {
            return $status ? 'Active' : 'Inactive';
        });
        $grid->column('image', __('Image'))->image('/uploads', 60, 60);
        $grid->column('addresse_marque', __('Address'));
        $grid->column('email_marque', __('Email'));
        $grid->column('tel_marque', __('Phone'));
        $grid->column('created_at', __('Created At'));
        $grid->column('updated_at', __('Updated At'));

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Marque::findOrFail($id));
        $show->field('id_marque', __('ID'));
        $show->field('nom_marque', __('Name'));
        $show->field('statut', __('Status'));
        $show->field('image', __('Image'))->image();
        $show->field('addresse_marque', __('Address'));
        $show->field('email_marque', __('Email'));
        $show->field('tel_marque', __('Phone'));
        $show->field('created_at', __('Created At'));
        $show->field('updated_at', __('Updated At'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Marque());
        $form->text('nom_marque', __('Name'))->required(); // Required field
        $form->switch('statut', __('Status'))->default(1); // Defaults to active
        $form->image('image', __('Image'))->uniqueName(); // Optional image
        $form->text('addresse_marque', __('Address')); // Optional text field
        $form->email('email_marque', __('Email'))->required(); // Required email
        $form->mobile('tel_marque', __('Phone')); // Optional mobile field

        return $form;
    }

}
