<script type="text/javascript">

var id = '<?php echo $id; ?>'; 

$(document).ready(function(){

	$('ul.lcms-survey-pages a').live('click',function(e){
		e.preventDefault();
		var type = $(this).attr('href');
    
    	$.ajax({
    		url: 'config/ajax/get_page_form',
    		type: 'post',
    		data: 'type='+type+'&id='+id,
    		success: function (page){
    			$('div.lcms-survey-edit-box').html(page);
    		}
    	});
		
	})
	
	$('ul.lcms-survey-questions a').live('click',function(e){
		e.preventDefault();
		
		$('div.lcms-survey-edit-box').html('<p align="center"><img style="margin-top: 100px" src="images/loader.gif" /></p>');
		
		if ($(this).hasClass('page')){
			
			
		} else {
		
			var no = $(this).attr('href');
			
			$.ajax({
				url: 'config/ajax/get_question_form',
				type: 'post',
				data: 'id='+id+'&no='+no,
				success: function (page){
					$('div.lcms-survey-edit-box').html(page);
				}
			});
		
		}
	});
	
	$('button.lcms-survey-add-question').live('click',function(){
		var no = 0;
		
		$.ajax({
			url: 'config/ajax/get_question_form',
			type: 'post',
			data: 'id='+id+'&no='+no,
			success: function (page){
				$('div.lcms-survey-edit-box').html(page);
			}
		})
	});
	
	$('a.lcms-survey-settings').live('click',function(e){
		e.preventDefault();
		$(this).parents('li.lcms-editable-object').find('a.lcms-content-edit').click();
	});
	
	$('a.first-page').click();
	
	$(window).resize(function(){
		var winHeight = $(window).height() - 150;
		$('div.questions-container').css('height', winHeight);
		$('#lcms-survey-page-content').css('height', winHeight - 35);
	});
	
	$(window).resize();
	
})

function reloadSummaryList(){
	$('div.questions-container').html('<p align="center"><img style="margin-top: 100px" src="images/loader.gif" /></p>');
	$.ajax({
		url: 'config/ajax/summary_list',
		type: 'post',
		data: 'id='+id,
		success: function (page){
			$('div.questions-container').html(page);
		}
	})
}

</script>
<script type="text/javascript">


$(document).ready(function(){


	$('button.single-answer-remove').live('click',function(){
		$(this).parents('div.single-answer').remove();
	});

	
	$('button.multiple-answer-remove').live('click',function(){
		$(this).parents('div.multiple-answer').remove();
	});
	
	
	$('button.matrix-sa-remove-row').live('click', function(){
		$(this).parents('tr').remove();
	})
	
	$('button.matrix-sa-remove-col').live('click',function(){
		var cur = 0;
		var curCol = 0;
		var curI = $(this).attr('i');
		$(this).parents('tr').find('th').each(function(){
			if ($(this).find('button').attr('i') == curI) curCol = cur;
			cur++;
		});
		

		$('table.matrix-sa thead th').eq(curCol).remove();
		$('table.matrix-sa tbody tr').each(function(){
			$(this).find('td').eq(curCol).remove();
		});
		
		col--;
	});
	
	$('button.matrix-ma-remove-row').live('click', function(){
		$(this).parents('tr').remove();
	})
	
	$('button.matrix-ma-remove-col').live('click',function(){
		var cur = 0;
		var curCol;
		var curI = $(this).attr('i');
		$(this).parents('tr').find('th').each(function(){
			if ($(this).find('button').attr('i') == curI) curCol = cur;
			cur++;
		});

		$('table.matrix-ma thead th').eq(curCol).remove();
		$('table.matrix-ma tbody tr').each(function(){
			$(this).find('td').eq(curCol).remove();
		});
		
		col_ma--;
	});
	
	
	$('button.matrix-answer-remove').live('click', function(){
		$(this).parents('tr').remove();
	});
	
	
	$('ul.lcms-survey-questions li').live('click', function(){
		$('ul.lcms-survey-questions li').removeClass('current');
		$(this).addClass('current');
	});
	
	reloadSummaryList();

});

</script>

	<div class="main-survey" style="position: fixed; top: 35px; left: 0; right: 0; bottom: 0; background: #FFF; padding: 15px; overflow-y: auto">

	<?php if ($author_mode): ?>
	<div class="lcms-survey-control">
		<a class="lcms-btn" href="<?php echo $current_page; ?>">View This Survey</a>
		<a class="lcms-btn" href="<?php echo $current_page; ?>preview/<?php echo $survey->id; ?>" target="_blank">Preview Printable Survey</a>
		<a class="lcms-btn" href="<?php echo $current_page; ?>analysis/<?php echo $survey->id; ?>">Analysis</a>
		<a class="lcms-btn lcms-survey-settings" href="#">Survey Settings</a>
	</div>
	<?php endif; ?>

	<div>
		<div class="lcms-survey-edit-box" style="float: right; width: 72%; margin-right: 10px">
			
		</div>
		<div class="lcms-survey-summary" style="float: left; width: 25%">

			<p><button style="float:right" class="lcms-btn lcms-survey-add-question">Add Question</button>Pages &amp Questions</p>
			<div class="questions-container">
				<ul>
					<li><a class="first-page page" href="introduction">Introduction</a></li>
					<li><a class="page" href="conclusion">Conclusion/Result Page</a></li>
					<li><a class="page" href="thank_you">Thank You Message</a></li>
				</ul>
				
			</div>
			
		</div>
		<div style="clear:both"></div>
	</div>
	
	
	
	
	</div>