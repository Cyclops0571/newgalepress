<?php

if(!isset($files)) $files = array();
if(!isset($modal)) $modal = 0;
if(!isset($transparent)) $transparent = 0;
if(!isset($bgcolor)) $bgcolor = '#151515';
$myArray = array();
$counter=0;
foreach($files as $file)
{
    //$filename = path('public').$file->Value;
    $filename = path('public').$file;
    if(File::exists($filename) && is_file($filename)) {
        $fname = File::name($filename);
        $fext = File::extension($filename);
        $filename = $fname.'.'.$fext;
        if(!$preview)
        {
            $vFile = $baseDirectory.'comp_'.$id.'/'.$filename;
            $baseDirectory = $baseDirectory . "gal360";
            $myArray[$counter] = $vFile;
            $counter++;
        }
        else
        {
            $vFile = '/'.$file;
            $baseDirectory = $baseDirectory . "comp_";
            $myArray[$counter] = $vFile;
            $counter++;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en-US">
<head>
    <title>Gale Press</title>
    <meta name="Description" content="" />
    <meta name="viewport" content="user-scalable=no" />
    <script src="{{ $baseDirectory }}/jquery.min.js" type="text/javascript"></script>
    <script src="{{ $baseDirectory }}/jquery.mobile.vmouse.js" type="text/javascript"></script>
    <script src="{{ $baseDirectory }}/javascriptviewer_jso.js" type="text/javascript"></script>
    <style type="text/css">
        body,html{
            margin: 0 !important;
            overflow: hidden !important;
        }
        #loading{
            position: absolute;
            top: 10px;
            left: 10px;
            z-index: 999999;
        }
        *{
            -webkit-tap-highlight-color: transparent !important;
        }
    </style>
</head>
<body>

<div id="image_holder_x">
    <img id="product_image_x" src="{{$vFile}}" style="position:relative;width:100%;height:auto;opacity:0"/>
    <img src="{{ $baseDirectory }}/img/gale.png" id="loading">
</div>

<script type="text/javascript">
    $(document).ready(function () {
        var presentation_x = new javascriptViewer($('#product_image_x'),{
            total_frames: {{ count($files) }},
            target_id: 'image_holder_x',
            images_src: <?php echo json_encode($myArray);?>
        });
        var counter=0;
        $(presentation_x).on('loadImageProgress', function(e, number, perc) {
            counter=counter+(360/{{ count($files) }});
            $('#product_image_x').css('opacity',perc/100);
            //$('#loading').css('opacity',perc/100);
            $('#loading').css({transform: 'rotate(' + counter + 'deg)'});
        });
        $(presentation_x).on('loadImageEnd', function() {
            $("#loading").fadeOut(2000);
        });
        presentation_x.start();
    });
</script>
</body>
</html>