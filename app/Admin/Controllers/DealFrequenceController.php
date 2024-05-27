<?php

namespace App\Admin\Controllers;

use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use App\Models\DealFrequence;
use App\Models\Client;

class DealFrequenceController extends AdminController
{
    protected $title = 'Deal Frequence';

    protected function grid()
    {
        $grid = new Grid(new DealFrequence());
        $grid->model()->latest();

        $grid->column('ID_deal_frequence', __('ID'));
          $grid->column('ID_client', __('Client'))->display(function ($clientId) {
            $client = Client::find($clientId);
            return $client ? $client->nom_et_prenom : 'Unknown Client'; // Check if client is found
        });
        $grid->column('segments', __('Segments'));
        $grid->column('objectif_frequence', __('Objectif Frequence'));
        $grid->column('compteur_frequence', __('Compteur Frequence'));
        $grid->column('gain', __('Gain'));
        $grid->column('commande_1', __('Commande 1'));
        $grid->column('commande_2', __('Commande 2'));
        $grid->column('commande_3', __('Commande 3'));
        $grid->column('commande_4', __('Commande 4'));
        $grid->column('commande_5', __('Commande 5'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));

        return $grid;
    }

    protected function detail($id)
    {
        $show = new Show(DealFrequence::findOrFail($id));

        $show->field('ID_deal_frequence', __('ID'));
        $show->field('clients', __('Clients'))->as(function ($clients) {
            return $clients->pluck('nom_et_prenom')->join(', ');
        });
        $show->field('segments', __('Segments'));
        $show->field('objectif_frequence', __('Objectif Frequence'));
        $show->field('compteur_frequence', __('Compteur Frequence'));
        $show->field('gain', __('Gain'));
        $show->field('commande_1', __('Commande 1'));
        $show->field('commande_2', __('Commande 2'));
        $show->field('commande_3', __('Commande 3'));
        $show->field('commande_4', __('Commande 4'));
        $show->field('commande_5', __('Commande 5'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    protected function form()
    {
        $form = new Form(new DealFrequence());

        $form->multipleSelect('clients', __('Clients'))->options(Client::all()->pluck('nom_et_prenom', 'ID_client'));
        $form->text('segments', __('Segments'));
        $form->number('objectif_frequence', __('Objectif Frequence'));
        $form->number('compteur_frequence', __('Compteur Frequence'));
        $form->number('gain', __('Gain'));
        $form->number('commande_1', __('Commande 1'));
        $form->number('commande_2', __('Commande 2'));
        $form->number('commande_3', __('Commande 3'));
        $form->number('commande_4', __('Commande 4'));
        $form->number('commande_5', __('Commande 5'));

        return $form;
    }
}
