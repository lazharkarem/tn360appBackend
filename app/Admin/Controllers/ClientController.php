<?php

namespace App\Admin\Controllers;

use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use App\Models\Client;

class ClientController extends AdminController
{
    protected $title = 'Clients';

    protected function grid()
    {
        $grid = new Grid(new Client());
        $grid->model()->latest();

        $grid->column('ID_client', __('ID'));
        $grid->column('email', __('Email'));
        $grid->column('nom_et_prenom', __('Nom et Prénom'));
        $grid->column('civilite', __('Civilité'));
        $grid->column('address', __('Address'));
        $grid->column('date_de_naissance', __('Date de Naissance'));
        $grid->column('statut', __('Statut'));
        $grid->column('code_postal', __('Code Postal'));
        $grid->column('image', __('Image'));
        $grid->column('password', __('Password'));
        $grid->column('profession', __('Profession'));
        $grid->column('situation_familiale', __('Situation Familiale'));
        $grid->column('tel', __('Tel'));
        $grid->column('verification_code', __('Verification Code'));
        $grid->column('ville', __('Ville'));
        $grid->column('gouvernorat', __('Gouvernorat'));
        $grid->column('nom_enfant_1', __('Nom Enfant 1'));
        $grid->column('nom_enfant_2', __('Nom Enfant 2'));
        $grid->column('nom_enfant_3', __('Nom Enfant 3'));
        $grid->column('nom_enfant_4', __('Nom Enfant 4'));
        $grid->column('date_de_naissance1', __('Date de Naissance 1'));
        $grid->column('date_de_naissance2', __('Date de Naissance 2'));
        $grid->column('date_de_naissance3', __('Date de Naissance 3'));
        $grid->column('date_de_naissance4', __('Date de Naissance 4'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));

        return $grid;
    }

    protected function detail($id)
    {
        $show = new Show(Client::findOrFail($id));

        $show->field('ID_client', __('ID'));
        $show->field('email', __('Email'));
        $show->field('nom_et_prenom', __('Nom et Prénom'));
        $show->field('civilite', __('Civilité'));
        $show->field('address', __('Address'));
        $show->field('date_de_naissance', __('Date de Naissance'));
        $show->field('statut', __('Statut'));
        $show->field('code_postal', __('Code Postal'));
        $show->field('image', __('Image'));
        $show->field('password', __('Password'));
        $show->field('profession', __('Profession'));
        $show->field('situation_familiale', __('Situation Familiale'));
        $show->field('tel', __('Tel'));
        $show->field('verification_code', __('Verification Code'));
        $show->field('ville', __('Ville'));
        $show->field('gouvernorat', __('Gouvernorat'));
        $show->field('nom_enfant_1', __('Nom Enfant 1'));
        $show->field('nom_enfant_2', __('Nom Enfant 2'));
        $show->field('nom_enfant_3', __('Nom Enfant 3'));
        $show->field('nom_enfant_4', __('Nom Enfant 4'));
        $show->field('date_de_naissance1', __('Date de Naissance 1'));
        $show->field('date_de_naissance2', __('Date de Naissance 2'));
        $show->field('date_de_naissance3', __('Date de Naissance 3'));
        $show->field('date_de_naissance4', __('Date de Naissance 4'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    protected function form()
    {
        $form = new Form(new Client());

        $form->display('ID_client', __('ID'));
        $form->email('email', __('Email'));
        $form->text('nom_et_prenom', __('Nom et Prénom'));
        $form->text('civilite', __('Civilité'));
        $form->textarea('address', __('Address'));
        $form->date('date_de_naissance', __('Date de Naissance'));
        $form->number('statut', __('Statut'));
        $form->text('code_postal', __('Code Postal'));
        $form->image('image', __('Image'));
        $form->password('password', __('Password'));
        $form->text('profession', __('Profession'));
        $form->text('situation_familiale', __('Situation Familiale'));
        $form->mobile('tel', __('Tel'));
        $form->text('verification_code', __('Verification Code'));
        $form->text('ville', __('Ville'));
        $form->text('gouvernorat', __('Gouvernorat'));
        $form->text('nom_enfant_1', __('Nom Enfant 1'));
        $form->text('nom_enfant_2', __('Nom Enfant 2'));
        $form->text('nom_enfant_3', __('Nom Enfant 3'));
        $form->text('nom_enfant_4', __('Nom Enfant 4'));
        $form->date('date_de_naissance1', __('Date de Naissance 1'));
        $form->date('date_de_naissance2', __('Date de Naissance 2'));
        $form->date('date_de_naissance3', __('Date de Naissance 3'));
        $form->date('date_de_naissance4', __('Date de Naissance 4'));

        return $form;
    }
}
