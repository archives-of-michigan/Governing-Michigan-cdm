<?
include("config.php");

define("DEF_CISORESTMP", "seek_results.php");
define("DEF_CISOVIEWTMP", "discover_item_viewer.php");
define("DEF_CISOMODE", "grid"); //grid; title; thumb; bib; hiera
define("DEF_CISOBIB", "title,A,1,N;subjec,A,0,N;descri,200,0,N;none,A,0,N;none,A,0,N;20;title,none,none,none,none");
define("DEF_CISOTHUMB", "20 (4x5);title,none,none,none,none");
define("DEF_CISOTITLE", "20;title,none,none,none,none");
define("DEF_CISOHIERA", "20;subjec,title,none,none,none");
define("DEF_CISOSUPPRESS", "1");

$entries = array();

$search = Search::from_params($_GET);
$search_alias = $search->search_alias;
$field = $search->field;
$sortby = $search->sortby;
$maxrecs = $search->maxrecs;
$start = $search->start;

$record = $search->results();

$totalpages = ceil($search->total / $maxrecs);
$i=0;
while($i<=$totalpages){
  $entries[]=$i;
  $i++;
}
(count($record) > 0)?$isRes = true:$isRes = false;

function getFTS($a){
global $conf;
  for($p=0,$i=0;$i<count($conf);$i++){
    if($conf[$i]["nick"] == $a){
      $p = $i;
      break;
    }
  }
  if($conf[$p]["type"] == "FTS"){
    $fts = true;
  } else {
    $fts = false;
  }
  return $fts;
}

$wfield = '';
$dc = '';
if(isset($_GET["CISOPARM"])){ 

  $parm = explode(":",$_GET["CISOPARM"]);
  $dc = ((substr_count($parm[0], "/") > 0) || ($parm[0] == "all"))?1:0;

  if((getFTS($parm[1])) || ($parm[1] == "CISOSEARCHALL")){
    switch($_GET["CISOOP1"]){
    case "exact":$wfield .= $parm[1].'<"'.trim($parm[2]).'">';break;
    case "none":$wfield .= $parm[1].'<!'.trim($parm[2]).'>';break;
    default:$wfield .= $parm[1].'<'.trim($parm[2]).'>';break;
    }
  } else {
    $wfield = "";
  }
} else {
  $dc = ((substr_count($_GET["CISOROOT"], ",") > 0) || ($_GET["CISOROOT"] == "all"))?1:0;
}

$title = 'Results : Seek &mdash; Seeking Michigan';

$collections = dmGetCollectionList();

$title = 'Results : Seek &mdash; Seeking Michigan';
$breadcrumbs = array('Seek' => 'seek_advanced.php', 'Search Results' => '');
define("BODY_CLASS","seek");
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
      <p class="advanced-search"><a href="advanced-search.html"><span>Advanced Search</span></a></p>
  	</div>
    <ul id="breadcrumbs">
      <li><a href="#">Home</a> </li>
      <li> &raquo; <a href="<?= SEEKING_MICHIGAN_HOST ?>/seek">Seek</a> </li>
      <li class="here"> &raquo; Seek Results </li>
    </ul>
    <? $search->terms; ?>
    <? if($_GET['CISOBOX1'] && $_GET['CISOBOX1'] != ' '): ?>
      <h1>
        Search Results for:
        <? foreach($search->terms() as $term): ?>
          <? $query_string = preg_replace('/CISOBOX1=[^&]*/',"CISOBOX1=$term",$_SERVER['QUERY_STRING']); ?>
          <a href="seek_results.php?<?= $search->term_search_string($alias,$term) ?>"><?= $term; ?></a>
        <? endforeach; ?>
      </h1>
    <? endif; ?>
    <div class="search-results">
      <div class="wrapper">
    <h2>Collection Results</h2>
    <p class="intro">The results for your search are listed below.  You can narrow your search results by following the links listed for each category.</p>
    <form id="browse-search" action="seek_results.php">
      <input type="hidden" name="CISOOP1" value="any" />
      <input type="hidden" name="CISOFIELD1" value="CISOSEARCHALL" />
      <input type="hidden" name="CISOBOX1" value="<?= $_GET['CISOBOX1']; ?>" />
      <p>
        Browsing <strong><?= $num_records_this_page; ?></strong> items in 
        <select name="CISOROOT">
          <option value="all" <? if($_GET['CISOROOT'] == 'CISOSEARCHALL'): ?>selected="selected"<? endif; ?>>
            All Collections</option>
          <? foreach($collections as $collection): ?>
            <option value="<?= $collection['alias']; ?>" <? if($_GET['CISOROOT'] == $collection['alias']): ?>selected="selected"<? endif; ?>>
              <?= $collection['name']; ?></option>
          <? endforeach; ?>
        </select>
        <input type="image" src="<?= SEEKING_MICHIGAN_HOST ?>/images/search-button.gif" value=" " />  
        Or use <a href="seek_advanced.php">Advanced Search &raquo; </a>
      </p>
    </form>
    <div class="paginate">
      <? include('seek/results_sub.php'); ?>
    </div>
    <? include('seek/results_view.php'); ?>
    <div class="paginate">
      <? include('seek/results_sub.php'); ?>
    </div>
    </div>
  </div>
  </div>
</div>
<? include('footer.php'); ?>