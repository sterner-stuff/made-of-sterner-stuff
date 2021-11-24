<?php 

namespace SternerStuffWordPress;

use SternerStuffWordPress\Interfaces\ActionHookSubscriber;

class MaintenanceMode implements ActionHookSubscriber {

    public static function get_actions() {
		return [
			'template_redirect' => 'template_redirect',
		];
	}

	public function template_redirect()
	{ ?>
		<html>
			<head>
				<meta charset="utf-8">
				<title>Scheduled Maintenance</title>
				<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
				<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
				<style>
					@import url('https://fonts.googleapis.com/css?family=Roboto');
					body {
						font-family: 'Roboto', sans-serif;
					}
				</style>
			</head>
			<body class="grey lighten-3">
				<div class="container">
					<div class="section">
						<div class="row">
							<div class="col s12 m3"></div>
							<div class="col s12 m6">
								<div class="card center center-align">
								<div class="card-content">
									<span class="card-title">Scheduled Maintenance</span>
									<p>Will be back shortly.</p>
								</div>
								<div class="card-content">
									<?php \the_custom_logo(); ?>
								</div>
								</div>
							</div>
							<div class="col s12 m3"></div>
						</div>
					</div>
				</div>
			</body>
		</html><?php
  		die();
	}
	
}