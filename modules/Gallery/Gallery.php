<?php
/**
 *  This file is part of Dashboard.
 *
 *  Dashboard is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  Dashboard is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with Dashboard.  If not, see <http://www.gnu.org/licenses/>.
 *  
 *  @license http://www.gnu.org/licenses/gpl.txt
 *  @copyright Copyright 2007-2009 Norex Core Web Development
 *  @author See CREDITS file
 *
 */

class Module_Gallery extends Module {
	public function __construct() {
		$this->page = new Page();
		$this->page->with('PhotoGallery')
			->show(array(
				'Name' => 'name',
				'Active' => 'status',
			))
			->name('Photo Gallery')
			->on('addedit')->noAJAX()->action('PhotoGalleryImage');
			
			
		$this->page->with('PhotoGalleryImage')
			->show(array(
				'Image' => array('id', array('PhotoGalleryImage', 'getThumb')),
				'Title' => 'title',
			))
			->name('Photo Gallery Image')
			->link(array('photo_gallery_id', array('PhotoGallery', 'id')));
			
		$this->page->with('PhotoGallery');
	}
	
	public function getAdminInterface() {
		
		if (class_exists('ZipArchive') && @$_REQUEST['section'] == 'PhotoGallery') {
			$itm = DBRow::make($_REQUEST[call_user_func(array($this->page->pointer, 'quickFormPrefix')) . 'id'], $this->page->pointer);
			$this->smarty->assign('item', $itm);
			$this->page->with('PhotoGalleryImage')
				->pre($this->smarty->fetch('bulkupload.htpl'));
			$this->page->with('PhotoGallery');
			
			if (isset($_REQUEST['bulk_submit']) && isset($_FILES['zip_file']) && $_FILES['zip_file']['error'] == 0) {
				$zip = new ZipArchive();
				
				if ($zip->open($_FILES['zip_file']['tmp_name'])!==TRUE) {
   		 			exit("cannot open <$filename>\n");
				}
				
				
				for ($i=0; $i<$zip->numFiles;$i++) {
					set_time_limit(30);
					$f = ($zip->statIndex($i));
					$fp = $zip->getStream($f['name']);
					
					$tmpfname = tempnam("/tmp", "gallery_image");

					$temp = fopen($tmpfname, "w+");
					
					while (!feof($fp)) {
        				fwrite($temp, fread($fp, 2));
    				}
    				fseek($temp, 0);
    				
    				if ($a = @getimagesize($tmpfname)) {
    					if ($a['mime'] == 'image/jpeg' || 
    						$a['mime'] == 'image/png' ||
    						$a['mime'] == 'image/gif' ||
    						$a['mime'] == 'image/pjpeg' ||
    						$a['mime'] == 'image/wbmp') {
    						
    						$newFile = DBRow::make(null, 'File');
    						$newFile->insert($tmpfname,'image/jpeg',$f['name']);
    						$newFile->set('description', $f['name']);
    						$newFile->save();
    						
    						$pgi = DBRow::make(null, 'PhotoGalleryImage');
    						$pgi->set('title', $f['name']);
    						$pgi->set('file_id', $newFile->get('id'));
    						$pgi->set('photo_gallery_id', $itm->get('id'));
    						$pgi->save();
    					}
    				}
    				
    				fclose($temp);
    				fclose($fp);
				}
			}
			
		}
		
		return $this->page->render();
	}
	
	public function getUserInterface($params = null) {
		$this->addJS('/modules/Gallery/js/lightbox.js');
		$this->addCSS('/modules/Gallery/css/lightbox.css');
		$this->addCSS('/modules/Gallery/css/gallery.css');
		
		$this->setPageTitle('Photo Gallery');
		
		if (isset($_REQUEST['page']) && is_numeric($_REQUEST['page'])) {
			$gallery = DBRow::make($_REQUEST['page'], 'PhotoGallery');
			$this->smarty->assign('curgallery', $gallery);
			$this->smarty->assign('galleries', $gallery->getSubGalleries());
			return $this->smarty->fetch('galleries.tpl');
		} else {
			$galleries = PhotoGallery::getAll('where parent_gallery_id=0', '');
			$this->smarty->assign('galleries', $galleries);
			return $this->smarty->fetch('galleries.tpl');
		}
	}
	
	public static function getLinkables($level = 0, $id = null){
		switch($level){
			case 1:
			default:
				$linkItems = PhotoGallery::getAll('where parent_gallery_id=0', '');
				foreach($linkItems as $linkItem){
					$linkables[$linkItem->get('id')] = $linkItem->get('name');
					$linkables[0] = "--Top Level Gallery--";
				}
				return $linkables;
		}
	}
	
	public function getLinkable($id){
		$page = PhotoGallery::make($id, 'PhotoGallery');
		if ($page->get('id')){
			require_once (SITE_ROOT . '/core/plugins/modifier.urlify.php');
			return '/gallery/' . $page->get('id') . '-' . smarty_modifier_urlify($page->get('name'));
		}
		return '/gallery/';
	}
}

?>