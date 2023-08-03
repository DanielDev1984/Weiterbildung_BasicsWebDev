<?php 
	define ('MainTextColor', 'cadetblue');
	define ('HighlightColor', 'aquamarine');
	define ('GradientEndColor', HighlightColor);
	function getlinearGradient($colors) { // initial idea taken from here: https://gist.github.com/pale2hall/6613782c0de6f1669bb0d3e56beb2849
		//$colors = "#9dd5eb," . "rgba(171,214,221,0.8)," . GradientEndColor;
		$bgImg = "linear-gradient(to right, $colors)";
		echo $bgImg;
	}
	function getBgImageWindow() { 
		$colors = "#9dd5eb," . "rgba(171,214,221,0.8)," . GradientEndColor;
		echo getlinearGradient($colors);
	}
	function getBgImageTiles() { 
		$colors = "rgba(171,214,221,0.9)," . "rgba(127,255,212,0.5)";
		echo getlinearGradient($colors);
	}
	function getBgMainText() {
		$colors = "rgba(171,214,221,0.8)," . "rgba(127,255,212,0.5)";
		echo getlinearGradient($colors);
	}
?>