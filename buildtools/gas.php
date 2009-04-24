#!/usr/bin/php
<?php
require_once (dirname(__FILE__) . '/../include/Site.php');

function menu() {
	echo "\n";
	echo str_repeat('-', 80) . "\n";
	echo "App Path: " . realpath(dirname(__FILE__) . '/../') . "\n";
	echo str_repeat('-', 80) . "\n";
	echo '[M]odule Generation' . "\n";
	echo '[C]lear Caches' . "\n";
	echo '[Q]uit' . "\n";
	echo "\n";
	return strtoupper(trim(fgets(STDIN)));
}

function gen_module() {
	echo 'What is the module name? ';
	$module_name = trim(fgets(STDIN));
	if (Config::singleton()->getIsModuleActive($module_name)) {
		echo 'Module already exists!' . "\n";
		return gen_module();	
	}
	$workdir = SITE_ROOT . '/modules/' . $module_name;
	mkdir($workdir);
	mkdir($workdir . '/css');
	mkdir($workdir . '/templates');
	mkdir($workdir . '/js');
	mkdir($workdir . '/include');
}

function clearcaches() {
	include_once dirname(__FILE__) . '/install/clearcaches.php';
	clearCacheDirectories();
	echo 'Cache cleared!' . "\n";
}

while(true) {
	$r = menu();
	switch ($r) {
		case 'Q':
			die();
			break;
		case 'C';
			clearcaches();
			break;
		case 'M':
			gen_module();
			break;
	}
}
