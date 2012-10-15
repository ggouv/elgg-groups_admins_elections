<?php
/**
 *	Elgg-groups_admins_elections plugin
 *	@package elgg-groups_admins_elections
 *	@author Emmanuel Salomon @ManUtopiK
 *	@license GNU Affero General Public License, version 3 or late
 *	@link https://github.com/ManUtopiK/elgg-groups_admins_elections
 *
 *	Elgg-groups_admins_elections English language
 *
 */

$english = array(

	/*
	 * Menu items and titles
	 */
	'groups_admins_elections:mandat:new' => "Nouveau mandat",
	'groups_admins_elections:mandat:title:new' => "Créer un nouveau mandat pour le groupe %s",
	'groups_admins_elections:mandat' => "Mandat",
	'groups_admins_elections:mandats' => "Mandats",
	'groups_admins_elections:mandat:history' => "Historique",
	'groups_admins_elections:mandat:edit' => "Modifier",
	'groups_admins_elections:mandat:title:edit' => "Modifier le mandat %s",
	'groups_admins_elections:mandats:do_elect' => "Êtes-vous sûr de lancer le tirage au sort maintenant ?",
	
	'groups_admins_elections:candidat:new' => "Se porter candidat",
	'groups_admins_elections:candidat:mine' => "Ma candidature",
	'groups_admins_elections:candidats' => "Candidats",
	'groups_admins_elections:candidats:none' => "Personne ne s'est encore porté candidat. Faites-le !",
	'groups_admins_elections:candidat:title' => "Candidature de %s",
	'groups_admins_elections:candidat:title:new' => "Se porter candidat pour le mandat %s",
	'groups_admins_elections:candidat:intro' => "Vous devez déclarer vos motivations pour votre candidature.",
	'groups_admins_elections:candidat:edit' => "Modifier",
	'groups_admins_elections:candidat:title:edit' => "Modifier la candidature de %s",

	'groups_admins_elections:elected:none' => "Il n'y a pas encore eu de tirage au sort.",
	'groups_admins_elections:elected:date' => "%d/%m/%Y",
	'groups_admins_elections:elected:title' => "Mandataire du %s au %s",
	'groups_admins_elections:elected_now:title' => "Mandataire depuis le %s",
	
	'groups_admins_elections:list:none' => "Il n'y a aucun mandat.",
	
	/*
	 * Objects
	 */
	'groups_admins_elections:mandat:nbr_candidats' => "%s candidats",
	'groups_admins_elections:mandat:created_by' => "Créé par %s",
	'groups_admins_elections:mandat:duration' => "Durée du mandat",
	'groups_admins_elections:mandat:duration:day' => "%s jours",
	'groups_admins_elections:mandat:not_enougth_candidats' => "Pas assez de candidats pour le tirage au sort",
	'groups_admins_elections:mandat:not_elected' => "Pas assez de candidats.<br/>Inscrivez-vous !",
	'groups_admins_elections:mandat:occupy_by' => "Mandataire actuel",
	'groups_admins_elections:mandat:next_election' => "Prochain tirage au sort",
	'groups_admins_elections:mandat:next_election_date' => "%A %e %B %Y",
	'groups_admins_elections:mandat:tiny_next_election_date' => "%d-%m-%y",
	'groups_admins_elections:mandat:until' => "Jusqu'au",
	'groups_admins_elections:mandat:duration:permanent' => "permanent",
	
	'groups_admins_elections:candidat:created_by' => "s'est porté candidat",
	
	'groups_admins_elections:elected:is' => " est ",
	'groups_admins_elections:elected:fromto' => " a été ",
	
	
	/*
	 * Buttons
	 */
	'groups_admins_elections:mandats:add' => "Ajouter un mandat",
	'groups_admins_elections:candidats:add' => "Se porter candidat",
	'groups_admins_elections:mandats:elect' => "Lancer le tirage au sort",
	
	/*
	 * River
	 */
	'river:create:object:mandat' => "%s a crée le mandat %s",
	'river:create:object:candidat' => "%s s'est %s pour le mandat de %s %s",
	'river_be_candidat' => "porté candidat",
	'river:create:object:elected' => "%s %s pour le mandat de %s %s",
	'river_elected' => "a lancé le tirage au sort",
	'river_elected_message' => "%s a été tiré au sort parmi %s candidats !",
	'river_elected_message:first_election' => "Tirage au sort lancé automatiquement pour la première élection.",
	
	/*
	 * Form fields
	 */
	'groups_admins_elections:mandat:form:duration' => "Durée du mandat en jours. Laissez vide ou 0 pour une durée indéterminée.",

	/*
	 * Status and error messages
	 */
	'groups_admins_elections:candidat:save:empty' => "Vous devez expliquer vos motivations",
	'groups_admins_elections:elect:fail' => "Erreur lors du tirage au sort.",
	'groups_admins_elections:elect:success' => "%s a été tiré au sort !",

	/*
	 * Widget
	 */


	/*
	 * Settings
	 */


);

add_translation("en", $english);
