<?php

/**
 * Editme
 *
 * @author jan@kristinus.de
 *
 * @package redaxo4
 * @version svn:$Id$
 */

if($REX["REDAXO"])
{

	// Sprachdateien anhaengen
	$I18N->appendFile($REX['INCLUDE_PATH'].'/addons/editme/lang/');


	// $REX['ADDON']['rxid']["editme"] = '';
	// $REX['ADDON']['page']["editme"] = "editme";
	$REX['ADDON']['name']["editme"] = $I18N->msg("editme");
	

	// Credits
	$REX['ADDON']['version']["editme"] = '0.5';
	$REX['ADDON']['author']["editme"] = 'Jan Kristinus';
	$REX['ADDON']['supportpage']["editme"] = 'forum.redaxo.de';

	// *************
	// $REX['PERM'][] = 'em[1]';
	// $REX['PERM'][] = 'em[2]';

	// Fuer Benutzervewaltung
	// $REX['EXTPERM'][] = 'em[]';

	// Linke Navigation

	include $REX['INCLUDE_PATH'].'/addons/editme/functions/functions.inc.php';
	
	$REX['ADDON']['editme']['SUBPAGES'] = array();
	
	if ($REX['USER'] && ($REX['USER']->isAdmin()))
  		$REX['ADDON']['editme']['SUBPAGES'][] = array( '' , $I18N->msg("em_overview"));
	
  $tables = rex_em_getTables();
  foreach($tables as $table)
  {
  	
		// Recht um das AddOn ueberhaupt einsehen zu koennen
		$table_perm = 'em['.$table["label"].']';
		$REX['EXTPERM'][] = $table_perm;
		
  	if($table["status"] == 1)
  	{
  		if ($REX['USER'] && ($REX['USER']->isAdmin() || $REX['USER']->isValueOf("rights",$table_perm)) )
  			$REX['ADDON']['editme']['SUBPAGES'][] = array( $table["label"] , $table["name"]);
  	}
  }
  
}