<?php
/*
 * ec3popupinfo.js.php
 * -*- Encoding: utf8n -*-
 *
 * Don't named 'class' and 'start' to variable at IE6.
 * Be an error when assign an object to not declared variable, Don't foget var.
 * Javascript Online Lint:
 *   http://www.javascriptlint.com/online_lint.php
 */
?>

<script type="text/javascript">
//<![CDATA[

<?php
$wpEc3popupinfo = & new WpEc3popupinfo();
$model = $wpEc3popupinfo->model;
//print_r($model);
$data = $model->getData();
$ec3popupinfo_holiday = $model->getHoliday();
$ec3popupinfo_holiday_css = $model->getHolidayCss();

//
$records = split("\n", $data);
foreach ($records as $key => $record) {
    $record = trim($record);
    $f = split(",", $record, 5);
    $da['#ec3_' . $f[0] . '_' . $f[1] . '_' . $f[2]]['day_of_the_week'] = $f[3];
    $da['#ec3_' . $f[0] . '_' . $f[1] . '_' . $f[2]]['msg'] = $f[4];
}

//
$records = split("\n", $ec3popupinfo_holiday);
//print_r($records);
foreach ($records as $key => $record) {
    $record = trim($record);
    $f = split(",", $record, 5);
    $ho['#ec3_' . $f[0] . '_' . $f[1] . '_' . $f[2]]['day_of_the_week'] = $f[3];
    $ho['#ec3_' . $f[0] . '_' . $f[1] . '_' . $f[2]]['msg'] = $f[4];
}

//print_r($da);
echo 'function ec3popupinfo_js() {';
$y = date("Y");
$m = date("m");
$d = date("d");
$cssa = array();
for ($i = -62; $i < 62; $i++) {
    $target = '#ec3_' . date("Y_n_j", mktime(0,0,0, $m, $d + $i, $y));
    $mm = date("n", mktime(0,0,0, $m, $d + $i, $y));
    if ($i > 0 && $mm > ($m + 2)) { break; }
    
    if ($i == 0) {
        $id = '#today';
    } else {
        $id = $target;
    }
    
    $msg = '';
    $hmsg = $ho[$target]['msg'];
    $kmsg = $da[$target]['msg'];
    if (!$hmsg && !$kmsg) { continue; }
    if ($hmsg) {
        array_push($cssa, $id);
        $msg = '<span class="holiday">' . $hmsg . '</span>';
        if ($kmsg) $msg .= '<br />';
    }
    if ($kmsg) $msg .= '<span class="ec3popupinfo">' . $kmsg . '</span>';
    
    if ($msg) {
        echo "ec3popupinfo_popup('" . $id . "', '#ec3popupinfo_layer1', '" .  $msg . "');\n";
    }
}
echo '}';
?>

jQuery(document).ready(function(){
    ec3popupinfo_set_layer();
    ec3popupinfo_js();
    
    /*
    var target = "#ec3_2010_1_5";
    var layer = "#ec3popupinfo_layer1";
    ec3popupinfo_popup(target, layer, '1/5');

    var target = "#ec3_2010_1_6";
    var layer = "#ec3popupinfo_layer1";
    ec3popupinfo_popup(target, layer, '1/6');
     */

    /* Wait while event-calendar script to finish */
    var delay = 500;
    
    jQuery("#ec3_prev").click(function(event){
        var tid = setTimeout("ec3popupinfo_js()", delay);
    });
    
    jQuery("#ec3_next").click(function(event){
        var tid = setTimeout("ec3popupinfo_js()", delay);
    });
    
});


function ec3popupinfo_set_layer() {
    var popuphtml = '<!-- ec3popupinfo_layer1 --><div id="ec3popupinfo_layer1" style="position: absolute; z-index: 99; visibility: hidden; left: 45px; top: 33px;"></div><!-- end of ec3popupinfo_layer1 -->';
    jQuery("body").append(popuphtml);
}

function ec3popupinfo_popup(target, layer, text) {
    //var target = "#ec3_2010_1_5";
    //var layer = "#ec3popupinfo_layer1";
    //jQuery(target).removeAttr("title").mouseover(function(){
    
    jQuery(target).mouseover(function(){
        jQuery(layer).html(text);
    }).mousemove(function(e){
        if (jQuery(layer).css("visibility") == "visible") return;
        jQuery(layer).css('left',e.pageX + 20);
        jQuery(layer).css('top',e.pageY - 20);
        jQuery(layer).css("visibility", "visible");
    }).mouseout(function(){
        jQuery(layer).css("visibility", "hidden");
    });

    jQuery(layer).removeAttr("title").mouseover(function(){
        jQuery(layer).css("visibility", "visible");
    }).mouseout(function(){
        jQuery(layer).css("visibility", "hidden");
    });
    
}

//]]>
</script>
<style type="text/css">
<?php echo join(',', $cssa) . '{' . $ec3popupinfo_holiday_css . '}'; ?>
</style>

