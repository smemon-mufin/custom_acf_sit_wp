<?php 
$solutions_categories = get_terms('solutions');
$spend_categories = get_terms('spend-areas');
$industry_categories = get_terms('industries');
?>
<section class="resources-filter-wrapper">
<div class="container">
	<div class="resources-filters">
		<div class="filter-row">
			<div class="filter-row__col">
				<!-- Filter for Solutions -->
		     	<div class="filter-dd solutions-choice">
		            <div class="filter-dd__trigger">
		                <span>Solutions</span><?php echo getSVG('chevron'); ?>
		            </div>
		            <div class="filter-dd__list">
		            	<?php foreach ($solutions_categories as $cat) { ?>
		            		<span data-post-name="<?php echo $cat->name; ?>"><?php echo $cat->name; ?></span>
						<?php } ?>		            		
		            </div>
		        </div>
				<!-- Filter for Spend Areas -->
     			<div class="filter-dd spend-areas-choice">
		            <div class="filter-dd__trigger">
		                 <span>Spend Areas</span><?php echo getSVG('chevron'); ?>
		            </div>
		            <div class="filter-dd__list">
			          <?php foreach ($spend_categories as $cat) { ?>
		            		<span data-post-name="<?php echo $cat->name; ?>"><?php echo $cat->name; ?></span>
						<?php } ?>	
		            </div>
		        </div>				
				<!-- Filter for Industries -->
     			<div class="filter-dd industries-choice">
		            <div class="filter-dd__trigger">
		                <span>Industries</span><?php echo getSVG('chevron'); ?>
		            </div>
		            <div class="filter-dd__list">
			          <?php foreach ($industry_categories as $cat) { ?>
			          		<span data-post-name="<?php echo $cat->name; ?>"><?php echo $cat->name; ?></span>
						<?php } ?>	
		            </div>
		        </div>				

			    <!-- Filter for Content Types -->
     			<div class="filter-dd content-type-choice">
		            <div class="filter-dd__trigger">
		                 <span>Content Types</span><?php echo getSVG('chevron'); ?>
		            </div>
		            <div class="filter-dd__list">
			           	<span data-post-type="post">Blog</span>
			           	<span data-post-type="articles">Articles and eBooks </span>
			           	<span data-post-type="resource_videos">Videos</span>
		            </div>
		        </div>				
			</div> <!-- /.filter-row__col -->
			<!-- Filter Button -->
			<div class="filter-row__col">
				<div class="filter-btns">
					<button class="btn btn--grey" id="filter-button">Filter</button>
					<button class="btn btn--underline" id="clear-button">Clear</button>
				</div>
			</div>
		</div>
	</div>
</div>
</section>