<?php

$menu = array(
    array( 'title' => 'Pagrindinis', 'url' => 'index.php'),
    array( 'title' => 'Projektai', 'url' => 'projects.php'), 
    array( 'title' => 'Personalas', 'url' => 'personnel.php'), 
    array( 'title' => 'Komandos', 'url' => 'teams.php'),
    array( 'title' => 'Kategorijos', 'url' => 'categories.php'),
);       
function print_list($list){
    echo '<div class="sidenav">';
    echo '<a class="logo">';
    echo '<img src="img/icon.png">';
    echo '</a>';
    echo '<ul>';
    foreach($list as $list_item) {
        echo "<li>";
        echo "<a href='".$list_item['url']."'>".$list_item['title']."</a>";
        echo '</li>';
    }
    echo '</ul>';
    echo '</div>';
}  
print_list($menu);

?>

