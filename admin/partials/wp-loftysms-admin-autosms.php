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
<div class="wrap">
    <div class="col-md-8 col-md-offset-2">
        <div class="row">
            <?php
            if (isset($_GET['code'])) {
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

        <div class="panel panel-primary">
            <div class="panel-heading">
                <?php echo esc_html(get_admin_page_title()); ?>
            </div>
            <div class="panel-body">
                <form method="post" name="loftysms_options" action="<?php echo esc_url(admin_url('admin-post.php')); ?>"
                      enctype="multipart/form-data">
                    <input type="hidden" name="action" value="demography_form">

                    <br>
                    <div class="form-group">
                        <label
                            for="<?php echo $this->plugin_name; ?>-sender"><?php esc_attr_e('SenderID', $this->plugin_name) ?></label>
                        <input name="sender" type="text" required
                               class="form-control" placeholder="SenderID to be displayed on your message"
                               id="<?php echo $this->plugin_name; ?>-sender"
                               maxlength="11"/>

                    </div>
                    <br>
                    <div class="form-group">
                        <label
                            for="<?php echo $this->plugin_name; ?>-loftysms_message_type"><?php esc_attr_e('Message Type to Send', $this->plugin_name) ?></label>
                        <select type="email" class="form-control"
                                id="<?php echo $this->plugin_name; ?>-loftysms_message_type"
                                name="loftysms_message_type">
                            <option value="title">Title + Link</option>
                            <option value="custom">Custom</option>
                        </select>
                        <p class="help">
                            <?php _e('Select Custom if you will prefer to enter the message and link on the post page.', $this->plugin_name); ?>
                                </p>
                    </div>
                    <br>
                    <div>
                        <div class="nav-tabs-horizontal">
                            <ul class="nav nav-tabs" data-plugin="nav-tabs" role="tablist">
                                <li class="active" role="presentation"><a data-toggle="tab"
                                                                          href="#typeRecipients"
                                                                          aria-controls="exampleTabsOne"
                                                                          role="tab">SELECT DEMOGRAPHY</a>
                                </li>
                                <li role="presentation"><a data-toggle="tab" href="#typeNumbers"
                                                           aria-controls="typeNumbers"
                                                           role="tab">TYPE NUMBERS</a></li>
                                <li role="presentation"><a data-toggle="tab" href="#PhonebookSelect"
                                                           aria-controls="exampleTabsTwo"
                                                           role="tab">SELECT FROM PHONEBOOK</a></li>
                            </ul>
                            <div class="tab-content padding-top-20" id="recipients_options">
                                <div class="tab-pane active" id="typeRecipients" role="tabpanel">
                                    <div class="tab-pane active" id="uploadRecipients" role="tabpanel">
                                        <label for="localgovt">Local
                                            Government Areas:</label>
                                        <select class="form-control js-example-basic-multiple"
                                                name="regions[]"
                                                multiple="multiple" required id="localgovt">
                                            <option value="0">--All Local Governments--</option>
                                            <?php
                                            foreach ($message->subregions as $region)
                                                echo '<option value="' . $region->id . '">' . $region->name . '</option>';
                                            ?>
                                        </select>

                                        <label for="allnetworks">Mobile Networks</label>
                                        <select class="form-control js-basic-multiple-network"
                                                name="networks[]"
                                                multiple="multiple" required id="allnetworks">
                                            <option value="0">--All Networks</option>
                                            <?php
                                            foreach ($message->networks as $region)
                                                echo '<option value="' . $region->id . '">' . $region->name . '</option>';

                                            ?>
                                        </select>

                                    </div>
                                </div>
                                <div class="tab-pane" id="PhonebookSelect" role="tabpanel">
                                    <label for="address_book">Add recipients from Address
                                        Book</label>
                                    <div id="show_groups">
                                        <?php
                                        foreach ($message->contact_groups as $group) {
                                            echo '<label class="checkbox-inline"><input
                                                name="contacts[]"
                                                type="checkbox"
                                                multiple
                                                value="' . $group->id . '">' . $group->name . '
                                        </label> ';
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="tab-pane" id="typeNumbers" role="tabpanel">
                                    <label for="recipient">Type Recipients (Separate by comma or space)</label>
                                    <textarea class="form-control" name="recipient" cols="10" rows="5" id="recipient"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="text-center"><em>** All options can be used together
                                **</em></div>
                    </div>
                    <br>
                    <div class="col-md-4">
                        <label for="NumbersGender"
                               class="control-label no-padding-right">Gender:</label>
                        <select name="gender"
                                title="Gender"
                                class="form-control"
                                id="NumbersGender" required>
                            <option value="0">--All Gender--</option>
                            <option value="1">Male</option>
                            <option value="2">Female</option>
                        </select>

                    </div>
                    <div class="col-md-8 form-group">
                        <label for="NumbersNumberToPurchase"
                               class="control-label no-padding-right">Contact
                            Unit you want to be sending to: (0.20 unit per Number)</label>

                        <input name="number"
                               type="number" class="form-control"
                               id="NumbersNumberToPurchase" required/>
                        <p class="help-block blueberry text-justify"> *Please note: the
                            amount for
                            phone
                            numbers will be deducted from
                            your
                            account along with the SMS amount.</p>
                    </div>
                    <?php submit_button(__('Save Settings', 'primary', 'submit', TRUE)); ?>

                </form>
            </div>
        </div>


    </div>
</div>