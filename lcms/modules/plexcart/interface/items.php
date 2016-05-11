<script type="text/javascript">
	function fade(obj) {
        $(obj).hide().delay(500).fadeIn();
        
        if ($(obj).hasClass('primary')){
	        var width = $(obj).width();
	        var height = $(obj).height();
	        
	        if (width > height){
		        $(obj).css('width','100%');
		        $(obj).css('height','auto');
		        
		        var cwidth = $(obj).parents('div.lcms-plexcart-image-container').width();
		        var cheight = (height / width) * cwidth;
		        var whitespace = $(obj).parents('div.lcms-plexcart-image-container').height() - cheight;
		        
		        $(obj).css('padding-top', whitespace / 2);
		        
	
	        } else {
		        $(obj).css('height','100%');
		        $(obj).css('width','auto');
		        
		        
	        }
	    }
    }
</script>

	<div class="lcms-plexcart-breadcrumb">
		<?php if ($is_category_page): ?>
		<h3><a href="<?php echo $current_page; ?>">Products</a> &raquo; <?php echo $cat; ?></h3>
		<?php elseif ($is_subcategory_page): ?>
		<h3><a href="<?php echo $current_page; ?>">Products</a> &raquo; <a href="<?php echo $category_page; ?>"><?php echo $cat; ?></a> &raquo; <?php echo $subcat; ?></h3>		
		<?php elseif ($is_search_page): ?>
		<h3><a href="<?php echo $current_page; ?>">Products</a> &raquo; Search for &quot;<?php echo $search_term; ?>&quot;</h3>		
		<?php elseif ($is_tag_page): ?>
		<h3><a href="<?php echo $current_page; ?>">Products</a> &raquo; Tagged &quot;<?php echo $tag; ?>&quot;</h3>
		<?php else: ?>
		<h3>All Products</h3>		
		<?php endif; ?>

	</div>



	<div class="lcms-plexcart-filter">
		<h4>Categories</h4>
		<ul class="lcms-plexcart-categories">
		<?php foreach ($categories as $category): ?>
			<li>
				<a href="<?php echo $current_page;?>category/<?php echo clean_url($category); ?>"><?php echo $category; ?></a>
				<?php if ($category == $cat): ?>
				<ul class="lcms-plexcart-subcategories">
					<?php foreach ($subcategories as $subcategory): ?>
					<li><a href="<?php echo $current_page;?>category/<?php echo clean_url($category); ?>/<?php echo clean_url($subcategory); ?>"><?php echo $subcategory; ?></a></li>					
					<?php endforeach; ?>
				</ul>
				<?php endif; ?>
			</li>
		<?php endforeach; ?>
		</ul>
		
		<?php if (count($tags)): ?>
		<h3>Tags</h3>
		<ul class="lcms-plexcart-tags">
		<?php foreach ($tags as $tag): ?>
			<li><a href="<?php echo $current_page;?>tag/<?php echo clean_url($tag); ?>"><?php echo $tag; ?></a></li>
		<?php endforeach; ?>
		</ul>
		<?php endif; ?>
	</div>
		    	
	<div class="lcms-plexcart-items">
	
	<?php foreach ($items as $item):?>
		<?php 
			
			$tags = $tags_array = null;
			
			if (strpos($item->tags,',')){
				foreach (explode(',',$item->tags) as $tag){
					if ($tag[0] == '#') $tags_array[] = str_replace('#','', $tag);
				}
				$tags = implode(' ', $tags_array);
			} else {
				if ($item->tags[0] == '#'){
					$tags = str_replace('#','',$item->tags);
					$tags_array[] = $tags;
				}
			}
		
		?>
		<div class="lcms-plexcart-item <?php echo $tags; ?>">
			<?php foreach ($tags_array as $tag): ?>
			<div class="tag-<?php echo $tag; ?>"></div>
			<?php endforeach; ?>
			<div class="lcms-plexcart-image-placeholder">
				<div class="lcms-plexcart-image-container">
				<?php if ($item->primary_image): ?>
				<a href="<?php echo $current_page; ?>item/<?php echo $item->id; ?>">
					<img class="primary" onload="fade(this)" src="<?php echo $assets_url . imgsrc($item->primary_image,'standard'); ?>" />
				</a>
				<?php endif; ?>
				</div>
				<div class="lcms-plexcart-variants-image-container">
				<?php if (is_array($item->variants)): ?>
					<?php foreach ($item->variants as $variant): ?>
					<a href="<?php echo $current_page; ?>item/<?php echo $variant->id; ?>"><img onload="fade(this)" src="<?php echo $assets_url . imgsrc($variant->primary_image,'thumbnail'); ?>" /></a>
					<?php endforeach; ?>
				<?php endif; ?>	
				</div>

				<a class="lcms-plexcart-item-title" href="<?php echo $current_page; ?>item/<?php echo $item->id; ?>">
					<?php echo $item->name; ?>
				</a>
			</div>
			
			
			<div class="lcms-plexcart-price-holder">
			<?php if ($item->discount_price != 0 && ($item->discount_applies_to == $user->rank || $item->discount_applies_to == 'All') && ($item->discount_price < $item->price)): ?>
				<?php if ($item->discount_performance_based): ?>
					<?php if (($user->performance[$item->discount_performance_duration] >= $item->discount_performance_limit) && ($item->price < $item->discount_price)): ?>
						<span class="discount"><?php echo $item->currency; ?><?php echo $item->price;?></span>
						<span class="price"><?php echo $item->currency; ?><?php echo $item->discount_price; ?></span>					
					<?php else: ?>
						<span class="price"><?php echo $item->currency; ?><?php echo $item->price; ?></span>					
					<?php endif; ?>
				<?php else: ?>
				<span class="discount"><?php echo $item->currency; ?><?php echo $item->price; ?></span>
				<span class="price"><?php echo $item->currency; ?><?php echo $item->discount_price; ?></span>					
				<?php endif; ?>
		    <?php else: ?>
		    	<span class="price"><?php echo $item->currency; ?><?php echo $item->price; ?></span>
		    <?php endif; ?>
			</div>
			
			<div class="lcms-plexcart-addtocart-holder">
				<?php if ($item->qty - $item->alert_qty >= ($item->max_cart_qty ? $item->max_cart_qty : 3)): ?>
					<?php if (is_array($cart_items[$item->id])): ?>
	    				<span rel="<?php echo $item->id; ?>" class="lcms-plexcart-item-added">Item has been added.</span>
	    			<?php else: ?>
						<?php echo form_dropdown('lcms-plexcart-item-qty',number_range($item->min_cart_qty ? $item->min_cart_qty : 1, $item->max_cart_qty ? $item->max_cart_qty : 3),'','class="lcms-plexcart-item-qty"'); ?>
						<button rel="<?php echo $item->id; ?>" class="lcms-plexcart-addtocart">Add to Cart</button>
					<?php endif; ?>
				<?php else: ?>
    				<span class="lcms-plexcart-out-of-stock">Out of stock</span>
				<?php endif; ?>
			</div>
	
	    	
	    </div>
	<?php endforeach; ?>
		<br style="clear:left" />
		
	</div>

	<div class="lcms-plexcart-pagination">
		<?php 
			if ($is_category_page) $catsubcat = 'category/' . strtolower(clean_url($cat)) . '/'; 
			if ($is_subcategory_page) $catsubcat = 'category/' . strtolower(clean_url($cat)) . '/' . strtolower(clean_url($subcat))  .'/'; 
			if ($is_search_page) $catsubcat = 'search/';
			if ($is_tag_page) $catsubcat = 'tag/';
		?>
		
		<?php if (!$page || $page == 1): ?>
		
			Page <?php echo $page ? $page : $page = 1; ?> of <?php echo $tp = ceil($total / $limit); ?> 
			<?php if ($tp > 1): ?> &middot; <a href="<?php echo $current_page; ?><?php echo $catsubcat; ?>page/<?php echo $page+1; ?>">Next</a><?php endif; ?>
			
		<?php elseif ($page == ceil($total / $limit)): ?>
			
			<a href="<?php echo $current_page; ?><?php echo $catsubcat; ?>page/<?php echo $page-1; ?>">Previous</a> &middot; 
			Page <?php echo $page; ?> of <?php echo ceil($total / $limit); ?>
			<?php if ($tp > 1): ?> &middot; <a href="<?php echo $current_page; ?><?php echo $catsubcat; ?>page/<?php echo $page+1; ?>">Next</a><?php endif; ?>
			
		<?php else: ?>
		
			<a href="<?php echo $current_page; ?><?php echo $catsubcat; ?>page/<?php echo $page-1; ?>">Previous</a> &middot; 			
			Page <?php echo $page; ?> of <?php echo ceil($total / $limit); ?>
			&middot; <a href="<?php echo $current_page; ?><?php echo $catsubcat; ?>page/<?php echo $page+1; ?>">Next</a>
			
		<?php endif; ?>
		
		
	</div>