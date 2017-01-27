<?php

$brand['content'] = 'Projekt-Titel';
$brand['href'] = '';

$nav['id1']       = array('href' => '', 'content' => 'Google');
$nav['id2']       = array('href' => '', 'content' => 'Google');
$nav['id3']       = array('href' => 'dropdown', 'content' => 'Google');
$nav['id3']['a']  = array('href' => '', 'content' => 'Google2');
$nav['id3']['b']  = array('href' => 'divider', 'content' => 'Google3');
$nav['id3']['c']  = array('href' => 'header', 'content' => 'Google4');
$nav['id3']['d']  = array('href' => '', 'content' => 'Google5');

$navtemplate = file_get_contents('nav_template.html');

// +++ Build Navbar

$navcontent = '';
		
foreach($nav as $id => $item) {
  if($item['href'] == 'dropdown') {
    $navcontent .= '<li class="dropdown'.($_GET['navid'] == $id ? ' active' : '').'">';
      $navcontent .= '<a href="?navid='.$id.'" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">'.$item['content'].' <span class="caret"></span></a>';
      $navcontent .= '<ul class="dropdown-menu">';
        foreach($item as $subid => $subitem) {      					
          if($subid != 'href' && $subid != 'content') {
            switch($subitem['href']) {	
              case 'divider':
                $navcontent .= '<li role="separator" class="divider"></li>';
                break;	      							
              case 'header':
                $navcontent .= '<li class="dropdown-header">'.$subitem['content'].'</li>';    						
                break;	
              default:
                $navcontent .= '<li><a href="'.$subitem['href'].'?navid='.$id.'">'.$subitem['content'].'</a></li>'."\n";
            }
          }      						
        }
      $navcontent .= ' </ul>';
    $navcontent .= '</li>';
  } else {
    $navcontent .= '<li'.($_GET['navid'] == $id ? ' class="active"' : '').'><a href="'.$item['href'].'?navid='.$id.'">'.$item['content'].'</a></li>'."\n";     		
  }
}      	

$navtemplate = str_replace('@@BRAND_HREF@@', $brand['href'], $navtemplate);
$navtemplate = str_replace('@@BRAND_CONTENT@@', $brand['content'], $navtemplate);
$navtemplate = str_replace('@@NAV_CONTENT@@', $navcontent, $navtemplate);

// --- Build Navbar

echo $navtemplate;
