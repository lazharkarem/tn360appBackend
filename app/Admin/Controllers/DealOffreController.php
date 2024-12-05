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
        $grid->column('statut', __('Statut'));
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

        // Populate the client options with Client names and IDs
        $clients = Client::all()->pluck('nom_et_prenom', 'ID_client');
        $options = [];
        foreach ($clients as $clientId => $nom_et_prenom) {
            $options[$clientId] = $clientId . ' - ' . $nom_et_prenom;
        }

        // Ensure the ID_client field is required
        $form->select('ID_client', __('Client'))->options($options)->required();
        $form->date('date_debut', __('Date Debut'))->required();
        $form->date('date_fin', __('Date Fin'))->required();
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

        // After saving the DealOffre, redirect to the appropriate DealDepense page based on type_offre.
        $form->saving(function (Form $form) {
            // Validate that ID_client is set before saving the DealOffre
            if (empty($form->ID_client)) {
                return redirect()->back()->withErrors(['ID_client' => 'Client is required.']);
            }
        });

        // Redirect to the appropriate DealDepense creation page based on the type_offre
        $form->saved(function (Form $form) {
            $dealOffre = $form->model(); // Get the created DealOffre instance

            // Dynamically choose the redirect route based on type_offre
            $typeOffre = $dealOffre->type_offre;

            switch ($typeOffre) {
                case 'deal_depense':
                    return redirect()->route('admin.deal-depense.create', [
                        'ID_client' => $dealOffre->ID_client, // Pass Client ID to DealDepense form
                        'ID_deal_offre' => $dealOffre->ID_deal_offre, // Pass DealOffre ID to DealDepense form
                    ]);
                case 'deal_frequence':
                    return redirect()->route('admin.deal-frequence.create', [
                        'ID_client' => $dealOffre->ID_client, 
                        'ID_deal_offre' => $dealOffre->ID_deal_offre,
                    ]);
                case 'deal_marque':
                    return redirect()->route('admin.deal-marque.create', [
                        'ID_client' => $dealOffre->ID_client, 
                        'ID_deal_offre' => $dealOffre->ID_deal_offre,
                    ]);
                case 'deal_diver':
                    return redirect()->route('admin.deal-diver.create', [
                        'ID_client' => $dealOffre->ID_client, 
                        'ID_deal_offre' => $dealOffre->ID_deal_offre,
                    ]);
                case 'deal_anniversaire':
                    return redirect()->route('admin.deal-anniversaire.create', [
                        'ID_client' => $dealOffre->ID_client, 
                        'ID_deal_offre' => $dealOffre->ID_deal_offre,
                    ]);
                default:
                    // Fallback if no type is matched
                    return redirect()->route('admin.deal-offre.index');
            }
        });

        return $form;
    }
}
