<?php

namespace App\Admin\Controllers;

use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use App\Models\DealMarque; // Updated model name
use App\Models\Client;

class DealMarqueController extends AdminController // Updated class name
{
    protected $title = 'Deal Marque'; // Updated title

    protected function grid()
    {
        $grid = new Grid(new DealMarque()); // Updated model name
        $grid->model()->latest();

        $grid->column('ID_deal_marque', __('ID')); // Updated column name
          $grid->column('ID_client', __('Client'))->display(function ($clientId) {
            $client = Client::find($clientId);
            return $client ? $client->nom_et_prenom : 'Unknown Client'; // Check if client is found
        });
        $grid->column('segments', __('Segments'));
        $grid->column('objectif_1', __('Objectif 1')); // Updated column name
        $grid->column('objectif_2', __('Objectif 2')); // Updated column name
        $grid->column('objectif_3', __('Objectif 3')); // Updated column name
        $grid->column('gain_objectif_1', __('Gain Objectif 1')); // Updated column name
        $grid->column('gain_objectif_2', __('Gain Objectif 2')); // Updated column name
        $grid->column('gain_objectif_3', __('Gain Objectif 3')); // Updated column name
        $grid->column('compteur_objectif', __('Compteur Objectif'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));

        return $grid;
    }

    protected function detail($id)
    {
        $show = new Show(DealMarque::findOrFail($id)); // Updated model name

        $show->field('ID_deal_marque', __('ID')); // Updated field name
        $show->field('ID_client', __('Client'))->as(function ($clientId) {
            $client = Client::find($clientId);
            return $client ? $client->nom_et_prenom : 'Unknown Client';
        });
        $show->field('segments', __('Segments'));
        $show->field('objectif_1', __('Objectif 1')); // Updated field name
        $show->field('objectif_2', __('Objectif 2')); // Updated field name
        $show->field('objectif_3', __('Objectif 3')); // Updated field name
        $show->field('gain_objectif_1', __('Gain Objectif 1')); // Updated field name
        $show->field('gain_objectif_2', __('Gain Objectif 2')); // Updated field name
        $show->field('gain_objectif_3', __('Gain Objectif 3')); // Updated field name
        $show->field('compteur_objectif', __('Compteur Objectif'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    protected function form()
    {
        $form = new Form(new DealMarque()); // Updated model name

        $form->select('ID_client', __('Client'))->options(Client::all()->pluck('nom_et_prenom', 'ID_client'));
        $form->text('segments', __('Segments'));
        $form->number('objectif_1', __('Objectif 1')); // Updated field name
        $form->number('objectif_2', __('Objectif 2')); // Updated field name
        $form->number('objectif_3', __('Objectif 3')); // Updated field name
        $form->number('gain_objectif_1', __('Gain Objectif 1')); // Updated field name
        $form->number('gain_objectif_2', __('Gain Objectif 2')); // Updated field name
        $form->number('gain_objectif_3', __('Gain Objectif 3')); // Updated field name
        $form->number('compteur_objectif', __('Compteur Objectif'));

        return $form;
    }
}
