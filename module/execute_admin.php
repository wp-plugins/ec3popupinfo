<?php
/*
 * Setting Screen
 * call: execute_admin($this);
 * -*- Encoding: utf8n -*-
 */
function execute_admin(&$obj) {
    //print_r($_REQUEST);
    //print_r($obj->model);
    //echo phpinfo();

    if (is_array($_REQUEST)) {
        // Array extract to variable
        extract($_REQUEST);
    }

    ?>
    <h2>Ec3popupinfo</h2>
    <form name="formEc3popupinfo" method="post">
        
    <?php
      if ($save) {
          //echo $qf_getthumb;
          $msg = save($obj);
      }
    edit($obj, $msg);
    
    echo '</form>';
}

function save(&$obj) {
    //print_r($_REQUEST);
    if (is_array($_REQUEST)) {
        // Array extract to variable
        extract($_REQUEST);
    }

    $model = &$obj->model;
    $model->setData($ec3popupinfo_data);
    $model->setHoliday($ec3popupinfo_holiday);
    $model->setHolidayCss($ec3popupinfo_holiday_css);
    $obj->updateWpOption($model); // Save database-model
    return $msg .= __('Saved', 'ec3popupinfo');
}

function edit(&$obj, $msg = '') {
    if ($msg) {
        printf("<div class=\"msg\">%s</div>", $msg);
    }

    $model = $obj->model;
    $data = $model->getData();
    $ec3popupinfo_holiday = $model->getHoliday();
    $ec3popupinfo_holiday_css = $model->getHolidayCss();

    ?>
      <fieldset><legend>Holiday</legend>
        style css: <input type="text" name="ec3popupinfo_holiday_css" size="50" value="<?php echo $ec3popupinfo_holiday_css; ?>" />
          <textarea name="ec3popupinfo_holiday" cols="90" rows="20"><?php echo $ec3popupinfo_holiday; ?></textarea>
            </fieldset>
    
    <fieldset><legend>Ec3popupinfo</legend>
      <textarea name="ec3popupinfo_data" cols="90" rows="20"><?php echo $data; ?></textarea>
        <p>Data line: Year,Month,day,day of the week,message</p>
        <p>Example:<br />
          2010,7,4,Sun,Independence day<br />
            2010,12,25,Sat,Christmas&lt;br&gt;:-)
  </p>
    <p>
      Popup message is :<br />
&lt;!-- ec3popupinfo_layer1 --&gt;<br />
&lt;div id="ec3popupinfo_layer1"&gt;<br />
  &lt;span class="holiday"&gt; holiday message &lt;/span&gt;<br />
  &lt;span class="ec3popupinfo"&gt; ec3popupinfo message &lt;/span&gt;<br />
&lt;/div&gt;<br />
&lt;!-- end of ec3popupinfo_layer1 --&gt;<br />
</p>
  <input type="submit" name="save" value="<?php _e('Save', 'ec3popupinfo')?>" />
    <?php
      echo '</fieldset>';
}


?>
