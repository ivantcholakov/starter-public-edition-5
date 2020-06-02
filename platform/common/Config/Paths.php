<?php namespace Common\Config;

/**
 * Holds the paths that are used by the system to
 * locate the main directories, app, system, etc.
 * Modifying these allows you to re-structure your application,
 * share a system folder between multiple applications, and more.
 *
 * All paths are relative to the project's root folder.
 */

class Paths
{
    /*
     *---------------------------------------------------------------
     * SYSTEM FOLDER NAME
     *---------------------------------------------------------------
     *
     * This variable must contain the name of your "system" folder.
     * Include the path if the folder is not in the same directory
     * as this file.
     */
    public $systemDirectory = \PATHS_SYSTEM_DIRECTORY;

    /*
     *---------------------------------------------------------------
     * SYSTEM FOLDER NAME
     *---------------------------------------------------------------
     *
     * This variable must contain the name of your "common" folder.
     */
    public $commonDirectory = \PATHS_COMMON_DIRECTORY;

    /*
     *---------------------------------------------------------------
     * APPLICATION FOLDER NAME
     *---------------------------------------------------------------
     *
     * If you want this front controller to use a different "app"
     * folder than the default one you can set its name here. The folder
     * can also be renamed or relocated anywhere on your getServer. If
     * you do, use a full getServer path. For more info please see the user guide:
     * http://codeigniter.com/user_guide/general/managing_apps.html
     *
     * NO TRAILING SLASH!
     */
    public $appDirectory = \PATHS_APP_DIRECTORY;

    /*
     * ---------------------------------------------------------------
     * WRITABLE DIRECTORY NAME
     * ---------------------------------------------------------------
     *
     * This variable must contain the name of your "writable" directory.
     * The writable directory allows you to group all directories that
     * need write permission to a single place that can be tucked away
     * for maximum security, keeping it out of the app and/or
     * system directories.
     */
    public $writableDirectory = \PATHS_WRITABLE_DIRECTORY;

    /*
     * ---------------------------------------------------------------
     * TESTS DIRECTORY NAME
     * ---------------------------------------------------------------
     *
     * This variable must contain the name of your "tests" directory.
     * The writable directory allows you to group all directories that
     * need write permission to a single place that can be tucked away
     * for maximum security, keeping it out of the app and/or
     * system directories.
     */
    public $testsDirectory = \PATHS_TESTS_DIRECTORY;

    /*
     * ---------------------------------------------------------------
     * VIEW DIRECTORY NAME
     * ---------------------------------------------------------------
     *
     * This variable must contain the name of the directory that
     * contains the view files used by your application. By
     * default this is in `app/Views`. This value
     * is used when no value is provided to `Services::renderer()`.
     */
    public $viewDirectory = \PATHS_VIEW_DIRECTORY;
}
