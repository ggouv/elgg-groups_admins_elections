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
	'groups_admins_elections:mandats:all' => "Tous les mandats",
	'groups_admins_elections:mandat:history' => "Historique",
	'groups_admins_elections:mandat:edit' => "Modifier",
	'groups_admins_elections:mandat:title:edit' => "Modifier le mandat %s",
	'groups_admins_elections:mandats:do_elect' => "Êtes-vous sûr de lancer le tirage au sort maintenant ?",

	'groups_admins_elections:candidat:new' => "Se porter candidat",
	'groups_admins_elections:candidat:mine' => "Ma candidature",
	'groups_admins_elections:candidats' => "Candidats",
	'groups_admins_elections:candidats:none' => "Pas de candidat. Et vous ?",
	'groups_admins_elections:candidat:title' => "Candidature de %s",
	'groups_admins_elections:candidat:title:new' => "Se porter candidat pour le mandat %s",
	'groups_admins_elections:candidat:intro' => "Vous devez déclarer vos motivations pour votre candidature.",
	'groups_admins_elections:candidat:edit' => "Modifier",
	'groups_admins_elections:candidat:title:edit' => "Modifier la candidature de %s",

	'groups_admins_elections:elected:none' => "Il n'y a pas encore eu de mandataire.",
	'groups_admins_elections:elected:date' => "%d/%m/%Y",
	'groups_admins_elections:elected:title' => "Mandataire du %s au %s",
	'groups_admins_elections:elected_now:title' => "Mandataire depuis le %s",

	'groups_admins_elections:list:none' => "Il n'y a aucun mandat.",

	/*
	 * Objects
	 */
	'groups_admins_elections:mandat:nbr_candidats' => "%s candidats",
	'groups_admins_elections:mandat:no_candidat' => "Pas de candidats",
	'groups_admins_elections:mandat:created_by' => "Créé par %s",
	'groups_admins_elections:mandat:duration' => "Durée du mandat",
	'groups_admins_elections:mandat:duration:day' => "%s jours",
	'groups_admins_elections:mandat:not_enougth_candidats' => "Pas assez de candidats pour le tirage au sort",
	'groups_admins_elections:mandat:want_candidate' => "Inscrivez-vous !",
	'groups_admins_elections:mandat:occupy_by' => "Mandataire actuel",
	'groups_admins_elections:mandat:next_election' => "Prochain tirage au sort",
	'groups_admins_elections:mandat:next_election_date' => "%A %e %B %Y",
	'groups_admins_elections:mandat:tiny_next_election_date' => "%d-%m-%y",
	'groups_admins_elections:mandat:until' => "Jusqu'au",
	'groups_admins_elections:mandat:duration:permanent' => "durée indéterminée",

	'groups_admins_elections:candidat:created_by' => "s'est porté candidat",

	'groups_admins_elections:elected:is' => " est ",
	'groups_admins_elections:elected:fromto' => " a été ",

	'groups_admins_elections:selected' => " par @%s.<br/>",


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
	'river_elected:random' => "a lancé le tirage au sort",
	'river_elected:selected' => "a désigné %s",
	'river_elected_message:random' => "@%s a été tiré au sort parmi %s candidats !",
	'river_elected_message:selected' => "@%s a été désigné d'office",
	'river:comment:object:mandat' => "%s a commenté le mandat %s",
	'river:comment:object:candidat' => "%s a commenté la candidature de %s",
	'river:comment:object:elected' => "%s a commenté la mandature de %s",

	/*
	 * Form fields
	 */
	'groups_admins_elections:mandat:form:duration' => "Durée du mandat en jours. Laissez vide ou 0 pour une durée indéterminée",
	'groups_admins_elections:mandat:form:userpicker' => "Optionnel ! Mandater d'office quelqu'un, cela remplacera le mandataire actuel",

	/*
	 * Status and error messages
	 */
	'groups_admins_elections:mandat:save:success' => "Le mandat a été enregistré.",
	'groups_admins_elections:candidat:save:empty' => "Vous devez expliquer vos motivations !",
	'groups_admins_elections:elect:fail' => "Erreur lors du tirage au sort.",
	'groups_admins_elections:elect:success' => "%s a été tiré au sort !",
	'groups_admins_elections:mandat:save:selected_user' => "Vous avez mandaté %s.",
	'groups_admins_elections:mandat:save:selected_user:error' => "Vous ne pouvez pas mandater %s. Il doit d'abord déposer sa candidature.",

	/*
	 * Widget
	 */


	/*
	 * Settings
	 */
	'groups_admins_elections:mandat:default:description' => "Description par défaut des nouveaux mandats :",

);

add_translation("en", $english);
