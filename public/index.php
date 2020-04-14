<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="The 1 Badges Debug">
	<title>The 1 Badges Debug</title>
	<link rel="stylesheet" href="https://unpkg.com/purecss@1.0.1/build/pure-min.css" integrity="sha384-" crossorigin="anonymous">



	<!--[if lte IE 8]>
	<link rel="stylesheet" href="css/layouts/side-menu-old-ie.css">
	<![endif]-->
	<!--[if gt IE 8]><!-->
	<link rel="stylesheet" href="css/layouts/side-menu.css">
	<!--<![endif]-->
</head>
<body>
	<div id="layout">
		<div id="main">
			<div class="content">

			<h1>The 1 Badges Debug</h1>

			<?php
			$tags = filter_input( INPUT_POST, 'tags' );
			$master = filter_input( INPUT_POST, 'master' );

			if ( ! empty( $tags ) && ! empty( $master ) ) :

			    $tags = json_decode( $tags, true );
			    $master = json_decode( $master, true );

			    if ( ! isset( $tags['responseBody']['tags'] ) ) :
			        echo '<p>No tags found in the payload.</p>';

			        echo '<pre><code>';
			        print_r( $tags );
			        echo '</code></pre>';

			        exit;
			    endif;

				if ( ! isset( $master['responseBody']['badges'] ) ) :
					echo '<p>No badges found in the payload.</p>';

					echo '<pre><code>';
					print_r( $master );
					echo '</code></pre>';

					exit;
				endif;

				$all_tags = [];
				$all_master = [];

				// Cleanup the tags.
				foreach ( $tags['responseBody']['tags'] as $tag ) {
					array_push( $all_tags, strtoupper( $tag['name'] ) );
				}

				// Cleanup master.
				foreach ( $master['responseBody']['badges'] as $badge ) {
					array_push( $all_master, strtoupper( $badge['badgeName'] ) );
				}

				echo '<table class="pure-table pure-table-bordered"><thead><tr><th>Tag Name</th><th>Badge Master</th></tr></thead>';

				foreach ( $all_tags as $tag ) {

					$master_exists = in_array( $tag, $all_master ) ? 'OK' : 'NOT IN BADGE MASTER';
					echo "<tr><td>$tag</td><td>$master_exists</td></tr>";
				}

				echo '</table>';

			else : ?>

			<form method="POST" action="/" class="pure-form">
				<fieldset class="pure-group">
				  <label for="tags">User's Tags Payload:</label><br>
				  <textarea id="tags" name="tags" rows="4" cols="50"></textarea>
				</fieldset>
				<fieldset class="pure-group">
				  <label for="master">Badge Master Payload:</label><br>
				  <textarea id="master" name="master" rows="4" cols="50"></textarea>
				</fieldset>
			  <input type="submit" value="Check" class="pure-button pure-input-1-2 pure-button-primary">
			</form>

		</div>
	</div>
</div>
</body>
</html>

<?php endif;
