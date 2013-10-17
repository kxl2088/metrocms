<?php defined('BASEPATH') OR exit('No direct script access allowed');

// Upper left anchors
$lang['log.posts_title']        = 'Database stored logs';
$lang['log.physical_title']     = 'Physical log files';
$lang['log.quick_select_title'] = 'Quick select';

// Upper right anchors
$lang['log.sync_logs']     = 'Synchronize log files';
$lang['log.truncate_logs'] = 'Delete ALL database stored logs';

// Notifications
$lang['log.finished_scrolling']         = 'Finished scrolling';
$lang['log.sync_success']               = 'Successfully synchronized your log file(s).';
$lang['log.download_success']           = 'Successfully downloaded your log file(s).';
$lang['log.resync_success']             = 'Successfully resynchronized "%s"';
$lang['log.resync_success_multiple']    = 'Successfully resynchronized the following log file(s): <strong>%s</strong>';
$lang['log.resync_error']               = 'Something went wrong when trying to resynchronize "%s"';
$lang['log.resync_not_exists']          = 'There is no log file with id <strong>%s</strong> in the database';
$lang['log.resync_not_exists_multiple'] = 'There is/are no log files found with the following id(s): <strong>%s</strong>';
$lang['log.resync_too_large']           = 'The log file "%s" appears to be gotten too big for storage';
$lang['log.resync_too_large_multiple']  = 'The following log file(s) appear to be gotten too big for storage: <strong>%s</strong>';
$lang['log.delete_success']             = 'The database log "%s" has been deleted.';
$lang['log.delete_all_success']         = 'The database table has been cleared of all your logs.';
$lang['log.mass_delete_success']        = 'The database logs "%s" have been deleted.';
$lang['log.delete_error']               = 'No database logs were deleted.';
$lang['log.currently_no_logs']          = 'There are no database logs at the moment.';
$lang['log.no_logs']                    = 'There are no log files in your directory.';
$lang['log.edit_log_title']             = 'Log file from <strong>%s</strong> ("%s")';
$lang['log.sync_too_big_notices']       = 'The following logs where too big to synchronize: %s.';
$lang['log.delete_physical_seccess']    = 'Succesfully deleted the file(s) from the log directory.';
$lang['log.select_log_files_error']     = '<p>Please select <strong>one or more</strong> log files to take action first.</p><p>Click to dismiss this message.</p>';
$lang['log.physical_info']              = 'Oversized files have an exclamation mark and can\'t be added to the database. Files already stored in your database will be resynchronized. Please be patient while (re)synchronizing or deleting log files!';
$lang['log.no_logs_selected']           = '<p><strong>No log files</strong> were selected. No action can be taken without having files selected.</p><p>Click to dismiss this message.</p>';

// Log file anchors
$lang['log.scroll_to_bottom']      = 'Scroll to the bottom';
$lang['log.scroll_to_top']         = 'Back to top';
$lang['log.first_occurence_label'] = 'First occurence';
$lang['log.last_occurence_label']  = 'Last occurence';

// Labels
$lang['log.resync_label']                             = 'Resynchronize';
$lang['log.size_label']                               = 'Size';
$lang['log.date_label']                               = 'Date';
$lang['log.date_synced_label']                        = 'Date synchronized';
$lang['log.sync_label']                               = '(Re)synchronize';
$lang['log.invalid-query_label']                      = 'Invalid queries';
$lang['log.other_label']                              = 'Other errors';
$lang['log.page-missing_label']                       = 'Pages missing';
$lang['log.query-error_label']                        = 'Query errors';
$lang['log.severity-warning_label']                   = 'Severity warnings';
$lang['log.severity-notice_label']                    = 'Severity notices';
$lang['log.unable-to-load-the-requested-class_label'] = 'Unable to load the requested class';
$lang['log.unable-to-select-database_label']          = 'Unable to select database';
$lang['log.download_physical']                        = 'Download to your computer';
$lang['log.delete_physical']                          = 'Delete phyiscal log files';
$lang['log.edited_on_label']                          = 'Edited on';
$lang['log.size_label']                               = 'Size';
$lang['log.empty_log_directory']                      = ' (empty)';
$lang['log.toggle_select']                            = 'Toggle';
$lang['log.non_synchronized']                         = 'Non synchronized';
$lang['log.oversized']                                = 'Oversized';