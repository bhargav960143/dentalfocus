<?php
$tabName = 'socialmedia';
if(isset($_REQUEST['tab']) && !empty($_REQUEST['tab'])){
	$tabName = $_REQUEST['tab'];
}
?><div id="wpbody" role="main">
	<div class="wrap">
    	<div id="message2" class="updated notice below-h2">
        	<h3>Dentalfocus Settings</h3>
        </div>
      	<!-- Content -->
        <div class="wp-filter">
            <ul class="filter-links">
                <li class="plugin-install-featured"><a href="admin.php?page=dfsettings&tab=socialmedia" class="
				<?php if(!empty($tabName)){ if($tabName == "socialmedia"){ echo 'current'; } } ?>">Social Media</a> 
                </li>
                <li class="plugin-install-popular"><a href="admin.php?page=dfsettings&tab=popular" class="
				<?php if(!empty($tabName)){ if($tabName == "popular"){ echo 'current'; } } ?>">Popular</a> 
                </li>
                <li class="plugin-install-recommended"><a href="admin.php?page=dfsettings&tab=recommended" class="
				<?php if(!empty($tabName)){ if($tabName == "recommended"){ echo 'current'; } } ?>">Recommended</a> 
                </li>
                <li class="plugin-install-favorites"><a href="admin.php?page=dfsettings&tab=favorites" class="
				<?php if(!empty($tabName)){ if($tabName == "favorites"){ echo 'current'; } } ?>">Favourites</a>
                </li>
            </ul>
        </div><?php
    	switch ($tabName) {
			case "socialmedia":
				include 'socialmedia.php';
			break;
			case "popular":
				include 'popular.php';
			break;
			default:
				include 'socialmedia.php';
		}
	?></div>
</div>