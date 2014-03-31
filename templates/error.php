<?php 
defined( '_JEXEC' ) or die( 'Restricted access');
if ($this->error->getCode() == '404') { header('Location: /404'); exit; } 
?>