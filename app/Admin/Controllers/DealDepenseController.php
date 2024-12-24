<?php

namespace App\Admin\Controllers;

use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use App\Models\DealDepense;
use App\Models\Client;
use App\Models\DealOffre; // Import the DealOffre model
use Encore\Admin\Layout\Content;

class DealDepenseController extends AdminController
{
    protected $title = 'Deal Depense';

    // Display the grid/list of Deal Depense records
    protected function grid()
    {
        $grid = new Grid(new DealDepense());
        $grid->model()->latest();

        $grid->column('ID_deal_depense', __('ID'));
        $grid->column('ID_client', __('Client'))->display(function ($clientId) {
            $client = Client::find($clientId);
            return $client ? $client->nom_et_prenom : 'Unknown Client';
        });
        $grid->column('segments', __('Segments'));
        $grid->column('objectif_1', __('Objectif 1'));
        $grid->column('objectif_2', __('Objectif 2'));
        $grid->column('objectif_3', __('Objectif 3'));
        $grid->column('objectif_4', __('Objectif 4'));
        $grid->column('objectif_5', __('Objectif 5'));
        $grid->column('gain_objectif_1', __('Gain Objectif 1'));
        $grid->column('gain_objectif_2', __('Gain Objectif 2'));
        $grid->column('gain_objectif_3', __('Gain Objectif 3'));
        $grid->column('gain_objectif_4', __('Gain Objectif 4'));
        $grid->column('gain_objectif_5', __('Gain Objectif 5'));
        $grid->column('compteur_objectif', __('Compteur Objectif'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));

        return $grid;
    }

    // Display the detailed view of a single Deal Depense record
    protected function detail($id)
    {
        $show = new Show(DealDepense::findOrFail($id));

        $show->field('ID_deal_depense', __('ID'));
        $show->field('ID_client', __('Client'))->as(function ($clientId) {
            $client = Client::find($clientId);
            return $client ? $client->nom_et_prenom : 'Unknown Client';
        });
        $show->field('segments', __('Segments'));
        $show->field('objectif_1', __('Objectif 1'));
        $show->field('objectif_2', __('Objectif 2'));
        $show->field('objectif_3', __('Objectif 3'));
        $show->field('objectif_4', __('Objectif 4'));
        $show->field('objectif_5', __('Objectif 5'));
        $show->field('gain_objectif_1', __('Gain Objectif 1'));
        $show->field('gain_objectif_2', __('Gain Objectif 2'));
        $show->field('gain_objectif_3', __('Gain Objectif 3'));
        $show->field('gain_objectif_4', __('Gain Objectif 4'));
        $show->field('gain_objectif_5', __('Gain Objectif 5'));
        $show->field('compteur_objectif', __('Compteur Objectif'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    // Form for creating or editing a Deal Depense record
// DealDepenseController.php

    public function form()
{
    $form = new Form(new DealDepense());

    // Retrieve IDs from the request
    $clientId = request('ID_client');
    $dealOffreId = request('ID_deal_offre'); 

    // Pre-fill the client field if the client ID is provided
    if ($clientId) {
        $client = Client::find($clientId);
        if ($client) {
            $form->select('ID_client', __('Client'))
                ->options([$clientId => $client->nom_et_prenom])
                ->default($clientId)
                ->readonly();
        }
    } else {
        $form->select('ID_client', __('Client'))
            ->options(Client::all()->pluck('nom_et_prenom', 'ID_client'))
            ->required();
    }

    // Hidden field for `ID_deal_offre` if passed
    if ($dealOffreId) {
        $form->hidden('ID_deal_offre')->value($dealOffreId);
    }

    // Other fields for `deal_depense`
    $form->text('segments', __('Segments'))->required();
    $form->decimal('objectif_1', __('Objectif 1'))->rules('numeric|min:0');
    $form->decimal('objectif_2', __('Objectif 2'))->rules('numeric|min:0');
    $form->decimal('objectif_3', __('Objectif 3'))->rules('numeric|min:0');
    $form->decimal('objectif_4', __('Objectif 4'))->rules('numeric|min:0');
    $form->decimal('objectif_5', __('Objectif 5'))->rules('numeric|min:0');

    $form->decimal('gain_objectif_1', __('Gain Objectif 1'))->rules('numeric|min:0');
    $form->decimal('gain_objectif_2', __('Gain Objectif 2'))->rules('numeric|min:0');
    $form->decimal('gain_objectif_3', __('Gain Objectif 3'))->rules('numeric|min:0');
    $form->decimal('gain_objectif_4', __('Gain Objectif 4'))->rules('numeric|min:0');
    $form->decimal('gain_objectif_5', __('Gain Objectif 5'))->rules('numeric|min:0');

    $form->decimal('compteur_objectif', __('Compteur Objectif'))->rules('numeric|min:0');

    // Automatically set `ID_deal_offre` during saving
    $form->saving(function (Form $form) use ($dealOffreId) {
        if ($dealOffreId && !$form->model()->ID_deal_offre) {
            $form->model()->ID_deal_offre = $dealOffreId;
        }
    });

    return $form;
}



}
