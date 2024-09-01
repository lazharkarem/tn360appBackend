<?php


namespace App\Admin\Controllers;

use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use App\Models\DealDepense;
use App\Models\Client;
use Encore\Admin\Layout\Content;

class DealDepenseController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Deal Depense';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new DealDepense());
        $grid->model()->latest();

        $grid->column('ID_deal_depense', __('ID'));
        $grid->column('ID_client', __('Client'))->display(function ($clientId) {
            $client = Client::find($clientId);
            return $client ? $client->nom_et_prenom : 'Unknown Client'; // Check if client is found
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

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(DealDepense::findOrFail($id));

        $show->field('ID_deal_depense', __('ID'));
        $show->field('ID_client', __('Client'))->as(function ($clientId) {
            $client = Client::find($clientId);
            return $client ? $client->nom_et_prenom : 'Unknown Client'; // Check if client is found
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

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new DealDepense());

        $clients = Client::all()->pluck('nom_et_prenom', 'ID_client');
        $options = [];
        foreach ($clients as $clientId => $nom_et_prenom) {
        $options[$clientId] = $clientId . ' - ' . $nom_et_prenom;
        }
        $form->select('ID_client', __('Client'))->options($options);


        $form->text('segments', __('Segments'));
        $form->decimal('objectif_1', __('Objectif 1'));
        $form->decimal('objectif_2', __('Objectif 2'));
        $form->decimal('objectif_3', __('Objectif 3'));
        $form->decimal('objectif_4', __('Objectif 4'));
        $form->decimal('objectif_5', __('Objectif 5'));
        $form->decimal('gain_objectif_1', __('Gain Objectif 1'));
        $form->decimal('gain_objectif_2', __('Gain Objectif 2'));
        $form->decimal('gain_objectif_3', __('Gain Objectif 3'));
        $form->decimal('gain_objectif_4', __('Gain Objectif 4'));
        $form->decimal('gain_objectif_5', __('Gain Objectif 5'));
        $form->decimal('compteur_objectif', __('Compteur Objectif'));

        return $form;
    }

    /**
     * Display a list of clients.
     *
     * @return Grid
     */
    protected function clientsGrid()
    {
        $grid = new Grid(new Client());
        $grid->model()->latest();

        $grid->column('ID_client', __('ID'));
        $grid->column('nom_et_prenom', __('Name'));
        $grid->column('email', __('Email'));
        $grid->column('tel', __('Telephone'));
        $grid->column('ville', __('City'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));

        return $grid;
    }
}
