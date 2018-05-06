<?php
global $wpie_init, $wpie_product, $wpie_product_category, $wpie_user, $wpie_scheduled;

$product_category_list = $wpie_product_category->wpie_get_product_category();

$get_schedules_list = wp_get_schedules();

$product_cat_fields = $wpie_product_category->get_updated_product_cat_fields();

$product_cat_scheduled_export_list = $wpie_scheduled->get_product_cat_scheduled_data();

$product_cat_scheduled_import_list = $wpie_scheduled->get_product_cat_import_scheduled_data();

$log_list = $wpie_product_category->wpie_get_product_categories_export_log();

$import_log_list = $wpie_product_category->wpie_get_product_categories_import_log();

$total_product_category = count($product_category_list) < 2000 ? count($product_category_list) : "2000+";
?>
<div class="wpie-process-notification">
    <div class="wpie-process-percentage">0</div>
    <div class="wpie-process-notification-content">% <?php _e('Please Wait...', WPIE_TEXTDOMAIN); ?></div>
</div>
<div class="wpie_success_msg" wpie_wait_msg="<?php _e('Please Wait...', WPIE_TEXTDOMAIN) ?>"><?php _e('Please Wait...', WPIE_TEXTDOMAIN) ?></div>
<div class="wpie-page-wrapper">
    <div class="container-fluid offset-10">
        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
            <div class="wpie-page-section-header wpie-red-section wpie-page-active-section" wpie-container="wpie-filter-wrapper">
                <div class="wpie-header-title-count"><?php _e('Export', WPIE_TEXTDOMAIN); ?></div>
                <div class="wpie-header-title-content"><?php _e('Product Categories', WPIE_TEXTDOMAIN); ?></div>
                <div class="wpie-header-title-subtitle"><?php
                    echo $total_product_category . " ";
                    _e('Available product categories in store.', WPIE_TEXTDOMAIN);
                    ?>
                </div>
                <div class="wpie-header-title-image wpie-export-image"></div>
            </div>
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
            <div class="wpie-page-section-header wpie-green-section" wpie-container="wpie-import-wrapper">
                <div class="wpie-header-title-count"><?php _e('Import', WPIE_TEXTDOMAIN); ?></div>
                <div class="wpie-header-title-content"><?php _e('Product Categories', WPIE_TEXTDOMAIN); ?></div>
                <div class="wpie-header-title-subtitle"><?php _e('Import unlimited product categories.', WPIE_TEXTDOMAIN); ?></div>
                <div class="wpie-header-title-image wpie-import-image"></div>
            </div>
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
            <div class="wpie-page-section-header wpie-aqua-section" wpie-container="wpie-scheduled-wrapper">
                <div class="wpie-header-title-count"><?php _e('Schedule', WPIE_TEXTDOMAIN); ?></div>
                <div class="wpie-header-title-content"><?php _e('Management', WPIE_TEXTDOMAIN); ?></div>
                <div class="wpie-header-title-subtitle"><?php _e('schedule import export.', WPIE_TEXTDOMAIN); ?></div>
                <div class="wpie-header-title-image wpie-schedule-image"></div>
            </div>
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
            <div class="wpie-page-section-header wpie-color-section1" wpie-container="wpie-advanced-wrapper"> 
                <div class="wpie-header-title-count"><?php _e('Advance', WPIE_TEXTDOMAIN); ?></div>
                <div class="wpie-header-title-content"><?php _e('Products Categories', WPIE_TEXTDOMAIN); ?></div>
                <div class="wpie-header-title-subtitle"><?php _e('Configure import export', WPIE_TEXTDOMAIN); ?></div>
                <div class="wpie-header-title-image wpie-settings-image"></div>
            </div>
        </div>
    </div>
    <div class="container-fluid offset-10 wpie-filter-wrapper  wpie-main-frm-wrapper  wpie-page-active-section-data">
        <form class="wpie-product-csv-download" method="post">
            <input type="hidden" value="" class="wpie-product-csv-file-name" name="wpie-product-csv-file-name">
        </form>
        <form method="post" class="wpie-product-categories-export-frm wpie-general-frm">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="wpie-filter-inner-wrapper">
                    <div class="wpie-filter-title-text-wrapper">
                        <div class="wpie-filter-title-text"><?php _e('Filter By Product Category', WPIE_TEXTDOMAIN); ?></div>
                        <div class="wpie-filter-title-text-sub-title">(<?php
                            _e('Total Categories', WPIE_TEXTDOMAIN);
                            echo " : " . $total_product_category;
                            ?> )</div>
                    </div>
                    <div class="wpie-filter-input-wrapper">
                        <select class="wpie-select-chosen"  name="wpie_product_category[]" multiple="multiple" data-placeholder="<?php _e('Select Product Categories', WPIE_TEXTDOMAIN); ?>">
                            <?php
                            foreach ($product_category_list as $wpie_category) {
                                echo '<option value="' . $wpie_category->term_id . '">#' . $wpie_category->term_id . ' ' . $wpie_category->name . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="wpie-filter-input-hint-wrapper">
                        <div class="wpie-filter-input-hint"><?php _e('Default : All Categories', WPIE_TEXTDOMAIN); ?></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="wpie-filter-inner-wrapper">
                    <div class="wpie-filter-title-text-wrapper">
                        <div class="wpie-filter-title-text"><?php _e('Limit Records', WPIE_TEXTDOMAIN); ?></div>
                        <div class="wpie-filter-title-text-sub-title">(<?php
                            _e('Total Records', WPIE_TEXTDOMAIN);
                            echo " : " . $total_product_category;
                            ?> )</div>
                    </div>
                    <div class="wpie-filter-input-wrapper">
                        <input type="text" class="wpie-filter-input" name="wpie_total_records" placeholder="<?php _e('Enter Limit Records', WPIE_TEXTDOMAIN); ?>"/>
                    </div>
                    <div class="wpie-filter-input-hint-wrapper">
                        <div class="wpie-filter-input-hint"><?php _e('Default : All Records', WPIE_TEXTDOMAIN); ?></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="wpie-filter-inner-wrapper">
                    <div class="wpie-filter-title-text-wrapper">
                        <div class="wpie-filter-title-text"><?php _e('Offset Records', WPIE_TEXTDOMAIN); ?></div>
                        <div class="wpie-filter-title-text-sub-title">(<?php
                            _e('Total Records', WPIE_TEXTDOMAIN);
                            echo " : " . $total_product_category;
                            ?> )</div>
                    </div>
                    <div class="wpie-filter-input-wrapper">
                        <input type="text" class="wpie-filter-input" name="wpie_offset_records" placeholder="<?php _e('Enter Offset Records', WPIE_TEXTDOMAIN); ?>"/>
                    </div>
                    <div class="wpie-filter-input-hint-wrapper">
                        <div class="wpie-filter-input-hint"><?php _e('Default : 0', WPIE_TEXTDOMAIN); ?></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="wpie-filter-inner-wrapper">
                    <div class="wpie-filter-title-text-wrapper">
                        <div class="wpie-filter-title-text"><?php _e('CSV Field Separator', WPIE_TEXTDOMAIN); ?></div>
                    </div>
                    <div class="wpie-filter-input-wrapper">
                        <input type="text" name="wpie_export_separator" class="wpie-filter-input wpie_export_separator" placeholder="<?php _e('Enter Field Separator', WPIE_TEXTDOMAIN); ?>" value=","/>
                    </div>
                    <div class="wpie-filter-input-hint-wrapper">
                        <div class="wpie-filter-input-hint"><?php _e('Default : comma ( , )', WPIE_TEXTDOMAIN); ?></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="wpie-filter-inner-wrapper">
                    <div class="wpie-filter-title-text-wrapper">
                        <div class="wpie-filter-title-text"><?php _e('Scheduled Export', WPIE_TEXTDOMAIN); ?></div>
                        <div class="wpie-filter-title-text-sub-title"></div>
                    </div>
                    <div class="wpie-filter-input-wrapper">
                        <input type="checkbox" id="wpie-product-scheduled-export" class="wpie-filter-input-check wpie-scheduled-export-check-data" name="wpie_product_scheduled_export" placeholder="<?php _e('Enter Offset Records', WPIE_TEXTDOMAIN); ?>"/>
                        <label for="wpie-product-scheduled-export" class="wpie-product-scheduled-export-label"><?php _e('Scheduled Export', WPIE_TEXTDOMAIN); ?></label>
                        <div class="wpie-scheduled-export-wrapper">
                            <div class="wpie-scheduled-export-outer-details">
                                <div class="wpie-scheduled-export-inner">
                                    <div class="wpie-scheduled-export-data-label"><?php _e('Export Interval', WPIE_TEXTDOMAIN); ?></div>
                                    <div class="wpie-scheduled-export-data-element-wrapper">
                                        <select class="wpie-export-field-select-element wpie-select-chosen" data-placeholder="<?php _e('Select Interval', WPIE_TEXTDOMAIN); ?>" name="wpie_export_interval">
                                            <?php foreach ($get_schedules_list as $key => $value) { ?>
                                                <option value="<?php echo $key; ?>"><?php echo $value['display']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="wpie-scheduled-export-inner">
                                    <div class="wpie-scheduled-export-data-label"><?php _e('Export Interval Time', WPIE_TEXTDOMAIN); ?></div>
                                    <div class="wpie-scheduled-export-data-element-wrapper">
                                        <input class="wpie-filter-input wpie-scheduled-export-time" type="text" placeholder="<?php _e('Enter Time for export', WPIE_TEXTDOMAIN); ?>" name="wpie_scheduled_export_time">
                                        <div class="wpie-filter-input-hint"><?php _e('Value : 00:00:01 to 23:59:59, Default : Current time', WPIE_TEXTDOMAIN); ?></div>
                                    </div>
                                </div>
                                <div class="wpie-scheduled-export-inner">
                                    <div class="wpie-scheduled-export-data-label"><?php _e('Send E-mail', WPIE_TEXTDOMAIN); ?></div>
                                    <div class="wpie-scheduled-export-data-element-wrapper">
                                        <input type="checkbox" class="wpie-filter-input-check wpie-scheduled-send-email" id="wpie-scheduled-send-email" name="wpie_product_scheduled_send_email" value="1"/>
                                        <label for="wpie-scheduled-send-email" class="wpie-product-scheduled-export-label"><?php _e('Send E-mail with attachment', WPIE_TEXTDOMAIN); ?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="wpie-scheduled-export-email-details">
                                <div class="wpie-scheduled-export-inner">
                                    <div class="wpie-scheduled-export-data-label"><?php _e('Enter Email Recipient(s)', WPIE_TEXTDOMAIN); ?></div>
                                    <div class="wpie-scheduled-export-data-element-wrapper">
                                        <input class="wpie-filter-input wpie-scheduled-export-email-recipients" type="text" placeholder="<?php _e('Enter Email Recipient(s)', WPIE_TEXTDOMAIN); ?>" name="wpie_scheduled_export_email_recipients">
                                        <div class="wpie-filter-input-hint">Ex. example@gmail.com, demo@yahoo.com</div>
                                    </div>
                                </div>
                                <div class="wpie-scheduled-export-inner">
                                    <div class="wpie-scheduled-export-data-label"><?php _e('Enter Email Subject', WPIE_TEXTDOMAIN); ?></div>
                                    <div class="wpie-scheduled-export-data-element-wrapper">
                                        <input class="wpie-filter-input wpie-scheduled-export-email-subject" type="text" placeholder="<?php _e('Enter Email Subject', WPIE_TEXTDOMAIN); ?>" name="wpie_scheduled_export_email_subject">
                                    </div>
                                </div>
                                <div class="wpie-scheduled-export-inner">
                                    <div class="wpie-scheduled-export-data-label"><?php _e('Enter Email message', WPIE_TEXTDOMAIN); ?></div>
                                    <div class="wpie-scheduled-export-data-element-wrapper">
                                        <textarea class="wpie-scheduled-export-email-content wpie-filter-input wpie-filter-input-textarea" name="wpie_scheduled_export_email_content" placeholder="<?php _e('Enter Email message', WPIE_TEXTDOMAIN); ?>"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="wpie-filter-input-hint-wrapper"></div>
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="wpie-filter-btn-wrapper">
                    <a class="wpie-general-btn wpie-product-categories-export-preview" ><?php _e('Preview', WPIE_TEXTDOMAIN); ?></a>
                    <a class="wpie-general-btn wpie-product-categories-export" ><?php _e('Export', WPIE_TEXTDOMAIN); ?></a>
                    <a class="wpie-general-btn wpie-product-categories-scheduled-export-data wpie-scheduled-save-export-data wpie-hidden" ><?php _e('Save Scheduled', WPIE_TEXTDOMAIN); ?></a>
                </div>
            </div>
        </form>
        <div class="wpie-filter-data-container wpie-datatable-wrapper-sample">
            <table class="wpie-product-filter-data wpie-datatable table table-striped table-bordered" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <?php
                        foreach ($product_cat_fields as $new_product_cat_fields) {
                            foreach ($new_product_cat_fields as $product_cat_fields_data)
                                if ($product_cat_fields_data['field_display'] == 1) {
                                    echo '<th>' . $product_cat_fields_data['field_title'] . '</th>';
                                }
                        }
                        ?>
                    </tr>

                </thead>
            </table>
        </div>
        <div class="wpie-filter-data-container wpie-datatable-wrapper">

        </div>
    </div>
    <div class="container-fluid offset-10 wpie-import-wrapper wpie-main-frm-wrapper">
        <form method="post" class="wpie-product-cat-import-frm wpie-general-frm">
            <input type="hidden" name="wpie_csv_upload_file" class="wpie_csv_upload_file_path" value=""> 
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="wpie-filter-inner-wrapper">
                    <div class="wpie-filter-input-wrapper">
                        <div class="wpie-csv-upload-wrapper">
                            <div id="wpie-upload-container" class="wpie-upload-container">
                                <div id="wpie-upload-drag-drop" class="wpie-upload-drag-drop">
                                    <div class="wpie-upload-file-label"><?php _e('Drop CSV file here', WPIE_TEXTDOMAIN); ?></div>
                                    <div class="wpie-upload-file-label-small"> <?php _e('OR', WPIE_TEXTDOMAIN); ?></div>
                                    <div class="wpie-upload-file-btn"><input id="plupload-browse-button" type="button" value="<?php _e('Select Files', WPIE_TEXTDOMAIN); ?>" class="button" /></div>
                                </div>

                            </div>
                            <div class="wpie-uploaded-file-list">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="wpie-filter-inner-wrapper">
                    <div class="wpie-filter-title-text-wrapper">
                        <div class="wpie-filter-title-text"><?php _e('Enter URL to Import', WPIE_TEXTDOMAIN); ?></div>
                    </div>
                    <div class="wpie-filter-input-wrapper">
                        <input type="text" name="wpie_import_file_url" class="wpie-filter-input wpie_import_file_url" placeholder="<?php _e('Enter URL', WPIE_TEXTDOMAIN); ?>"/>

                    </div>
                    <div class="wpie-filter-input-hint-wrapper">
                        <div class="wpie-filter-input-hint"><?php _e('Note : Leave blank if upload file.', WPIE_TEXTDOMAIN); ?></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="wpie-filter-inner-wrapper">
                    <div class="wpie-filter-title-text-wrapper">
                        <div class="wpie-filter-title-text"><?php _e('Product Category Update / Skip', WPIE_TEXTDOMAIN); ?></div>
                    </div>
                    <div class="wpie-filter-input-wrapper">
                        <select class="wpie-select-chosen" name="wpie_product_cat_create_method"  data-placeholder="<?php _e('Select Product Category Create', WPIE_TEXTDOMAIN); ?>" >
                            <option value="skip_product_cat"><?php _e('Skip Product Category if Exist.', WPIE_TEXTDOMAIN); ?></option>
                            <option value="update_product_cat"><?php _e('Update Product Category if Exist.', WPIE_TEXTDOMAIN); ?></option>
                        </select>
                    </div>
                    <div class="wpie-filter-input-hint-wrapper">
                        <div class="wpie-filter-input-hint"><?php _e('Note : Imported product is skip, updated or created if already exist.', WPIE_TEXTDOMAIN); ?></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="wpie-filter-inner-wrapper">
                    <div class="wpie-filter-title-text-wrapper">
                        <div class="wpie-filter-title-text"><?php _e('Product Categories Search based on', WPIE_TEXTDOMAIN); ?></div>
                    </div>
                    <div class="wpie-filter-input-wrapper">
                        <select class="wpie-select-chosen" name="wpie_data_update_option"  data-placeholder="<?php _e('Select Product Categories Search Option', WPIE_TEXTDOMAIN); ?>" >
                            <option value="category_slug"><?php _e('Category Slug', WPIE_TEXTDOMAIN); ?></option>
                            <option value="category_id"><?php _e('Category ID', WPIE_TEXTDOMAIN); ?></option>
                        </select>
                    </div>
                    <div class="wpie-filter-input-hint-wrapper">
                        <div class="wpie-filter-input-hint"><?php _e('Default : Category Slug', WPIE_TEXTDOMAIN); ?></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="wpie-filter-inner-wrapper">
                    <div class="wpie-filter-title-text-wrapper">
                        <div class="wpie-filter-title-text"><?php _e('CSV Field Separator', WPIE_TEXTDOMAIN); ?></div>
                    </div>
                    <div class="wpie-filter-input-wrapper">
                        <input type="text" name="wpie_import_determinator" class="wpie-filter-input wpie_import_determinator" placeholder="<?php _e('Enter Field Separator', WPIE_TEXTDOMAIN); ?>" value=","/>
                    </div>
                    <div class="wpie-filter-input-hint-wrapper">
                        <div class="wpie-filter-input-hint"><?php _e('Default : comma ( , )', WPIE_TEXTDOMAIN); ?></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="wpie-filter-inner-wrapper">
                    <div class="wpie-filter-title-text-wrapper">
                        <div class="wpie-filter-title-text"><?php _e('Scheduled Import', WPIE_TEXTDOMAIN); ?></div>
                        <div class="wpie-filter-title-text-sub-title"></div>
                    </div>
                    <div class="wpie-filter-input-wrapper">
                        <input type="checkbox" id="wpie-product-scheduled-import" class="wpie-filter-input-check wpie-scheduled-export-check-data" name="wpie_product_scheduled_export" placeholder="<?php _e('Enter Offset Records', WPIE_TEXTDOMAIN); ?>"/>
                        <label for="wpie-product-scheduled-import" class="wpie-product-scheduled-export-label"><?php _e('Scheduled Import', WPIE_TEXTDOMAIN); ?></label>
                        <div class="wpie-scheduled-export-wrapper">
                            <div class="wpie-scheduled-export-outer-details">
                                <div class="wpie-scheduled-export-inner">
                                    <div class="wpie-scheduled-export-data-label"><?php _e('Import Interval', WPIE_TEXTDOMAIN); ?></div>
                                    <div class="wpie-scheduled-export-data-element-wrapper">
                                        <select class="wpie-export-field-select-element wpie-select-chosen" data-placeholder="<?php _e('Select Interval', WPIE_TEXTDOMAIN); ?>" name="wpie_import_interval">
                                            <?php foreach ($get_schedules_list as $key => $value) { ?>
                                                <option value="<?php echo $key; ?>"><?php echo $value['display']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="wpie-scheduled-export-inner">
                                    <div class="wpie-scheduled-export-data-label"><?php _e('Import Interval Time', WPIE_TEXTDOMAIN); ?></div>
                                    <div class="wpie-scheduled-export-data-element-wrapper">
                                        <input class="wpie-filter-input wpie-scheduled-export-time" type="text" placeholder="<?php _e('Enter Time for import', WPIE_TEXTDOMAIN); ?>" name="wpie_scheduled_import_time">
                                        <div class="wpie-filter-input-hint"><?php _e('Value : 00:00:01 to 23:59:59, Default : Current time', WPIE_TEXTDOMAIN); ?></div>
                                    </div>
                                </div>
                                <div class="wpie-scheduled-export-inner">
                                    <div class="wpie-scheduled-export-data-label"><?php _e('Send E-mail', WPIE_TEXTDOMAIN); ?></div>
                                    <div class="wpie-scheduled-export-data-element-wrapper">
                                        <input type="checkbox" class="wpie-filter-input-check wpie-scheduled-send-email" id="wpie-scheduled-import-send-email" name="wpie_product_scheduled_send_email" value="1"/>
                                        <label for="wpie-scheduled-import-send-email" class="wpie-product-scheduled-export-label"><?php _e('Send E-mail with attachment', WPIE_TEXTDOMAIN); ?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="wpie-scheduled-export-email-details">
                                <div class="wpie-scheduled-export-inner">
                                    <div class="wpie-scheduled-export-data-label"><?php _e('Enter Email Recipient(s)', WPIE_TEXTDOMAIN); ?></div>
                                    <div class="wpie-scheduled-export-data-element-wrapper">
                                        <input class="wpie-filter-input wpie-scheduled-export-email-recipients" type="text" placeholder="<?php _e('Enter Email Recipient(s)', WPIE_TEXTDOMAIN); ?>" name="wpie_scheduled_export_email_recipients">
                                        <div class="wpie-filter-input-hint">Ex. example@gmail.com, demo@yahoo.com</div>
                                    </div>
                                </div>
                                <div class="wpie-scheduled-export-inner">
                                    <div class="wpie-scheduled-export-data-label"><?php _e('Enter Email Subject', WPIE_TEXTDOMAIN); ?></div>
                                    <div class="wpie-scheduled-export-data-element-wrapper">
                                        <input class="wpie-filter-input wpie-scheduled-export-email-subject" type="text" placeholder="<?php _e('Enter Email Subject', WPIE_TEXTDOMAIN); ?>" name="wpie_scheduled_export_email_subject">
                                    </div>
                                </div>
                                <div class="wpie-scheduled-export-inner">
                                    <div class="wpie-scheduled-export-data-label"><?php _e('Enter Email message', WPIE_TEXTDOMAIN); ?></div>
                                    <div class="wpie-scheduled-export-data-element-wrapper">
                                        <textarea class="wpie-scheduled-export-email-content wpie-filter-input wpie-filter-input-textarea" name="wpie_scheduled_export_email_content" placeholder="<?php _e('Enter Email message', WPIE_TEXTDOMAIN); ?>"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="wpie-filter-input-hint-wrapper"></div>
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="wpie-filter-btn-wrapper">
                    <a class="wpie-general-btn wpie-product-cat-import" ><?php _e('Import', WPIE_TEXTDOMAIN); ?></a>
                    <a class="wpie-general-btn wpie-product-cat-scheduled-import-data wpie-scheduled-save-export-data wpie-hidden" ><?php _e('Save Scheduled', WPIE_TEXTDOMAIN); ?></a>
                </div>
            </div>
        </form>
        <div class="wpie-filter-data-container wpie-datatable-import-wrapper">

        </div>
    </div>
    <div class="container-fluid offset-10 wpie-scheduled-wrapper wpie-main-frm-wrapper">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="wpie-advanced-option-wrapper">
                <div class="wpie-schedueld-list-title wpie-advanced-option-header"><?php _e('Scheduled Export List', WPIE_TEXTDOMAIN); ?></div>
                <div class="wpie-schedueld-list-data wpie-advanced-option-data">
                    <table class="wpie-product-scheduled-export wpie-scheduled-list table table-striped table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th><?php _e('Scheduled ID', WPIE_TEXTDOMAIN); ?></th>
                                <th><?php _e('Recurrence Time', WPIE_TEXTDOMAIN); ?></th>
                                <th><?php _e('Send E-mail', WPIE_TEXTDOMAIN); ?></th>
                                <th><?php _e('Recipients', WPIE_TEXTDOMAIN); ?></th>
                                <th><?php _e('Next event', WPIE_TEXTDOMAIN); ?></th>
                                <th><?php _e('Actions', WPIE_TEXTDOMAIN); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($product_cat_scheduled_export_list)) { ?>
                                <?php foreach ($product_cat_scheduled_export_list as $key => $value) { ?>
                                    <tr>
                                        <td><?php echo $key; ?></td>
                                        <td><?php echo $get_schedules_list[$value['wpie_export_interval']]['display']; ?></td>
                                        <td><?php
                                            if (isset($value['wpie_product_scheduled_send_email']) && $value['wpie_product_scheduled_send_email'] == 1) {
                                                _e('Yes', WPIE_TEXTDOMAIN);
                                            } else {
                                                _e('No', WPIE_TEXTDOMAIN);
                                            }
                                            ?></td>
                                        <td><?php echo $value['wpie_scheduled_export_email_recipients']; ?></td>
                                        <td><?php echo date_i18n(get_option('date_format') . ' ' . get_option('time_format'), wp_next_scheduled('wpie_cron_scheduled_product_cat_export', array($key))); ?></td>
                                        <td><?php echo '<div class="wpie-delete-cron-data wpie-delete-product-cat-export-cron" cron_id=' . $key . '>DELETE</div>'; ?></td>
                                    </tr>
                                <?php } ?>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="wpie-advanced-option-wrapper">
                <div class="wpie-schedueld-list-title wpie-advanced-option-header"><?php _e('Scheduled Import List', WPIE_TEXTDOMAIN); ?></div>
                <div class="wpie-schedueld-list-data wpie-advanced-option-data">
                    <table class="wpie-product-scheduled-import wpie-scheduled-import-list table table-striped table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th><?php _e('Scheduled ID', WPIE_TEXTDOMAIN); ?></th>
                                <th><?php _e('Recurrence Time', WPIE_TEXTDOMAIN); ?></th>
                                <th><?php _e('Send E-mail', WPIE_TEXTDOMAIN); ?></th>
                                <th><?php _e('Recipients', WPIE_TEXTDOMAIN); ?></th>
                                <th><?php _e('Next event', WPIE_TEXTDOMAIN); ?></th>
                                <th><?php _e('Actions', WPIE_TEXTDOMAIN); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($product_cat_scheduled_import_list)) { ?>
                                <?php foreach ($product_cat_scheduled_import_list as $key => $value) { ?>
                                    <tr>
                                        <td><?php echo $key; ?></td>
                                        <td><?php echo $get_schedules_list[$value['wpie_import_interval']]['display']; ?></td>
                                        <td><?php
                                            if (isset($value['wpie_product_scheduled_send_email']) && $value['wpie_product_scheduled_send_email'] == 1) {
                                                _e('Yes', WPIE_TEXTDOMAIN);
                                            } else {
                                                _e('No', WPIE_TEXTDOMAIN);
                                            }
                                            ?></td>
                                        <td><?php echo $value['wpie_scheduled_export_email_recipients']; ?></td>
                                        <td><?php echo date_i18n(get_option('date_format') . ' ' . get_option('time_format'), wp_next_scheduled('wpie_cron_scheduled_product_cat_import', array($key))); ?></td>
                                        <td><?php echo '<div class="wpie-delete-cron-data wpie-delete-product-cat-import-cron" cron_id=' . $key . '>DELETE</div>'; ?></td>
                                    </tr>
                                <?php } ?>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid offset-10 wpie-advanced-wrapper wpie-main-frm-wrapper">
        <div class="wpie-advanced-option-wrapper"> 
            <div class="wpie-advanced-option-header"><?php _e('Manage Fields', WPIE_TEXTDOMAIN); ?></div> 
            <div class="wpie-advanced-option-data">
                <form class="wpie-product-cat-fields-frm">
                    <?php
                    foreach ($product_cat_fields as $new_product_cat_field) {
                        foreach ($new_product_cat_field as $key => $value) {
                            ?>
                            <!--                            <div class="wpie-advanced-option-data-container">-->
                            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                                <div class="wpie-fields-elements-status">
                                    <input id="<?php echo 'wpie-field-' . $value['field_key']; ?>" value="1" name="<?php echo 'wpie_' . $value['field_key'] . '_field_check'; ?>" type="checkbox" class="wpie-fields-elements-status-check" <?php checked($value['field_display'], 1); ?> >
                                </div>
                                <div class="wpie-fields-elements-label-wrapper"><label for="<?php echo 'wpie-field-' . $value['field_key']; ?>" class="wpie-fields-elements-label"><?php echo $value['field_title']; ?></label></div>
                            </div>
                            <?php
                        }
                    }
                    ?>
                    <div class="wpie-advanced-option-data-container">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <a class="wpie-general-btn wpie-product-cat-settings-btn" ><?php _e('Save', WPIE_TEXTDOMAIN); ?></a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="wpie-advanced-option-wrapper"> 
            <div class="wpie-advanced-option-header"><?php _e('Import Log', WPIE_TEXTDOMAIN); ?></div> 
            <div class="wpie-advanced-option-data">
                <table class="wpie-product-import-log wpie-datatable-view wpie-datatable table table-striped table-bordered" cellspacing="0">
                    <thead>
                        <tr>
                            <th><?php _e('No', WPIE_TEXTDOMAIN); ?></th>
                            <th><?php _e('File Name', WPIE_TEXTDOMAIN); ?></th>
                            <th><?php _e('Date', WPIE_TEXTDOMAIN); ?></th>
                            <th><?php _e('Action', WPIE_TEXTDOMAIN); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($import_log_list)) { ?>
                            <?php $temp_count = 1; ?>
                            <?php foreach ($import_log_list as $import_log_data) { ?>
                                <tr>
                                    <td><?php echo $temp_count++ ?></td>
                                    <td class="wpie_filename_list"><?php echo substr($import_log_data->export_log_file_name, 11); ?></td>
                                    <td><?php echo $import_log_data->create_date; ?></td>
                                    <td>
                                        <div class="wpie-log-action-wrapper">
                                            <div class="wpie-log-download-action "  file_name="<?php echo $import_log_data->export_log_file_name; ?>"><?php _e('Download', WPIE_TEXTDOMAIN); ?></div>
                                            <div class="wpie-log-delete-action wpie-import-log-delete-action" log_id="<?php echo $import_log_data->export_log_id; ?>" file_name="<?php echo $import_log_data->export_log_file_name; ?>"><?php _e('Delete', WPIE_TEXTDOMAIN); ?></div>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php }
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th><?php _e('No', WPIE_TEXTDOMAIN); ?></th>
                            <th><?php _e('File Name', WPIE_TEXTDOMAIN); ?></th>
                            <th><?php _e('Date', WPIE_TEXTDOMAIN); ?></th>
                            <th><?php _e('Action', WPIE_TEXTDOMAIN); ?></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="wpie-advanced-option-wrapper"> 
            <div class="wpie-advanced-option-header"><?php _e('Export Log', WPIE_TEXTDOMAIN); ?></div> 
            <div class="wpie-advanced-option-data">
                <table class="wpie-product-export-log wpie-datatable-view wpie-datatable table table-striped table-bordered" cellspacing="0">
                    <thead>
                        <tr>
                            <th><?php _e('No.', WPIE_TEXTDOMAIN); ?></th>
                            <th><?php _e('File Name', WPIE_TEXTDOMAIN); ?></th>
                            <th><?php _e('Date', WPIE_TEXTDOMAIN); ?></th>
                            <th><?php _e('Action', WPIE_TEXTDOMAIN); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($log_list)) { ?>
                            <?php $temp_count = 1; ?>
                            <?php foreach ($log_list as $log_data) { ?>
                                <tr>
                                    <td><?php echo $temp_count++; ?></td>
                                    <td class="wpie_filename_list"><?php echo $log_data->export_log_file_name; ?></td>
                                    <td><?php echo $log_data->create_date; ?></td>
                                    <td>
                                        <div class="wpie-log-action-wrapper">
                                            <div class="wpie-log-download-action"  file_name="<?php echo $log_data->export_log_file_name; ?>"><?php _e('Download', WPIE_TEXTDOMAIN); ?></div>
                                            <div class="wpie-log-delete-action wpie-export-log-delete-action" log_id="<?php echo $log_data->export_log_id; ?>" file_name="<?php echo $log_data->export_log_file_name; ?>"><?php _e('Delete', WPIE_TEXTDOMAIN); ?></div>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php }
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th><?php _e('No.', WPIE_TEXTDOMAIN); ?></th>
                            <th><?php _e('File Name', WPIE_TEXTDOMAIN); ?></th>
                            <th><?php _e('Date', WPIE_TEXTDOMAIN); ?></th>
                            <th><?php _e('Action', WPIE_TEXTDOMAIN); ?></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
<form class="wpie-download-exported-file-frm" method="post">
    <input type="hidden" class="wpie_download_exported_file" name="wpie_download_exported_file" >
</form>
<div class="wpie-documantation-links-wrapper">
    <div class="wpie-documantation-links-outer">
        <a class="wpie-documantation-links" target="_blank" href="<?php echo "http://www.vjinfotech.com/products/woo-imp-exp/documentation/"; ?>"><?php _e('Documentation', WPIE_TEXTDOMAIN); ?></a> |  <a class="wpie-documantation-links" target="_blank" href="http://www.vjinfotech.com/support"><?php _e('Support', WPIE_TEXTDOMAIN); ?></a>
    </div>
</div>