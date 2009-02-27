<?php

class TextFile extends Storage {
	public function type() {
		return 'text';
	}
	
	public function shouldCompress() {
		return true;
	}
}
DBRow::init('TextFile');
