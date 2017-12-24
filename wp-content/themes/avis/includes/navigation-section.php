<?php global $avis_shortname; ?>
<div class="navigation blog-navigation">
	<?php $_show_pagination = avis_get_option($avis_shortname.'_show_pagination'); ?>
	<?php  if (function_exists("avis_paginate") && $_show_pagination == 'on') { avis_paginate(); } else {?>			
	<div class="alignleft"><?php previous_posts_link(__('<i class="fa fa-angle-left"></i> Older Posts','avis')) ?></div>		
	<div class="alignright"><?php next_posts_link(__('Newer Posts <i class="fa fa-angle-right"></i>','avis'),'') ?></div>			
	<?php } ?>					
</div>