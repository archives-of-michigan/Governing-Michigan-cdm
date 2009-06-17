<? 
include('discover/partial.php');
include("config.php");
include('discover/meta_scr.php');

$alias = (isset($_GET["CISOROOT"])) ? $_GET["CISOROOT"] : 0;
$trimmed_alias = trim($alias,'/');
$requested_itnum = (isset($_GET["CISOPTR"])) ? $_GET["CISOPTR"] : 0;
$show_all = (isset($_GET["show_all"])) ? $_GET["show_all"] : false;
$printable = false;

if(isset($_GET['search'])) {
  $seek_search_params = $_GET['search'];
  $encoded_seek_search_params = urlencode($seek_search_params);
} else if(isset($_POST['search'])) {
  $seek_search_params = $_POST['search'];
  $encoded_seek_search_params = urlencode($seek_search_params);
}

$search_position = isset($_GET['search_position']) ? $_GET['search_position'] : 0;
$parent_item = get_item($alias, $requested_itnum);
$parent_filetype = GetFileExt($parent_item['structure'][$parent_item['index']["FIND"][0]]["value"]);

dmGetCollectionParameters($alias, $collection_name, $collection_path);
$parent_object_ptr = GetParent($alias, $requested_itnum, $collection_path);
if($parent_object_ptr != -1) {
  $parent_itnum = $parent_object_ptr;
  include("discover/comp_obj_scr.php");
  $isthisCompoundObject = true;
  $display_item = $current_item;
  $itnum = $display_item['ptr'];
  $print_item = $display_item;
} else if($parent_filetype == 'cpd') {
  $parent_itnum = $requested_itnum;
  include("discover/comp_obj_scr.php");
  $isthisCompoundObject = true;
  $display_item = $current_item;
  $itnum = $display_item['ptr'];
  $printable = true;
  if($show_all) { $print_item = $parent_item; } else { $print_item = $display_item; }
} else if($parent_filetype == 'pdf') {
  $isthisCompoundObject = false;
  $display_item = $parent_item;
  $itnum = $requested_itnum;
  $printable = true;
  $print_item = $display_item;
} else {
  $isthisCompoundObject = false;
  $display_item = $parent_item;
  $itnum = $requested_itnum;
  $print_item = $display_item;
}

$filetype = GetFileExt($display_item['structure'][$display_item['index']["FIND"][0]]["value"]);
$doctitle = $display_item['structure'][$display_item['index']["TITLE"][0]]["value"];

$isthisImage = in_array($filetype,$isImage);
if($isthisImage){
  dmGetCollectionImageSettings($alias, $pan_enabled, $minjpegdim, $zoomlevels, $maxderivedimg, $viewer, $docviewer, $compareviewer, $slideshowviewer);
  include("discover/pan_scr.php");
  define("FACEBOX",'display');
  define("LIGHTBOX",'display');
  define("SLIDER", 'display');

  $lightbox_images = array(
    'fullscreen_popup' => array(
      'alias' => $alias,
      'itnum' => $itnum
    )
  );
  
  // full-screen view settings
  if($lightbox_images) {
    foreach($lightbox_images as $id => $data) {
      $filename = $type = $width = $height = '';
      $image_info = dmGetImageInfo($alias, $itnum, $filename, $type, $width, $height);
      $lightbox_images[$id]['filename'] = $filename;
      $lightbox_images[$id]['type'] = $type;
      $lightbox_images[$id]['width'] = $width;
      $lightbox_images[$id]['height'] = $height;
    }
  }
  $printable = true;
}

$title = 'Viewer  &mdash; Seeking Michigan &mdash; '.$doctitle;
$collection_url = SEEKING_MICHIGAN_HOST.'/discover/'.$collection_name;
define("BODY_CLASS","discover");
include('header.php');
?>
<div id="main-content">
  <div class="wrapper mod">
    <div id="utility-search">
      <form id="global-search" action="seek_results.php" method="get" >
        <input type="hidden" name="CISOROOT" value="all">
        <label for="CISOBOX1" class="hidden">Seek: </label>
        <input type="text" name="CISOBOX1" id="s" value=" " />
        <label for="search-button" class="hidden">Search </label>
        <input type="submit" value=" " id="search-button" name="search-button" />
      </form>
      <p class="advanced-search"><a href="<?= SEEKING_MICHIGAN_HOST ?>/seek"><span>Advanced Search</span></a></p>
  	</div>
    <ul id="breadcrumbs">
      <li><a href="#">Home</a> </li>
      <li> &raquo; <a href="<?= SEEKING_MICHIGAN_HOST ?>/discover">Discover</a> </li>
      <li> &raquo; <a href="<?= SEEKING_MICHIGAN_HOST ?>/discover">Collections</a> </li>
      <li> &raquo; <a href="<?= $collection_url ?>"><?= $collection_name; ?></a> </li>
      <li class="here"> &raquo; Item Viewer </li>
    </ul>
    <h1>Discover</h1>
    <div  id="item-header">
      <div class="wrapper">
        <h2>Collection: <a href="<?= $collection_url ?>" title="<?= $collection_name ?>"><?= $collection_name ?></a></h2>
        <h3>Item Viewer: <?= $doctitle ?></h3>
        <ul class="page-actions">
          <? if($seek_search_params): ?>
            <li class="action-back"><a href="/custom/seek_results.php?<?= $seek_search_params ?>">Back to results</a></li>
          <? endif; ?>
          <li class="action-url">
            <a href="#permalink" rel="facebox">Copy Item URL</a>
            <div id="permalink" style="display:none;"> 
              The URL for this item is <span class="citation"><?= SEEKING_MICHIGAN_HOST ?>/u?<?= $_GET['CISOROOT'] ?>,<?= $_GET['CISOPTR'] ?></span>
            </div>
          </li>
          <? if($printable): ?>
            <li class="action-print"><a href="<?= print_link($print_item) ?>">Printable Version</a></li>
          <? endif; ?>
          <li class="share-this"><!-- AddThis Button BEGIN --><script type="text/javascript">addthis_pub  = 'seekingmichigan'; addthis_offset_top = -10; addthis_offset_left = 5; addthis_options = 'delicious, email, digg, facebook, google, technorati, twitter, myspace,  more';</script><a href="http://www.addthis.com/bookmark.php" onmouseover="return addthis_open(this, '', '[URL]', '[TITLE]')" onmouseout="addthis_close()" onclick="return addthis_sendto()">Share This</a><script type="text/javascript" src="http://s7.addthis.com/js/152/addthis_widget.js"></script><!-- AddThis Button END --></li>
          <li class="view-collection"><a href="/custom/seek_results.php?CISOROOT=<?= $alias ?>">View Collection</a></li>
        </ul>
      </div>
    </div>
    <? if($_GET['show_all']) {
      for($i = 1; $i < count($compound_items); $i++){
        $current_item = get_sub_item($alias, $compound_items, $i, $requested_itnum);
        Partial::basic_view($alias, $current_item, $parent_item, $isImage, $seek_search_params, $search_position, 
          $seek_search_params, $isthisCompoundObject, $previous_item, $next_item, $current_item_num, $totalitems);
      }
    } else if($isthisImage){
      include("discover/pan_view.php");
    } else {
      Partial::basic_view($alias, $display_item, $parent_item, $isImage, $seek_search_params, $search_position, 
        $seek_search_params, $isthisCompoundObject, $previous_item, $next_item, $current_item_num, $totalitems);
    } ?>
  </div>
</div>
<div id="main-whitebox-left"></div>
<div id="main-whitebox-right"></div>
<? include('footer.php'); ?>