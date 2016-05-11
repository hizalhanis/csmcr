	<div class="lcms-plexcart-breadcrumb">
		<h3><a href="<?php echo $current_page; ?>">Store</a> &raquo; Login</h3>
	</div>
	<div class="entry">

		<?php if ($incorrect): ?>
	    <p class="error">Incorrect username or password.</p>
	    <?php endif; ?>
	    <form class="lcms-plexcart" method="post" action="<?php echo $current_page ?>login_do">
	    	<table class="form-grid">
	    		<tr>
	    			<td class="label">Email</td>
	    			<td><input class="text mandatory" type="text" value="" name="username" /></td>
	    		</tr>
	    		<tr>
	    			<td class="label">Password</td>
	    			<td><input class="text mandatory" type="password" value="" name="password" /></td>						
	    		</tr>
	    	</table>
	    
	    	<p class="align-right"><input type="submit" class="lcms-btn submit" value="Login" /></p>
	    </form>
	</div>
		
		
