<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//will be auto loaded
class EnbConstants
{

	//related to database
	public static $ENB_DATABASE_TABLE_USER = "enb_user";
	public static $ENB_DATABASE_TABLE_NOTICE = "enb_notice";
	public static $ENB_DATABASE_TABLE_NOTICE_CONTENT = "notice_content";
	public static $ENB_DATABASE_TABLE_SYSTEM_SETTING = "system_setting";
	public static $ENB_DATABASE_TABLE_SYSTEM_SETTING_COLUMN_NAME = "name";
	public static $ENB_DATABASE_TABLE_SYSTEM_SETTING_COLUMN_NOTICE_SHOW_TIME = "min_notice_show_time_sec";
	public static $ENB_DATABASE_TABLE_SYSTEM_SETTING_COLUMN_NOTICE_IMAGE_SHOW_TIME = "notice_image_show_time_sec";
	public static $ENB_DATABASE_TABLE_SYSTEM_SETTING_COLUMN_NOTICES_RELOAD_TIME = "notices_reload_time_sec";
	public static $ENB_DATABASE_TABLE_SYSTEM_SETTING_COLUMN_ACTIVE = "active";

	public static $ENB_DATABASE_TABLE_USER_COLUMN_FIRSTNAME = "fname";
	public static $ENB_DATABASE_TABLE_USER_COLUMN_LASTNAME = "lname";
	public static $ENB_DATABASE_TABLE_USER_COLUMN_USERNAME = "uname";
	public static $ENB_DATABASE_TABLE_USER_COLUMN_PASSWORD = "pword";
	public static $ENB_DATABASE_TABLE_USER_COLUMN_ROLE = "role";

	public static $ENB_USER_ROLE_NOTICE_MANAGER = "noticemanager";
	public static $ENB_USER_ROLE_SYSTEM_ADMIN = "systemadmin";

}
