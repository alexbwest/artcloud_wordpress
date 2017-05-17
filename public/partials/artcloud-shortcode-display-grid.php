<?php 
  $options = get_option( ART_SETTINGS );

  $key      = $options['api_key'];
  $type     = $param['type'];
  $theme    = $param['theme'];
  $url      = $param['artist'];
  $minPrice = $param['min_price'];
  $maxPrice = $param['max_price'];
  $tag      = $param['tag'];
  $artistID = $this->getParamFromUrl($url);
?>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.0.5/handlebars.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js"></script>
    <style type="text/css"> @import url("https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css");</style>
    <script type="text/javascript">
      jQuery(document).ready(function($){
        
        var makeArtGrid = function(data) {
          console.log(data);
          var source   = $("#artcloud-template").html();
          var template = Handlebars.compile(source);
          $("#artcloud-content").html(template(data));
          $('.fancybox').fancybox({
            padding: 0,
            showCloseButton: false,
            helpers : {
              title : { type : 'inside' }
            }, // helpers
            beforeLoad: function() {
              this.title = $(this.element).attr('caption');
            }
          });
          //$("#mask").hide();
        }

        function l($args = null) {
          var w = window;
          var d = document;
          var s = d.createElement('script');
          s.type = 'text/javascript';
          s.async = true;
          s.src = 'https://artcld.com/plugin/artcloud.js';
          var r = false;
          var key = '<?php echo $key?>';

          s.onload = s.onreadystatechange = function () {
              if (!r && (!this.readyState || this.readyState == 'complete')) {
                  r = true;
                  var callback = function () {
                      Artcloud.art.get();
                      Artcloud.art.getCallback = makeArtGrid;
                  };
                  Artcloud.init({
                      key: key,
                      type: '<?php echo $type?>',
                       params: {
                          <?php if($artistID != ''):?>
                          artistId: '<?php echo $artistID;?>',
                          <?php endif; ?>
                          <?php if($minPrice != ''):?>
                          minPrice: '<?php echo $minPrice?>',
                          <?php endif;?>
                          <?php if($maxPrice != ''): ?>
                          maxPrice: '<?php echo $maxPrice?>',
                          <?php endif; ?>
                          <?php if($tag != ''):?>
                          tags: '<?php echo $tag?>'
                          <?php endif; ?>
                      }
                  }, callback);
              }
          };

          var x = d.getElementsByTagName('script')[0];
          x.parentNode.insertBefore(s, x);
        }
        // init
        l();
      });

    </script>
    <style type="text/css">
      #artcld .col-4 {
        width: 25%;
        height: 300px;
        float: left;
        box-sizing: border-box;
        text-align: center;
      }
      #artcld .col-4 img {
        max-height:200px;
        width: auto;
      }
      .fancybox-skin {
        background-color: #000;
      }
      .fancybox-title-inside-wrap {
        padding: 10px 20px;
        background-color: #000;
        color: #fafafa;
      }
      
    </style>
    <script id="artcloud-template" type="text/x-handlebars-template">
      <div id="artcld">
        {{#Artwork}}
          <a rel="artwork-group" href="{{Images.0.LargeUrl}}" class="fancybox" caption="{{Title}} {{Dimensions.Formatted}} {{Medium}}">
            <div class="col-4">
              <img src="{{Images.0.MediumUrl}}" width="100%" height="auto"/><br />
              {{Title}}<br />
              {{Medium}}<br />
              {{Dimensions.Formatted}}<br />
             
              
            </div>
          </a>
        {{/Artwork}}
      </div>
    </script>
    <div id="artcloud-content"></div>
    <div id="mask">
      <img class="articon" src="<?php echo plugin_dir_url()?>/artcloud-api-display/public/images/cloud.png">
    </div>
     