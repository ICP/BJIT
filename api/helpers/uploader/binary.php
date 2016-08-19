<?php

$postdata = file_get_contents("php://input");
file_put_contents('C:/xampp/htdocs/irib/doctv/tmp/' . time() . '.jpg', $postdata);
die;

//Retrieve file details from uploaded file, sent from upload form
$file = JRequest::getVar('file', null, 'files', 'array');
 
//Import filesystem libraries. Perhaps not necessary, but does not hurt
jimport('joomla.filesystem.file');
 
//Clean up filename to get rid of strange characters like spaces etc
$filename = JFile::makeSafe($file['name']);
 
//Set up the source and destination of the file
$src = $file['tmp_name'];
$dest = JPATH_COMPONENT . DS . "uploads" . DS . $filename;
 
//First check if the file has the right extension, we need jpg only
if ( strtolower(JFile::getExt($filename) ) == 'jpg') {
   if ( JFile::upload($src, $dest) ) {
      //Redirect to a page of your choice
   } else {
      //Redirect and throw an error message
   }
} else {
   //Redirect and notify user file is not right extension
}