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
            return $client ? $client->nom_et_prenom : 'Unknown Client';
        });
        $grid->column('segments', __('Segments'));
        $grid->column('panier_moyen', __('Panier Moyen'));
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
        $show->field('ID_client', __('Client'))->as(function ($clientId) {
            $client = Client::find($clientId);
            return $client ? $client->nom_et_prenom : 'Unknown Client';
        });
        $show->field('segments', __('Segments'));
        $show->field('panier_moyen', __('Panier Moyen'));
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


    $clients = Client::all()->pluck('nom_et_prenom', 'ID_client');
    $options = [];
    foreach ($clients as $clientId => $nom_et_prenom) {
        $options[$clientId] = $clientId . ' - ' . $nom_et_prenom;
    }
    $form->select('ID_client', __('Client'))->options($options);

    $form->text('segments', __('Segments'));
    $form->decimal('panier_moyen', __('Panier Moyen'))->rules('required');
    $form->decimal('objectif_frequence', __('Objectif Frequence'));
    $form->decimal('compteur_frequence', __('Compteur Frequence'));
    $form->decimal('gain', __('Gain'));
    $form->decimal('commande_1', __('Commande 1'));
    $form->decimal('commande_2', __('Commande 2'));
    $form->decimal('commande_3', __('Commande 3'));
    $form->decimal('commande_4', __('Commande 4'));
    $form->decimal('commande_5', __('Commande 5'));

    return $form;
}

}
