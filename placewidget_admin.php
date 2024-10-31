<?php
function show_admin() {
    $PW_PLUGIN_PATH = WP_PLUGIN_URL.'/'.str_replace(basename(__FILE__),"",plugin_basename(__FILE__));
    if(isset($_POST['venue_name']) && isset($_POST['embed_code'])) {
        update_option("pw_venue_name", $_POST['venue_name']);
        update_option("pw_embed_code", $_POST['embed_code']);
    }
    $cur_venue_name = get_option("pw_venue_name");
?>
<style type="text/css">
    #pw-loading {
        position:absolute;
        top:10px;
        right:-30px;
        display:none;
    }
    
    #pw_forms {
        float:left;
        width:500px;
        margin-right:50px;
        position:relative;
    }
    
    #pw_sample {
        float:left;
    }
    #venue_results label {
         display:block;
    }
</style>
<div class="wrap">
    <h2>PlaceWidget for Wordpress</h2>
    <div id="pw_forms">
        <p>
            Use the form below to pick a venue for your PlaceWidget, then go to the
            <a href="<?php echo admin_url(); ?>widgets.php">Wordpress widgets settings page</a>
            and add the widget to your theme.
        </p>
        
        <?php if($cur_venue_name) { ?>
        <p><strong>Current venue: <?php echo $cur_venue_name; ?></strong></p>
        <?php } ?>
    
        <form id="venue-find">
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Venue Name</th>
                    <td>
                        <input type="text" name="venue_name" value="" id="venue_name" />
                    </td>
                </tr>
                
                <tr valign="top">
                    <th scope="row">Location <small>(address, city, state, country)</small></th>
                    <td>
                        <input type="text" name="location" value="" id="venue_location" />
                    </td>
                </tr>
                
                <tr valign="top">
                    <td colspan="2">
                        <input type="submit" class="button" value="<?php _e('Find Venue') ?>" />
                    </td>
                </tr>
                
                <tr valign="top">
                    <td colspan="2">
                        <div id="venue_results"></div>
                        <div id="find-venue-error"></div>
                    </td>
                </tr>
            </table>
        </form>
        
        <form>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Widget Width</th>
                    <td>
                        <select id="size" name="size">
                            <option value="160">160px</option>
                            <option value="200">200px</option>
                            <option value="250">250px</option>
                        </select>
                    </td>
                </tr>
                
                <tr valign="top">
                    <th scope="row">Update Interval<br /><small>A longer update interval will make the widget load faster, but data won't be as up-to-date</small></th>
                    <td>
                        <select id="interval" name="interval">
                            <option value="1">1 minute</option>
                            <option value="15">15 minutes</option>
                            <option value="30">30 minutes</option>
                            <option value="60">1 hour</option>
                            <option value="360">6 hours</option>
                            <option value="720">12 hours</option>
                        </select>
                    </td>
                </tr>
                <tr valign="top">
                    <td colspan="2">
                        <input type="button" id="widget-submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
                        <div id="widget-embed-error"></div>
                    </td>
                </tr>
            </table>
        </form>
        
        <div id="pw-loading"><img src="<?php echo $PW_PLUGIN_PATH ?>loading.gif" alt="Loading indicator" /></div>
        
    </div>
    
    <div id="pw_sample">
        <img id="example-widget" alt="Example Widget" src="http://www.placewidget.com/static/images/example_widget.png"/>
    </div>
    
    <div class="clear"></div>

</div>

<form id="save-settings" method="post">
    <input type="hidden" name="venue_name" id="save-venue-name" />
    <input type="hidden" name="embed_code" id="save-embed-code" />
</form>

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/mootools/1.2.4/mootools-yui-compressed.js"></script>
<script type="text/javascript" src="<?php echo $PW_PLUGIN_PATH ?>mootools-1.2.4.2-more.js"></script>
<script type="text/javascript" src="<?php echo $PW_PLUGIN_PATH ?>create.js"></script>

<?php } ?>
