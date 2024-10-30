<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://www.femtosh.com
 * @since      1.0.0
 *
 * @package    Wp_Loftysms
 * @subpackage Wp_Loftysms/admin/partials
 */


?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wrap" xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html">
    <!--?php
    settings_errors();
    ?-->
    <div class="row">
        <?php
        if (isset($_GET['code']) && isset($_GET['message'])) {
            if ($_GET['code'] == 200) {
                echo '<div class="alert alert-success">
            <ul>
                   <li>' . urldecode($_GET['message']) . '</li>
              </ul>
        </div>';
            } else {
                echo '<div class="alert alert-danger">
            <ul>
                   <li>' . urldecode($_GET['message']) . '</li>
              </ul>
        </div>';
            }
        }
        ?>
    </div>
    <div class="col-md-8 col-md-offset-2">
        <!-- Example Panel Fullscreen -->
        <div class="panel panel-primary">
            <div class="panel-heading">
                <?php echo esc_html(get_admin_page_title()); ?>
                <span
                    class="pull-right">Total Balance: <?php echo($message->user->balance) ?></span>
            </div>
            <div class="panel-body">
                <div class="row">
                    <form role="form" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post"
                          enctype="multipart/form-data">
                        <input type="hidden" name="action" value="contact_form">

                        <div class="form-group">
                            <div class="col-md-5">
                                <label>Sender ID</label>
                                <input name="sender" type="text" required class="form-control"
                                       id="sender"
                                       maxlength="11"/>

                            </div>

                        </div>

                        <div class="col-md-3">
                            <label for="route">ROUTE</label>
                            <select class="form-control" name="sms_route" required="" id="route">
                                <?php foreach ($message->routes as $route) {
                                    echo '<option value="' . $route->id . '">' . $route->name . '</option >';
                                }; ?>

                            </select>
                            <?php
                            echo '<span class="info"><a href="https://www.loftysms.com/' . strtolower($message->user->country) . '' . '/routes"
                                                  target="_blank"> Click to find more about routes </a></span>';
                            ?>
                        </div>
                        <div class="col-md-3">
                            <label for="route"> Message Type </label>
                            <select class="form-control" name="sms_type" required="" id="route">
                                <option value="1"> Plain SMS</option>
                                <option value="2"> Flash SMS</option>
                            </select>

                            <span class="info"><a href="http://www.ozekisms.com/index.php?owpn=545"
                                                  target="_blank"> Click to find more about SMS message types

</a></span>
                        </div>
                        <div class="form-group">
                            <div class="col-md-8">
                                <label> Recipients</label>
                                <textarea class="form-control"
                                          placeholder="Enter recipients in the format phone,phone,phone. Duplicates would be filtered out"
                                          name="recipient" id="recipients" rows="6"
                                ></textarea>
                                <!--p class="text-muted"> Number of recipients recorded: <span
                                        id="no_of_recipients"> 0</span>
                                    recipients</p-->
                            </div>

                            <div class="col-md-4">
                                <label for="address_book"> Add recipients from address
                                    Book </label>
                                <select id="address_book" class="form-control" multiple name="contacts[]">
                                    <?php
                                    foreach ($message->contact_groups as $group) {
                                        echo '<option value="' . $group->id . '">' . $group->name . '</option>';
                                    }
                                    ?>
                                </select>
                                <!--div>
                                    <label for="text_file">Or Upload a text(.txt) file </label>

                                    <div class="row">
                                        <div class="col-xs-8"><input type="file" id="files" name="file"/>
                                        </div>
                                    </div>
                                </div-->
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8">
                                <label for="message"> Message</label>
                                <textarea name="message" rows="6" class="form-control" id="message"
                                          required></textarea>

                                <!--p class="text-muted"><span class="char_count"> 0</span> Characters |
                                    Page(s): <span
                                        id="page_count"> 1</span></p-->
                            </div>

                        </div>

                        <div class="form-group">
                            <div class="col-md-4">

                                <label class="checkbox">

                                    <input type="checkbox" id="chkschedule" name="chkschedule" value="1"> Schedule
                                    Message
                                </label>
                                <span class="text-info"> Check this box before scheduling </span><br/>

                                <div id="divscheduler">
                                    <label> Date to Send </label><br/>
                                    <input type="date" class="input-sm" name="schedule_date" id="datescd">
                                    <br/>
                                    <label> Send Time </label><br/>
                                    <input type="time" class="input-sm" name="schedule_time" id="datescd">
                                </div>

                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6">
                                <div class="uk-margin">
                                    <h3> DND Management </h3>
                                    <div class="uk-margin-large-bottom">

                                        <label>
                                            <p><input class="uk-radio" type="radio" name="corporate"
                                                      value="1" checked/> Use Corporate Route for only DND
                                                Phone Numbers </p>
                                        </label>
                                        <label>
                                            <p><input class="uk-radio" type="radio" name="corporate"
                                                      value="2"/> Use Corporate Route for all the phone
                                                numbers </p>
                                        </label>
                                        <label>
                                            <p><input class="uk-radio" type="radio" name="corporate"
                                                      value="3"/> Disregard Phone Numbers on DND & Don't
                                                charge</p>
                                        </label>


                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-3">
                                <?php submit_button(__('Send Message', 'primary', 'submit', TRUE)); ?>

                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>