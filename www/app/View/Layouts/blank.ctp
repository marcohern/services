<?php ?>
<!DOCTYPE html>
<html>
	<head>
		<title>Test</title>
		<?= $this->Html->css('bootstrap.min'); ?>
		<?= $this->Html->css('bootstrap-theme.min'); ?>
		<?= $this->Html->css('styles'); ?>

		<?= $this->Html->script('jquery-2.1.0.min'); ?>
		<?= $this->Html->script('bootstrap.min'); ?>
		<?= $this->Html->script('marcohern.xhttp'); ?>
	</head>
	<body>
		<div class="navbar navbar-inverse">

			<div class="container-fluid">

				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#main-menu">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="#">Brand</a>
				</div>

				<div class="collapse navbar-collapse" id="main-menu">
					<ul class="nav navbar-nav">
						<li class="active"><a href="#">Link 1</a></li>
						<li><a href="#">Link 2</a></li>
						<li><a href="#">Link 3</a></li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">Link 4 <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li><a href="#">Item 1</a></li>
								<li><a href="#">Item 2</a></li>
								<li><a href="#">Item 3</a></li>
								<li class="divider"></li>
								<li><a href="#">Item 4</a></li>
								<li><a href="#">Item 5</a></li>
							</ul>
						</li>
					</ul>

					<form class="navbar-form navbar-left" role="search">
						<div class="form-group">
							<input type="text" class="form-control" placeholder="Search" />
						</div>
						<button class="btn btn-default">Submit</button>
					</form>

					<ul class="nav navbar-nav navbar-right">
						<li><a href="#">Sink 1</a></li>
						<li><a href="#">Sink 2</a></li>
						<li><a href="#">Sink 3</a></li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">Link 4 <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li><a href="#">Sitem 1</a></li>
								<li><a href="#">Sitem 2</a></li>
								<li class="divider"></li>
								<li><a href="#">Sitem 3</a></li>
								<li><a href="#">Siem 4</a></li>
								<li class="divider"></li>
								<li><a href="#">Sitem 5</a></li>
								<li><a href="#">Sitem 6</a></li>
							</ul>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="container">
			<ul class="breadcrumb">
				<li><a href="#">Home</a></li>
				<li><a href="#">Category</a></li>
				<li class="active">Item</li>
			</ul>

			<ul class="pagination pagination-lg">
				<li class="disabled"><a href="#">&laquo;</a></li>
				<li class="active"><a href="#">1 <span class="sr-only">(current)</span></a></li>
				<li><a href="#">2</a></li>
				<li><a href="#">3</a></li>
				<li><a href="#">4</a></li>
				<li><a href="#">5</a></li>
				<li><a href="#">6</a></li>
				<li><a href="#">7</a></li>
				<li><a href="#">8</a></li>
				<li><a href="#">9</a></li>
				<li><a href="#">10</a></li>
				<li><a href="#">11</a></li>
				<li><a href="#">12</a></li>
				<li><a href="#">&raquo;</a></li>
			</ul>
		</div>
		<?= $this->fetch('content'); ?>

		<div class="navbar navbar-inverse navbar-static-bottom" role="navigation">

			<div class="container">

				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#footer-menu">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="#">Low Brand</a>
				</div>

				<div class="collapse navbar-collapse" id="footer-menu">
					<ul class="nav navbar-nav">
						<li><a href="#">Bink 1</a></li>
						<li><a href="#">Bink 2</a></li>
						<li><a href="#">Bink 3</a></li>
					</ul>
				</div>
			</div>
		</div>
	</body>
</html>