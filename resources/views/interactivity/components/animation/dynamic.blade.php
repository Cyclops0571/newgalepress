<?php
$vFile = public_path($filename);
if(File::exists($vFile) && is_file($vFile)) {
	$fname = File::name($vFile);
	$fext = File::extension($vFile);
	$vFile = $fname.'.'.$fext;
}
else {
	$vFile = '';
}

if(!$preview)
{
	$vFile = $baseDirectory.'comp_'.$id.'/'.$vFile;
    $baseDirectory = $baseDirectory . "animation";
}
else
{
	$vFile = '/'.$filename;
    $baseDirectory = $baseDirectory . "comp_";
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset='utf-8'/>
	<meta name="viewport" content="user-scalable=no" />
    <title>Gale Press</title>
	<style type='text/css'>
		*{margin:0;padding:0;overflow:hidden;}
		html,body{width:100%;height:100%;}
	</style>
</head>
<body>
	<img src="{{ ((int)$option == 1 ? $vFile : $url) }}" id="image" style="position:relative !important;top:0;left:0;">
	<script type="text/javascript" src="{{ $baseDirectory }}/js/jquery-1.11.1.min.js"></script>
	<script type="text/javascript" src="{{ $baseDirectory }}/js/jquery-ui.min.js"></script>
	<script type="text/javascript">
	$("#image").ready(function() {function u() {setTimeout(function() {v() }, c) } function q() {$("#image").animate({left: y, top: z }, {queue: !1, duration: parseInt(a), complete: function() {1 == m ? A() : 1 == g && (0 < c ? u() : v()) }, easing: n }) } function A() {$("#image").animate({left: h, top: e }, {queue: !1, duration: parseInt(a), complete: function() {1 == g && (0 < c ? u() : q()) }, easing: n }) } function v() {$("#image").css({left: h + "px", top: e + "px"}); q() } var r = {{$w}}, f = {{$h}}, t = {{$x1}}, B = {{$y1}}, C = {{$x2}}, D = {{$y2}}, k = {{$rotation}}, E = {{$rotationspeed}}, a = {{$duration}}, n = "{{ $effect }}", w = null, F = {{$animedelay}}, c = {{$animeinterval}}, m = {{(int)$reverse}}, g = {{(int)$loop}}, x = {{(int)$unvisibleStart}}, b = new Image; b.src = $("#image").attr("src"); b.onload = function() {var c = this.width, a = c / r * 100; c > r ? $("#image").css("width", "100%") : $("#image").css("width", a + "%"); c = this.height / f * 100; $("#image").css("height", c + "%") }; var b = $(window).height(), h = t / f * 100 * b / 100, b = $(window).height(), e = B / f * 100 * b / 100, t = $(window).width(), y = C / r * 100 * t / 100, b = $(window).height(), z = D / f * 100 * b / 100; 1 == x ? $("#image").css({left: h + "px", top: e + "px", opacity: "0"}) : $("#image").css({left: h + "px", top: e + "px", opacity: "1"}); setTimeout(function() {"fade" == n && (w = n, n = null); if (0 != k) {var b = function(a) {var d = $("#image"); 1 == m ? h ? (e = 0, h = !1, f = !0) : (e = a, a = 0, h = !0) : (e = a, a = 0); $({deg: a }).animate({deg: e }, {duration: parseInt(E), easing: "{{ $rotationeffect }}", step: function(a) {d.css({transform: "rotate(" + a + "deg)"}) }, complete: function() {1 == m && 0 == g ? f || b(k) : 0 == m && 1 == g ? 0 < c ? setTimeout(function() {b(k) }, c) : b(k) : 1 == m && 1 == g && (0 < c && 1 == f ? setTimeout(function() {b(k); f = !1 }, c) : b(k)) } }) }, h = !1, e = 0, f = !1; b(k) } if ("fade" == w) {var d = function() {var b = parseInt($("#image").css("opacity")); 1 == m ? 0 == p && 0 == g ? (p++, $("#image").animate({queue: !1, opacity: 0 == b ? 1 : 0 }, parseInt(a), d)) : 1 == p ? (p++, $("#image").animate({queue: !1, opacity: 0 == b ? 1 : 0 }, parseInt(a), d)) : 1 == g && (2 == l && 0 < c ? (l = 1, setTimeout(function() {$("#image").animate({queue: !1, opacity: 0 == b ? 1 : 0 }, parseInt(a), d) }, c)) : ($("#image").animate({queue: !1, opacity: 0 == b ? 1 : 0 }, parseInt(a), d), l++)) : 1 == g ? 1 == x ? 1 == l && 0 < c ? setTimeout(function() {$("#image").css("opacity", "0"); $("#image").animate({queue: !1, opacity: "1"}, parseInt(a), d) }, c) : ($("#image").css("opacity", "0"), $("#image").animate({queue: !1, opacity: "1"}, parseInt(a), d), l++) : 1 == l && 0 < c ? setTimeout(function() {$("#image").css("opacity", "1"); $("#image").animate({queue: !1, opacity: "0"}, parseInt(a), d) }, c) : ($("#image").css("opacity", "1"), $("#image").animate({queue: !1, opacity: "0"}, parseInt(a), d), l++) : $("#image").animate({queue: !1, opacity: 0 == b ? 1 : 0 }, parseInt(a)) }, p = 0, l = 0; d() } q() }, parseInt(F)) });
	</script>
</body>
</html>