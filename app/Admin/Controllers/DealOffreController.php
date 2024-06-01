<?php

namespace App\Admin\Controllers;

use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use App\Models\DealOffre;
use App\Models\Client;

use Encore\Admin\Layout\Content;

class DealOffreController extends AdminController
{
    protected $title = 'Deal Offre';

    protected function grid()
    {
        $grid = new Grid(new DealOffre());
        $grid->model()->latest();

        $grid->column('ID_deal_offre', __('ID'));
        $grid->column('ID_client', __('Client'))->display(function ($clientId) {
            $client = Client::find($clientId);
            return $client ? $client->nom_et_prenom : 'Unknown Client';
        });
        $grid->column('date_debut', __('Date Debut'));
        $grid->column('date_fin', __('Date Fin'));
        $grid->column('canal', __('Canal'));
        $grid->column('statut', __('Statut')); // Access the associated statut
        $grid->column('type_offre', __('Type Offre'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));

        return $grid;
    }

    protected function detail($id)
    {
        $show = new Show(DealOffre::with('statut')->findOrFail($id));

        $show->field('ID_deal_offre', __('ID'));
        $show->field('ID_client', __('Client'))->as(function ($clientId) {
            $client = Client::find($clientId);
            return $client ? $client->nom_et_prenom : 'Unknown Client';
        });
        $show->field('date_debut', __('Date Debut'));
        $show->field('date_fin', __('Date Fin'));
        $show->field('canal', __('Canal'));
        $show->field('statut', __('Statut'));
        $show->field('type_offre', __('Type Offre'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }


    protected function form()
    {
        $form = new Form(new DealOffre());

        $clients = Client::all()->pluck('nom_et_prenom', 'ID_client');
        $options = [];
        foreach ($clients as $clientId => $nom_et_prenom) {
        $options[$clientId] = $clientId . ' - ' . $nom_et_prenom;
        }
        $form->select('ID_client', __('Client'))->options($options);
        $form->date('date_debut', __('Date Debut'));
        $form->date('date_fin', __('Date Fin'));
        $form->select('canal', __('Canal'))->options([
            'site_web' => 'Site Web',
            'mobile' => 'Mobile',
            'magasin' => 'Magasin',
            'list_magasins' => 'Liste des Magasins',
            'enseigne' => 'Enseigne',
        ]);
        $form->select('statut', __('Statut'))->options([
            'en_cours' => 'En Cours',
            'cloturee' => 'Cloturée',
            'suspendu' => 'Suspendu',
        ]);

        $form->select('type_offre', __('Type Offre'))->options([
            'deal_depense' => 'Deal Dépense',
            'deal_marque' => 'Deal Marque',
            'deal_diver' => 'Deal Divers',
            'deal_frequence' => 'Deal Fréquence',
            'deal_anniversaire' => 'Deal Anniversaire',
        ]);

        return $form;
    }
}
