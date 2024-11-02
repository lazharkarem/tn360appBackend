<?php

namespace App\Admin\Controllers;

use App\Models\Banner; // Ensure this is the correct model name
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class BannerController extends AdminController
{
    protected $title = 'Banners';

    protected function grid()
    {
        $grid = new Grid(new Banner()); // Use the correct model name
        $grid->model()->latest(); // Order by the latest entries

        $grid->column('ID_banner', __('ID'));
        $grid->column('title', __('Title'));
        $grid->column('description', __('Description'));
        $grid->column('image_path', __('Image Path'))->image('', 60, 60); // Display thumbnail
        $grid->column('type', __('Type'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));

        return $grid;
    }

    protected function detail($id)
    {
        $show = new Show(Banner::findOrFail($id)); // Use the correct model name

        $show->field('ID_banner', __('ID'));
        $show->field('title', __('Title'));
        $show->field('description', __('Description'));
        $show->field('image_path', __('Image Path'))->image(); // Show full image
        $show->field('type', __('Type'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    protected function form()
    {
        $form = new Form(new Banner()); // Use the correct model name

        // Form fields
        $form->text('title', __('Title')); // Title field
        $form->textarea('description', __('Description')); // Description field
        $form->image('image_path', __('Thumbnail'))->uniqueName();
        //  $form->image('image_path', __('Image Path'))
        //     ->uniqueName()
        //     ->move('banners') // Specify the folder where you want to store images
        //     ->removable()
        //     ->help('Upload a single image.'); // Allow single file upload
        $form->select('type', __('Type'))->options([
            'banner_type_1' => 'Deals personnalisés',
            'banner_type_2' => 'Catalogues promotionnels',
            'banner_type_3' => 'Jeux',
            'banner_type_4' => 'Autre',
        ]); // Type field 

        return $form;
    }

    // Ensure the update method signature matches the base class
    public function update($id)
    {
        $request = request(); // Get the request instance
        $banner = Banner::findOrFail($id);

        // Handle single file upload
        if ($request->hasFile('image_path')) {
            $image = $request->file('image_path');
            $path = $image->store('banners', 'public'); // Store the image in the 'banners' directory
            $banner->image_path = $path; // Store the path for the banner
        }

        $banner->title = $request->input('title');
        $banner->description = $request->input('description');
        $banner->type = $request->input('type');

        $banner->save();

        return redirect()->route('admin.banners.index')->with('success', 'Banner updated successfully.');
    }
}
