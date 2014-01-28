<!-- search -->
<form class="search" method="get" action="<?php echo home_url(); ?>" role="search">
	<input class="search-input" type="text" name="s"  value="Search" onfocus="if (this.value == 'Search') {this.value = '';}" onblur="if (this.value == '') {this.value = 'Search';}">
	<input type="hidden" value="all" name="post_type" id="searchOptionsAll">
	<button class="search-submit icon-search" type="submit" role="button"></button>
</form>
<!-- /search -->