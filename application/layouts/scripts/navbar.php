<script type="text/javascript">
	function getFormPrefs(){
		var url = '/prefs/index';
		$.get(url, 
			{},
			function(respond){
				$("#formPrefs").html(respond); 
			}
		);
	}
</script>

<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="testLinkLogoNavbar" href="http://www.<?php echo $siteAddress ?>">
		<div class="testLogoNavbar">Hapta</div>
		<div class="testSubNavbar"><?php echo strtoupper(Zend_Registry::get('City_Location')); ?></div>
	  </a>
     
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
      	<li id="navAgenda"><a href="/"><strong>Agenda</strong><span class="sr-only">(current)</span></a></li>
      	<li id="navConcours"><a href="/concours">Concours<span class="sr-only">(current)</span></a></li>
	 	<li id="navSocial"><a href="/social">Social <span class="sr-only">(current)</span></a></li>
	 	<li id="navContact"><a href="/contact">Contact <span class="sr-only">(current)</span></a></li>
      <?php 
      	$request = Zend_Controller_Front::getInstance()->getRequest();
		$controller = $request->getControllerName();
		$action = $request->getActionName();
		if($controller == "index"): 
	  ?>
  		<script>$("#navAgenda").addClass("active")</script>
      <?php elseif($controller == "contact"): ?>
      	<?php if($action == "admin"): ?>
      		<script>$("#navAccess").addClass("active")</script>
      	<?php else: ?>
      		<script>$("#navContact").addClass("active")</script>
      	<?php endif; ?>
      <?php elseif($controller == "social"): ?>
      	<script>$("#navSocial").addClass("active")</script>
      <?php elseif($controller == "concours"): ?>
      	<script>$("#navConcours").addClass("active")</script>
      <?php endif; ?>

		<li class="dropdown">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Villes <span class="caret"></span></a>
			<ul class="dropdown-menu">
				<?php 
			      	$otherSites = explode(", ", Zend_Registry::get('Other_Sites'));
			      	foreach($otherSites as $site):
			      ?>
			      	<li><a href="http://www.hapta<?php echo strtolower($site); ?>.fr" target="_blank"><?php echo $site; ?></a></li>
			      <?php endforeach; ?>
			</ul>
		</li>
      </ul>
       
	  <div id="fbinfosnavbar">
	  <div id="profilUser">	
	      <ul class="nav navbar-nav navbar-right">
	      <li id="loginFb"></li>
		  <li class="dropdown" id="test">
	          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" id="nom"> <span class="caret"></span></a>
	          <ul class="dropdown-menu">
				 <li><a href="<?php  echo $this->url(array('controller'=>'prefs')); ?>"> <i class="fa fa-cog "></i> Paramètres</a></li> 
				<li id="decoLoginFb"></li>
	          </ul>
	      </li>
          </ul>
      </div>
      </div>

	  <form id="search" name="formRechercheDate" onsubmit="triggerSearch(); return false;" class="nav navbar-form navbar-right" role="search"> <!-- action="searchf.php" method="post" --> <div class="form-group">

					<div class="btn-group">
						<input id="request" type="text" class="form-control" size="40" placeholder="Rechercher par soirée ou lieu">
						<i class="fa fa-search searchicon"></i>
					</div>
		</div>
		<!-- <input name="search" id="request" type="text" size="40" 
		placeholder="Rechercher par date, artiste ou lieu" /> -->
	  </form>
	  
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
<?php if($controller != "error"): ?>
<div data-role="page" id="listing" class="jqm-demos" data-quicklinks="true">

	<div data-role="content" class="jqm-content">
		<div class="header margintop10">
			<div id="logo"> 
	
			<a class="testLinkLogo" href="http://www.<?php echo Zend_Registry::get('Site_Address') ?>">
				<div class="testLogo">Hapta</div>
				<div class="testSub"><?php echo strtoupper(Zend_Registry::get('City_Location')); ?></div>
			</a> <br/>
<? endif; ?>