<?php 
	$options = get_option( ART_SETTINGS );

	$key      = $options['api_key'];
	$type     = $param['type'];
	$theme    = $param['theme'];
	$url      = $param['artist'];
	$minPrice = $param['min_price'];
	$maxPrice = $param['max_price'];
	$tag = $param['tag'];
	$artistId = $_GET['id'];
//echo $artistId;	

?>
<div id="artcloud-container" class="<?php echo $theme ?>">
  <div id="artcloud-content"></div>
  <div id="mask"></div>
</div>
<script type="text/javascript">
	(function() {
	  var w = window;
	  var d = document;

	  function l() {
	    var s = d.createElement('script');
	    s.type = 'text/javascript';
	    s.async = true;
	    s.src = 'https://artcld.com/plugin/artcloud.js';


	    var r = false;
	    s.onload = s.onreadystatechange = function() {
	      if (!r && (!this.readyState || this.readyState == 'complete')) {
	        r = true;

	        var callback = function() {
		        <?php if($type =="artists"):?>
		         Artcloud.artists.get();
		         <?php elseif($type=="art"):?>
				 Artcloud.art.get();
				 <?php elseif($type=="artist"):?>
				 Artcloud.artists.getDetails(<?=$artistId?>);
				 <?php endif;?>
				  //Artcloud.shows.get();
	          //jQuery("#mask").hide();
	        };
	        <?php if($type =="artists"):?>
	        	Artcloud.artists.baseDetailsUrl = '/artist/';
	        <?php endif;?>
	        Artcloud.init({
	          key: '<?php echo $key?>',
	          type: '<?php echo $type?>',	         
	          content: 'artcloud-content',	          
	          params: {
	          	<?php if($artistId != ''):?>
	            artistId: '<?php echo $artistId;?>',
	            <?php endif; ?>
	            <?php if($minPrice != ''):?>
	            minPrice: '<?php echo $minPrice?>',
	            <?php endif;?>
	            <?php if($maxPrice != ''): ?>
	            maxPrice: '<?php echo $maxPrice?>',
	            <?php endif; ?>
	            <?php if($tag != ''):?>
	            tag: '<?php echo $tag?>'
	            <?php endif; ?>
	          }
	        }, callback);
	      }
	    };

	    var x = d.getElementsByTagName('script')[0];
	    x.parentNode.insertBefore(s, x);
	  }

	  if (w.attachEvent) {
	    w.attachEvent('onload', l);
	  } else {
	    w.addEventListener('load', l, false);
	  }
	})();


</script>