-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 10, 2023 at 05:14 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;

--
-- Database: `install_Ebook`
--

-- --------------------------------------------------------

--
-- Table structure for table `ad_spaces`
--

CREATE TABLE `ad_spaces` (
  `id` int(11) NOT NULL,
  `lang_id` int(11) DEFAULT 1,
  `ad_space` text DEFAULT NULL,
  `ad_code_desktop` text DEFAULT NULL,
  `desktop_width` int(11) DEFAULT NULL,
  `desktop_height` int(11) DEFAULT NULL,
  `ad_code_mobile` text DEFAULT NULL,
  `mobile_width` int(11) DEFAULT NULL,
  `mobile_height` int(11) DEFAULT NULL,
  `display_category_id` int(11) DEFAULT NULL,
  `paragraph_number` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `lang_id` tinyint(4) DEFAULT 1,
  `name` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL,
  `keywords` varchar(500) DEFAULT NULL,
  `parent_id` int(11) DEFAULT 0,
  `category_order` smallint(6) DEFAULT NULL,
  `show_on_menu` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE `ci_sessions` (
  `id` varchar(128) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT 0,
  `post_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `comment` varchar(5000) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `message` varchar(5000) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE `files` (
  `id` int(11) NOT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `followers`
--

CREATE TABLE `followers` (
  `id` int(11) NOT NULL,
  `following_id` int(11) DEFAULT NULL,
  `follower_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fonts`
--

CREATE TABLE `fonts` (
  `id` int(11) NOT NULL,
  `font_name` varchar(255) DEFAULT NULL,
  `font_key` varchar(255) DEFAULT NULL,
  `font_url` varchar(2000) DEFAULT NULL,
  `font_family` varchar(500) DEFAULT NULL,
  `font_source` varchar(50) DEFAULT 'google',
  `has_local_file` tinyint(1) DEFAULT 0,
  `is_default` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `fonts`
--

INSERT INTO `fonts` (`id`, `font_name`, `font_key`, `font_url`, `font_family`, `font_source`, `has_local_file`, `is_default`) VALUES
(1, 'Arial', 'arial', NULL, 'font-family: Arial, Helvetica, sans-serif', 'local', 0, 1),
(2, 'Arvo', 'arvo', '<link href=\"https://fonts.googleapis.com/css?family=Arvo:400,700&display=swap\" rel=\"stylesheet\">\r\n', 'font-family: \"Arvo\", Helvetica, sans-serif', 'google', 0, 0),
(3, 'Averia Libre', 'averia-libre', '<link href=\"https://fonts.googleapis.com/css?family=Averia+Libre:300,400,700&display=swap\" rel=\"stylesheet\">\r\n', 'font-family: \"Averia Libre\", Helvetica, sans-serif', 'google', 0, 0),
(4, 'Bitter', 'bitter', '<link href=\"https://fonts.googleapis.com/css?family=Bitter:400,400i,700&display=swap&subset=latin-ext\" rel=\"stylesheet\">\r\n', 'font-family: \"Bitter\", Helvetica, sans-serif', 'google', 0, 0),
(5, 'Cabin', 'cabin', '<link href=\"https://fonts.googleapis.com/css?family=Cabin:400,500,600,700&display=swap&subset=latin-ext,vietnamese\" rel=\"stylesheet\">\r\n', 'font-family: \"Cabin\", Helvetica, sans-serif', 'google', 0, 0),
(6, 'Cherry Swash', 'cherry-swash', '<link href=\"https://fonts.googleapis.com/css?family=Cherry+Swash:400,700&display=swap&subset=latin-ext\" rel=\"stylesheet\">\r\n', 'font-family: \"Cherry Swash\", Helvetica, sans-serif', 'google', 0, 0),
(7, 'Encode Sans', 'encode-sans', '<link href=\"https://fonts.googleapis.com/css?family=Encode+Sans:300,400,500,600,700&display=swap&subset=latin-ext,vietnamese\" rel=\"stylesheet\">\r\n', 'font-family: \"Encode Sans\", Helvetica, sans-serif', 'google', 0, 0),
(8, 'Helvetica', 'helvetica', NULL, 'font-family: Helvetica, sans-serif', 'local', 0, 1),
(9, 'Hind', 'hind', '<link href=\"https://fonts.googleapis.com/css?family=Hind:300,400,500,600,700&display=swap&subset=devanagari,latin-ext\" rel=\"stylesheet\">', 'font-family: \"Hind\", Helvetica, sans-serif', 'google', 0, 0),
(10, 'Josefin Sans', 'josefin-sans', '<link href=\"https://fonts.googleapis.com/css?family=Josefin+Sans:300,400,600,700&display=swap&subset=latin-ext,vietnamese\" rel=\"stylesheet\">\r\n', 'font-family: \"Josefin Sans\", Helvetica, sans-serif', 'google', 0, 0),
(11, 'Kalam', 'kalam', '<link href=\"https://fonts.googleapis.com/css?family=Kalam:300,400,700&display=swap&subset=devanagari,latin-ext\" rel=\"stylesheet\">\r\n', 'font-family: \"Kalam\", Helvetica, sans-serif', 'google', 0, 0),
(12, 'Khula', 'khula', '<link href=\"https://fonts.googleapis.com/css?family=Khula:300,400,600,700&display=swap&subset=devanagari,latin-ext\" rel=\"stylesheet\">\r\n', 'font-family: \"Khula\", Helvetica, sans-serif', 'google', 0, 0),
(13, 'Lato', 'lato', '<link href=\"https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap&subset=latin-ext\" rel=\"stylesheet\">', 'font-family: \"Lato\", Helvetica, sans-serif', 'google', 0, 0),
(14, 'Lora', 'lora', '<link href=\"https://fonts.googleapis.com/css?family=Lora:400,700&display=swap&subset=cyrillic,cyrillic-ext,latin-ext,vietnamese\" rel=\"stylesheet\">\r\n', 'font-family: \"Lora\", Helvetica, sans-serif', 'google', 0, 0),
(15, 'Merriweather', 'merriweather', '<link href=\"https://fonts.googleapis.com/css?family=Merriweather:300,400,700&display=swap&subset=cyrillic,cyrillic-ext,latin-ext,vietnamese\" rel=\"stylesheet\">\r\n', 'font-family: \"Merriweather\", Helvetica, sans-serif', 'google', 0, 0),
(16, 'Montserrat', 'montserrat', '<link href=\"https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600,700&display=swap&subset=cyrillic,cyrillic-ext,latin-ext,vietnamese\" rel=\"stylesheet\">\r\n', 'font-family: \"Montserrat\", Helvetica, sans-serif', 'google', 0, 0),
(17, 'Mukta', 'mukta', '<link href=\"https://fonts.googleapis.com/css?family=Mukta:300,400,500,600,700&display=swap&subset=devanagari,latin-ext\" rel=\"stylesheet\">\r\n', 'font-family: \"Mukta\", Helvetica, sans-serif', 'google', 0, 0),
(18, 'Nunito', 'nunito', '<link href=\"https://fonts.googleapis.com/css?family=Nunito:300,400,600,700&display=swap&subset=cyrillic,cyrillic-ext,latin-ext,vietnamese\" rel=\"stylesheet\">\r\n', 'font-family: \"Nunito\", Helvetica, sans-serif', 'google', 0, 0),
(19, 'Open Sans', 'open-sans', '<link href=\"https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700&display=swap\" rel=\"stylesheet\">', 'font-family: \"Open Sans\", Helvetica, sans-serif', 'local', 1, 0),
(20, 'Oswald', 'oswald', '<link href=\"https://fonts.googleapis.com/css?family=Oswald:300,400,500,600,700&display=swap&subset=cyrillic,cyrillic-ext,latin-ext,vietnamese\" rel=\"stylesheet\">', 'font-family: \"Oswald\", Helvetica, sans-serif', 'google', 0, 0),
(21, 'Oxygen', 'oxygen', '<link href=\"https://fonts.googleapis.com/css?family=Oxygen:300,400,700&display=swap&subset=latin-ext\" rel=\"stylesheet\">\r\n', 'font-family: \"Oxygen\", Helvetica, sans-serif', 'google', 0, 0),
(22, 'Poppins', 'poppins', '<link href=\"https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700&display=swap&subset=devanagari,latin-ext\" rel=\"stylesheet\">', 'font-family: \"Poppins\", Helvetica, sans-serif', 'google', 0, 0),
(23, 'PT Sans', 'pt-sans', '<link href=\"https://fonts.googleapis.com/css?family=PT+Sans:400,700&display=swap&subset=cyrillic,cyrillic-ext,latin-ext\" rel=\"stylesheet\">\r\n', 'font-family: \"PT Sans\", Helvetica, sans-serif', 'google', 0, 0),
(24, 'Raleway', 'raleway', '<link href=\"https://fonts.googleapis.com/css?family=Raleway:300,400,500,600,700&display=swap&subset=latin-ext\" rel=\"stylesheet\">\r\n', 'font-family: \"Raleway\", Helvetica, sans-serif', 'google', 0, 0),
(25, 'Roboto', 'roboto', '<link href=\"https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap&subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese\" rel=\"stylesheet\">', 'font-family: \"Roboto\", Helvetica, sans-serif', 'local', 1, 0),
(26, 'Roboto Condensed', 'roboto-condensed', '<link href=\"https://fonts.googleapis.com/css?family=Roboto+Condensed:300,400,700&display=swap&subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese\" rel=\"stylesheet\">\r\n', 'font-family: \"Roboto Condensed\", Helvetica, sans-serif', 'google', 0, 0),
(27, 'Roboto Slab', 'roboto-slab', '<link href=\"https://fonts.googleapis.com/css?family=Roboto+Slab:300,400,500,600,700&display=swap&subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese\" rel=\"stylesheet\">\r\n', 'font-family: \"Roboto Slab\", Helvetica, sans-serif', 'google', 0, 0),
(28, 'Rokkitt', 'rokkitt', '<link href=\"https://fonts.googleapis.com/css?family=Rokkitt:300,400,500,600,700&display=swap&subset=latin-ext,vietnamese\" rel=\"stylesheet\">\r\n', 'font-family: \"Rokkitt\", Helvetica, sans-serif', 'google', 0, 0),
(29, 'Source Sans Pro', 'source-sans-pro', '<link href=\"https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700&display=swap&subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese\" rel=\"stylesheet\">', 'font-family: \"Source Sans Pro\", Helvetica, sans-serif', 'google', 0, 0),
(30, 'Titillium Web', 'titillium-web', '<link href=\"https://fonts.googleapis.com/css?family=Titillium+Web:300,400,600,700&display=swap&subset=latin-ext\" rel=\"stylesheet\">', 'font-family: \"Titillium Web\", Helvetica, sans-serif', 'google', 0, 0),
(31, 'Ubuntu', 'ubuntu', '<link href=\"https://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700&display=swap&subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext\" rel=\"stylesheet\">', 'font-family: \"Ubuntu\", Helvetica, sans-serif', 'google', 0, 0),
(32, 'Verdana', 'verdana', NULL, 'font-family: Verdana, Helvetica, sans-serif', 'local', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `gallery_albums`
--

CREATE TABLE `gallery_albums` (
  `id` int(11) NOT NULL,
  `lang_id` tinyint(4) DEFAULT 1,
  `name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gallery_categories`
--

CREATE TABLE `gallery_categories` (
  `id` int(11) NOT NULL,
  `lang_id` tinyint(4) DEFAULT 1,
  `name` varchar(255) DEFAULT NULL,
  `album_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `general_settings`
--

CREATE TABLE `general_settings` (
  `id` int(11) NOT NULL,
  `site_lang` tinyint(4) NOT NULL DEFAULT 1,
  `layout` varchar(30) DEFAULT 'layout_1',
  `dark_mode` tinyint(1) DEFAULT 0,
  `admin_route` varchar(255) DEFAULT 'admin',
  `timezone` varchar(255) DEFAULT 'America/New_York',
  `slider_active` tinyint(1) DEFAULT 1,
  `site_color` varchar(30) DEFAULT 'default',
  `show_pageviews` tinyint(1) DEFAULT 1,
  `show_rss` tinyint(1) DEFAULT 1,
  `file_manager_show_all_files` tinyint(1) DEFAULT 0,
  `logo_path` varchar(255) DEFAULT NULL,
  `mobile_logo_path` varchar(255) DEFAULT NULL,
  `favicon_path` varchar(255) DEFAULT NULL,
  `facebook_app_id` varchar(500) DEFAULT NULL,
  `facebook_app_secret` varchar(500) DEFAULT NULL,
  `google_client_id` varchar(500) DEFAULT NULL,
  `google_client_secret` varchar(500) DEFAULT NULL,
  `google_analytics` text DEFAULT NULL,
  `google_adsense_code` text DEFAULT NULL,
  `mail_service` varchar(100) DEFAULT 'swift',
  `mail_protocol` varchar(100) DEFAULT 'smtp',
  `mail_encryption` varchar(100) NOT NULL DEFAULT 'tls',
  `mail_host` varchar(255) DEFAULT NULL,
  `mail_port` varchar(255) DEFAULT '587',
  `mail_username` varchar(255) DEFAULT NULL,
  `mail_password` varchar(255) DEFAULT NULL,
  `mail_title` varchar(255) DEFAULT NULL,
  `mail_reply_to` varchar(255) DEFAULT ' noreply@domain.com ',
  `mailjet_api_key` varchar(255) DEFAULT NULL,
  `mailjet_secret_key` varchar(255) DEFAULT NULL,
  `mailjet_email_address` varchar(255) DEFAULT NULL,
  `send_email_contact_messages` tinyint(1) DEFAULT 0,
  `mail_options_account` varchar(255) DEFAULT NULL,
  `facebook_comment` text DEFAULT NULL,
  `pagination_per_page` tinyint(4) DEFAULT 6,
  `menu_limit` tinyint(4) DEFAULT 5,
  `multilingual_system` tinyint(1) DEFAULT 1,
  `registration_system` tinyint(1) DEFAULT 1,
  `comment_system` tinyint(1) DEFAULT 1,
  `comment_approval_system` tinyint(1) DEFAULT 1,
  `approve_posts_before_publishing` tinyint(1) DEFAULT 1,
  `emoji_reactions` tinyint(1) DEFAULT 1,
  `auto_post_deletion` tinyint(1) DEFAULT 0,
  `auto_post_deletion_delete_all` tinyint(1) DEFAULT 0,
  `auto_post_deletion_days` int(11) DEFAULT 30,
  `recaptcha_site_key` varchar(500) DEFAULT NULL,
  `recaptcha_secret_key` varchar(500) DEFAULT NULL,
  `cache_system` tinyint(1) DEFAULT 0,
  `cache_refresh_time` int(11) DEFAULT 1800,
  `refresh_cache_database_changes` tinyint(1) DEFAULT 0,
  `maintenance_mode_title` varchar(500) DEFAULT 'Coming Soon! ',
  `maintenance_mode_description` varchar(5000) DEFAULT NULL,
  `maintenance_mode_status` tinyint(1) DEFAULT 0,
  `sitemap_frequency` varchar(30) DEFAULT 'monthly',
  `sitemap_last_modification` varchar(30) DEFAULT 'server_response',
  `sitemap_priority` varchar(30) DEFAULT 'automatically',
  `newsletter_status` tinyint(1) DEFAULT 1,
  `newsletter_popup` tinyint(1) DEFAULT 1,
  `newsletter_temp_emails` longtext DEFAULT NULL,
  `custom_css_codes` mediumtext DEFAULT NULL,
  `custom_javascript_codes` mediumtext DEFAULT NULL,
  `allowed_file_extensions` varchar(500) DEFAULT 'jpg,jpeg,png,gif,svg,csv,doc,docx,pdf,ppt,psd,mp4,mp3,zip',
  `last_cron_update` timestamp NULL DEFAULT current_timestamp(),
  `version` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `general_settings`
--

INSERT INTO `general_settings` (`id`, `site_lang`, `layout`, `dark_mode`, `admin_route`, `timezone`, `slider_active`, `site_color`, `show_pageviews`, `show_rss`, `file_manager_show_all_files`, `logo_path`, `mobile_logo_path`, `favicon_path`, `facebook_app_id`, `facebook_app_secret`, `google_client_id`, `google_client_secret`, `google_analytics`, `google_adsense_code`, `mail_service`, `mail_protocol`, `mail_encryption`, `mail_host`, `mail_port`, `mail_username`, `mail_password`, `mail_title`, `mail_reply_to`, `mailjet_api_key`, `mailjet_secret_key`, `mailjet_email_address`, `send_email_contact_messages`, `mail_options_account`, `facebook_comment`, `pagination_per_page`, `menu_limit`, `multilingual_system`, `registration_system`, `comment_system`, `comment_approval_system`, `approve_posts_before_publishing`, `emoji_reactions`, `auto_post_deletion`, `auto_post_deletion_delete_all`, `auto_post_deletion_days`, `recaptcha_site_key`, `recaptcha_secret_key`, `cache_system`, `cache_refresh_time`, `refresh_cache_database_changes`, `maintenance_mode_title`, `maintenance_mode_description`, `maintenance_mode_status`, `sitemap_frequency`, `sitemap_last_modification`, `sitemap_priority`, `newsletter_status`, `newsletter_popup`, `newsletter_temp_emails`, `custom_css_codes`, `custom_javascript_codes`, `allowed_file_extensions`, `last_cron_update`, `version`) VALUES
(1, 1, 'layout_2', 0, 'admin', 'America/New_York', 1, '#02b13e', 1, 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'swift', 'smtp', 'tls', NULL, '587', NULL, NULL, 'Ebook', 'noreply@domain.com', NULL, NULL, NULL, 0, NULL, NULL, 12, 9, 1, 1, 1, 1, 1, 1, 0, 0, 30, NULL, NULL, 0, 1800, 0, 'Coming Soon!', 'Our website is under construction. We\'ll be here soon with our new awesome site.', 0, 'weekly', 'server_response', 'automatically', 1, 1, NULL, NULL, NULL, 'jpg,jpeg,png,gif,svg,csv,doc,docx,pdf,ppt,psd,mp4,mp3,zip', NULL, '4.3');

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `id` int(11) NOT NULL,
  `image_big` varchar(255) DEFAULT NULL,
  `image_mid` varchar(255) DEFAULT NULL,
  `image_small` varchar(255) DEFAULT NULL,
  `image_slider` varchar(255) DEFAULT NULL,
  `image_mime` varchar(30) DEFAULT 'jpg',
  `file_name` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` tinyint(4) NOT NULL,
  `name` varchar(100) NOT NULL,
  `short_form` varchar(30) NOT NULL,
  `language_code` varchar(30) NOT NULL,
  `text_direction` varchar(10) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `language_order` tinyint(4) NOT NULL DEFAULT 1,
  `text_editor_lang` varchar(20) NOT NULL DEFAULT 'en'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `name`, `short_form`, `language_code`, `text_direction`, `status`, `language_order`, `text_editor_lang`) VALUES
(1, 'English', 'en', 'en-US', 'ltr', 1, 1, 'en');

-- --------------------------------------------------------

--
-- Table structure for table `language_translations`
--

CREATE TABLE `language_translations` (
  `id` int(11) NOT NULL,
  `lang_id` smallint(6) DEFAULT NULL,
  `label` varchar(255) DEFAULT NULL,
  `translation` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `language_translations`
--

INSERT INTO `language_translations` (`id`, `lang_id`, `label`, `translation`) VALUES
(1, 1, 'about', 'About'),
(2, 1, 'about_me', 'About Me'),
(3, 1, 'activate', 'Activate'),
(4, 1, 'activated', 'Activated'),
(5, 1, 'active', 'Active'),
(6, 1, 'additional_images', 'Additional Images'),
(7, 1, 'address', 'Address'),
(8, 1, 'add_album', 'Add Album'),
(9, 1, 'add_category', 'Add Category'),
(10, 1, 'add_font', 'Add Font'),
(11, 1, 'add_image', 'Add Image'),
(12, 1, 'add_images', 'Add images'),
(13, 1, 'add_image_url', 'Add Image Url'),
(14, 1, 'add_language', 'Add Language'),
(15, 1, 'add_link', 'Add Menu Link'),
(16, 1, 'add_page', 'Add Page'),
(17, 1, 'add_picked', 'Add to Our Picks'),
(18, 1, 'add_poll', 'Add Poll'),
(19, 1, 'add_post', 'Add Post'),
(20, 1, 'add_posts_as_draft', 'Add Posts as Draft'),
(21, 1, 'add_reading_list', 'Add to Reading List'),
(22, 1, 'add_role', 'Add Role'),
(23, 1, 'add_slider', 'Add to Slider'),
(24, 1, 'add_subcategory', 'Add Subcategory'),
(25, 1, 'add_user', 'Add User'),
(26, 1, 'add_video', 'Add Video'),
(27, 1, 'admin', 'Admin'),
(28, 1, 'admin_emails_will_send', 'Admin emails will be sent to this address'),
(29, 1, 'admin_panel', 'Admin Panel'),
(30, 1, 'admin_panel_link', 'Admin Panel Link'),
(31, 1, 'ad_space', 'Ad Space'),
(32, 1, 'ad_spaces', 'Ad Spaces'),
(33, 1, 'ad_space_index_bottom', 'Index (Bottom)'),
(34, 1, 'ad_space_index_top', 'Index (Top)'),
(35, 1, 'ad_space_in_article', 'In-Article'),
(36, 1, 'ad_space_paragraph_exp', 'The ad will be displayed after the paragraph number you selected'),
(37, 1, 'ad_space_posts_bottom', 'Posts (Bottom)'),
(38, 1, 'ad_space_posts_exp', 'This ad will be displayed on Posts, Category, Profile, Tag, Search and Profile pages'),
(39, 1, 'ad_space_posts_top', 'Posts (Top)'),
(40, 1, 'ad_space_post_bottom', 'Post Details (Bottom)'),
(41, 1, 'ad_space_post_top', 'Post Details (Top)'),
(42, 1, 'album', 'Album'),
(43, 1, 'albums', 'Albums'),
(44, 1, 'album_cover', 'Album Cover'),
(45, 1, 'album_name', 'Album Name'),
(46, 1, 'all', 'All'),
(47, 1, 'allowed_file_extensions', 'Allowed File Extensions'),
(48, 1, 'all_permissions', 'All Permissions'),
(49, 1, 'all_posts', 'All Posts'),
(50, 1, 'all_users_can_vote', 'All Users Can Vote'),
(51, 1, 'always', 'Always'),
(52, 1, 'angry', 'Angry'),
(53, 1, 'api_key', 'API Key'),
(54, 1, 'approve', 'Approve'),
(55, 1, 'approved_comments', 'Approved Comments'),
(56, 1, 'approve_posts_before_publishing', 'Approve Posts Before Publishing'),
(57, 1, 'app_id', 'App ID'),
(58, 1, 'app_name', 'Application Name'),
(59, 1, 'app_secret', 'App Secret'),
(60, 1, 'April', 'Apr'),
(61, 1, 'August', 'Aug'),
(62, 1, 'author', 'Author'),
(63, 1, 'auto_post_deletion', 'Auto Post Deletion'),
(64, 1, 'auto_update', 'Auto Update'),
(65, 1, 'avatar', 'Avatar'),
(66, 1, 'back', 'Back'),
(67, 1, 'banned', 'Banned'),
(68, 1, 'banner', 'Banner'),
(69, 1, 'banner_desktop', 'Desktop Banner'),
(70, 1, 'banner_desktop_exp', 'This ad will be displayed on screens larger than 992px'),
(71, 1, 'banner_mobile', 'Mobile Banner'),
(72, 1, 'banner_mobile_exp', 'This ad will be displayed on screens smaller than 992px'),
(73, 1, 'ban_user', 'Ban User'),
(74, 1, 'browse_files', 'Browse Files'),
(75, 1, 'cache_refresh_time', 'Cache Refresh Time (Minute)'),
(76, 1, 'cache_refresh_time_exp', 'After this time, your cache files will be refreshed.'),
(77, 1, 'cache_system', 'Cache System'),
(78, 1, 'cancel', 'Cancel'),
(79, 1, 'categories', 'Categories'),
(80, 1, 'category', 'Category'),
(81, 1, 'category_name', 'Category Name'),
(82, 1, 'change_avatar', 'Change Avatar'),
(83, 1, 'change_favicon', 'Change favicon'),
(84, 1, 'change_image', 'Change image'),
(85, 1, 'change_logo', 'Change logo'),
(86, 1, 'change_password', 'Change Password'),
(87, 1, 'change_password_error', 'There was a problem changing your password!'),
(88, 1, 'change_user_role', 'Change User Role'),
(89, 1, 'client_id', 'Client ID'),
(90, 1, 'client_secret', 'Client Secret'),
(91, 1, 'close', 'Close'),
(92, 1, 'comment', 'Comment'),
(93, 1, 'comments', 'Comments'),
(94, 1, 'comment_approval_system', 'Comment Approval System'),
(95, 1, 'comment_system', 'Comment System'),
(96, 1, 'completed', 'Completed'),
(97, 1, 'confirm_album', 'Are you sure you want to delete this album?'),
(98, 1, 'confirm_ban', 'Are you sure you want to ban this user?'),
(99, 1, 'confirm_category', 'Are you sure you want to delete this category?'),
(100, 1, 'confirm_comment', 'Are you sure you want to delete this comment?'),
(101, 1, 'confirm_comments', 'Are you sure you want to delete selected comments?'),
(102, 1, 'confirm_delete', 'Are you sure you want to delete this item?'),
(103, 1, 'confirm_email', 'Are you sure you want to delete this email address?'),
(104, 1, 'confirm_image', 'Are you sure you want to delete this image?'),
(105, 1, 'confirm_item', 'Are you sure you want to delete this item?'),
(106, 1, 'confirm_language', 'Are you sure you want to delete this language?'),
(107, 1, 'confirm_link', 'Are you sure you want to delete this link?'),
(108, 1, 'confirm_message', 'Are you sure you want to delete this message?'),
(109, 1, 'confirm_page', 'Are you sure you want to delete this page?'),
(110, 1, 'confirm_password', 'Confirm Password'),
(111, 1, 'confirm_poll', 'Are you sure you want to delete this poll?'),
(112, 1, 'confirm_post', 'Are you sure you want to delete this post?'),
(113, 1, 'confirm_posts', 'Are you sure you want to delete selected posts?'),
(114, 1, 'confirm_remove_ban', 'Are you sure you want to remove ban for this user?'),
(115, 1, 'confirm_subscriber', 'Are you sure you want to delete this subscriber?'),
(116, 1, 'confirm_user', 'Are you sure you want to delete this user?'),
(117, 1, 'connect_with_facebook', 'Connect with Facebook'),
(118, 1, 'connect_with_google', 'Connect with Google'),
(119, 1, 'contact_message', 'Contact Message'),
(120, 1, 'contact_messages', 'Contact Messages'),
(121, 1, 'contact_settings', 'Contact Settings'),
(122, 1, 'contact_text', 'Contact Text'),
(123, 1, 'content', 'Content'),
(124, 1, 'cookies_warning', 'Cookies Warning'),
(125, 1, 'copyright', 'Copyright'),
(126, 1, 'create_ad_exp', 'If you don\'t have an ad code, you can create an ad code by selecting an image and adding an URL'),
(127, 1, 'custom', 'Custom'),
(128, 1, 'custom_css_codes', 'Custom CSS Codes'),
(129, 1, 'custom_css_codes_exp', 'These codes will be added to the header of the site.'),
(130, 1, 'custom_javascript_codes', 'Custom JavaScript Codes'),
(131, 1, 'custom_javascript_codes_exp', 'These codes will be added to the footer of the site.'),
(132, 1, 'daily', 'Daily'),
(133, 1, 'dark_mode', 'Dark Mode'),
(134, 1, 'date', 'Date'),
(135, 1, 'date_publish', 'Date Publish'),
(136, 1, 'days_ago', 'days ago'),
(137, 1, 'day_ago', 'day ago'),
(138, 1, 'December', 'Dec'),
(139, 1, 'default', 'Default'),
(140, 1, 'default_language', 'Default Language'),
(141, 1, 'delete', 'Delete'),
(142, 1, 'delete_all', 'Delete All'),
(143, 1, 'delete_all_posts', 'Delete All Posts'),
(144, 1, 'delete_only_rss_posts', 'Delete only RSS Posts'),
(145, 1, 'delete_reading_list', 'Remove from Reading List'),
(146, 1, 'description', 'Description'),
(147, 1, 'disable', 'Disable'),
(148, 1, 'dislike', 'Dislike'),
(149, 1, 'dont_want_receive_emails', 'Do not want receive these emails?'),
(150, 1, 'download_database_backup', 'Download Database Backup'),
(151, 1, 'download_images_my_server', 'Download Images to My Server'),
(152, 1, 'drafts', 'Drafts'),
(153, 1, 'drag_drop_files_here', 'Drag and drop files here or'),
(154, 1, 'edit', 'Edit'),
(155, 1, 'edit_role', 'Edit Role'),
(156, 1, 'edit_translations', 'Edit Translations'),
(157, 1, 'edit_user', 'Edit User'),
(158, 1, 'email', 'Email'),
(159, 1, 'email_address', 'Email Address'),
(160, 1, 'email_options', 'Email Options'),
(161, 1, 'email_option_contact_messages', 'Send contact messages to email address'),
(162, 1, 'email_reset_password', 'Please click on the button below to reset your password.'),
(163, 1, 'email_settings', 'Email Settings'),
(164, 1, 'email_unique_error', 'The email has already been taken.'),
(165, 1, 'emoji_reactions', 'Emoji Reactions'),
(166, 1, 'emoji_reactions_type', 'Emoji Reactions Type'),
(167, 1, 'enable', 'Enable'),
(168, 1, 'encryption', 'Encryption'),
(169, 1, 'export', 'Export'),
(170, 1, 'facebook_comments', 'Facebook Comments'),
(171, 1, 'facebook_comments_code', 'Facebook Comments Plugin Code'),
(172, 1, 'favicon', 'Favicon'),
(173, 1, 'February', 'Feb'),
(174, 1, 'feed', 'Feed'),
(175, 1, 'feed_name', 'Feed Name'),
(176, 1, 'feed_url', 'Feed URL'),
(177, 1, 'files', 'Files'),
(178, 1, 'files_exp', 'Downloadable additional files (.pdf, .docx, .zip etc..)'),
(179, 1, 'file_extensions', 'File Extensions'),
(180, 1, 'file_manager', 'File Manager'),
(181, 1, 'file_upload', 'File Upload'),
(182, 1, 'filter', 'Filter'),
(183, 1, 'folder_name', 'Folder Name'),
(184, 1, 'follow', 'Follow'),
(185, 1, 'followers', 'Followers'),
(186, 1, 'following', 'Following'),
(187, 1, 'fonts', 'Fonts'),
(188, 1, 'font_family', 'Font Family'),
(189, 1, 'font_settings', 'Font Settings'),
(190, 1, 'font_source', 'Font Source'),
(191, 1, 'footer', 'Footer'),
(192, 1, 'footer_about_section', 'Footer About Section'),
(193, 1, 'forgot_password', 'Forgot Password'),
(194, 1, 'form_validation_is_unique', 'The {field} field must contain a unique value.'),
(195, 1, 'form_validation_matches', 'The {field} field does not match the {param} field.'),
(196, 1, 'form_validation_max_length', 'The {field} field cannot exceed {param} characters in length.'),
(197, 1, 'form_validation_min_length', 'The {field} field must be at least {param} characters in length.'),
(198, 1, 'form_validation_required', 'The {field} field is required.'),
(199, 1, 'frequency', 'Frequency'),
(200, 1, 'frequency_exp', 'This value indicates how frequently the content at a particular URL is likely to change '),
(201, 1, 'funny', 'Funny'),
(202, 1, 'gallery', 'Gallery'),
(203, 1, 'gallery_albums', 'Gallery Albums'),
(204, 1, 'gallery_categories', 'Gallery Categories'),
(205, 1, 'general_settings', 'General Settings'),
(206, 1, 'generate', 'Generate'),
(207, 1, 'generate_keywords_from_title', 'Generate Keywords from Title'),
(208, 1, 'generate_sitemap', 'Generate Sitemap'),
(209, 1, 'get_video', 'Get Video'),
(210, 1, 'get_video_from_url', 'Get Video from Url'),
(211, 1, 'gif_animated', 'GIF (Animated)'),
(212, 1, 'google_adsense_code', 'Google Adsense Code'),
(213, 1, 'google_analytics', 'Google Analytics'),
(214, 1, 'google_analytics_code', 'Google Analytics Code'),
(215, 1, 'google_fonts', 'Google Fonts'),
(216, 1, 'google_recaptcha', 'Google reCAPTCHA'),
(217, 1, 'go_to_home', 'Go to Homepage'),
(218, 1, 'header', 'Header'),
(219, 1, 'hide', 'Hide'),
(220, 1, 'home', 'Home'),
(221, 1, 'home_title', 'Home Title'),
(222, 1, 'host', 'Host'),
(223, 1, 'hourly', 'Hourly'),
(224, 1, 'hours_ago', 'hours ago'),
(225, 1, 'hour_ago', 'hour ago'),
(226, 1, 'id', 'Id'),
(227, 1, 'image', 'Image'),
(228, 1, 'images', 'Images'),
(229, 1, 'import_language', 'Import Language'),
(230, 1, 'import_rss_feed', 'Import RSS Feed'),
(231, 1, 'inactive', 'Inactive'),
(232, 1, 'index', 'Index'),
(233, 1, 'invalid_file_type', 'Invalid File Type!'),
(234, 1, 'January', 'Jan'),
(235, 1, 'join_newsletter', 'Join Our Newsletter'),
(236, 1, 'json_language_file', 'JSON Language File'),
(237, 1, 'July', 'Jul'),
(238, 1, 'June', 'Jun'),
(239, 1, 'just_now', 'Just Now'),
(240, 1, 'keywords', 'Keywords'),
(241, 1, 'language', 'Language'),
(242, 1, 'languages', 'Languages'),
(243, 1, 'language_code', 'Language Code'),
(244, 1, 'language_name', 'Language Name'),
(245, 1, 'language_settings', 'Language Settings'),
(246, 1, 'last_modification', 'Last Modification'),
(247, 1, 'last_modification_exp', 'The time the URL was last modified'),
(248, 1, 'last_seen', 'Last seen:'),
(249, 1, 'latest_posts', 'Latest Posts'),
(250, 1, 'layout', 'Layout'),
(251, 1, 'leave_message', 'Leave a Message'),
(252, 1, 'leave_reply', 'Leave a Reply'),
(253, 1, 'leave_your_comment', 'Leave your comment...'),
(254, 1, 'left_to_right', 'Left to Right'),
(255, 1, 'light_mode', 'Light Mode'),
(256, 1, 'like', 'Like'),
(257, 1, 'link', 'Link'),
(258, 1, 'load_more_comments', 'Load More Comments'),
(259, 1, 'local', 'Local'),
(260, 1, 'location', 'Location'),
(261, 1, 'login', 'Login'),
(262, 1, 'login_error', 'Wrong username or password!'),
(263, 1, 'logo', 'Logo'),
(264, 1, 'logout', 'Logout'),
(265, 1, 'logo_email', 'Logo Email'),
(266, 1, 'love', 'Love'),
(267, 1, 'mail', 'Mail'),
(268, 1, 'mailjet_email_address', 'Mailjet Email Address'),
(269, 1, 'mailjet_email_address_exp', 'The address you created your Mailjet account with'),
(270, 1, 'mail_is_being_sent', 'Mail is being sent. Please do not close this page until the process is finished!'),
(271, 1, 'mail_library', 'Mail Library'),
(272, 1, 'mail_service', 'Mail Service'),
(273, 1, 'mail_title', 'Mail Title'),
(274, 1, 'maintenance_mode', 'Maintenance Mode'),
(275, 1, 'main_image', 'Main Image'),
(276, 1, 'main_menu', 'Main Menu'),
(277, 1, 'main_nav', 'MAIN NAVIGATION'),
(278, 1, 'main_post_image', 'Main post image'),
(279, 1, 'manage_all_posts', 'Manage All Posts'),
(280, 1, 'March', 'Mar'),
(281, 1, 'May', 'May'),
(282, 1, 'membership', 'Membership'),
(283, 1, 'member_since', 'Member since'),
(284, 1, 'menu_limit', 'Menu Limit'),
(285, 1, 'message', 'Message'),
(286, 1, 'message_ban_error', 'Your account has been banned!'),
(287, 1, 'message_change_password', 'Your password has been successfully changed!'),
(288, 1, 'message_contact_error', 'There was a problem while sending your message!'),
(289, 1, 'message_contact_success', 'Your message has been sent successfully!'),
(290, 1, 'message_invalid_email', 'Invalid email address!'),
(291, 1, 'message_login_for_comment', 'You need to login to write a comment!'),
(292, 1, 'message_newsletter_error', 'Your email address is already registered!'),
(293, 1, 'message_newsletter_success', 'Your email address has been successfully added!'),
(294, 1, 'message_page_auth', 'You must be logged in to view this page!'),
(295, 1, 'message_post_auth', 'You must be logged in to view this post!'),
(296, 1, 'message_profile', 'Profile updated successfully!'),
(297, 1, 'message_register_error', 'There was a problem during registration. Please try again!'),
(298, 1, 'message_slug_error', 'The slug you entered is being used by another user!'),
(299, 1, 'meta_tag', 'Meta Tag'),
(300, 1, 'minutes_ago', 'minutes ago'),
(301, 1, 'minute_ago', 'minute ago'),
(302, 1, 'mobile_logo', 'Mobile Logo'),
(303, 1, 'monthly', 'Monthly'),
(304, 1, 'months_ago', 'months ago'),
(305, 1, 'month_ago', 'month ago'),
(306, 1, 'more', 'More'),
(307, 1, 'more_info', 'More info'),
(308, 1, 'more_main_images', 'More main images (slider will be active)'),
(309, 1, 'msg_add_picked', 'Post added to our picks!'),
(310, 1, 'msg_add_slider', 'Post added to slider!'),
(311, 1, 'msg_ban_removed', 'User ban successfully removed!'),
(312, 1, 'msg_comment_approved', 'Comment successfully approved!'),
(313, 1, 'msg_comment_sent_successfully', 'Your comment has been sent. It will be published after being reviewed by the site management.'),
(314, 1, 'msg_cron_feed', 'With this URL you can automatically update your feeds.'),
(315, 1, 'msg_cron_sitemap', 'With this URL you can automatically update your sitemap.'),
(316, 1, 'msg_deleted', 'Item successfully deleted!'),
(317, 1, 'msg_delete_album', 'Please delete categories belonging to this album first!'),
(318, 1, 'msg_delete_images', 'Please delete images belonging to this category first!'),
(319, 1, 'msg_delete_posts', 'Please delete posts belonging to this category first!'),
(320, 1, 'msg_delete_subcategories', 'Please delete subcategories belonging to this category first!'),
(321, 1, 'msg_email_sent', 'Email successfully sent!'),
(322, 1, 'msg_error', 'An error occurred please try again!'),
(323, 1, 'msg_img_uploaded', 'Image Successfully Uploaded!'),
(324, 1, 'msg_item_added', 'Item successfully added!'),
(325, 1, 'msg_language_delete', 'Default language cannot be deleted!'),
(326, 1, 'msg_page_delete', 'Default pages can not be deleted!'),
(327, 1, 'msg_page_slug_error', 'Invalid page slug!'),
(328, 1, 'msg_post_approved', 'Post approved!'),
(329, 1, 'msg_published', 'Post successfully published!'),
(330, 1, 'msg_recaptcha', 'Please confirm that you are not a robot!'),
(331, 1, 'msg_register_success', 'Your account has been created successfully!'),
(332, 1, 'msg_remove_picked', 'Post removed from our picks!'),
(333, 1, 'msg_remove_slider', 'Post removed from slider!'),
(334, 1, 'msg_reset_cache', 'All cache files have been deleted!'),
(335, 1, 'msg_reset_password_success', 'We\'ve sent an email for resetting your password to your email address. Please check your email for next steps.'),
(336, 1, 'msg_role_changed', 'User role successfully changed!'),
(337, 1, 'msg_rss_warning', 'If you chose to download the images to your server, adding posts will take more time and will use more resources. If you see any problems, increase \'max_execution_time\' and \'memory_limit\' values from your server settings.'),
(338, 1, 'msg_slug_used', 'The slug you entered is being used by another user!'),
(339, 1, 'msg_subscriber_deleted', 'Subscriber successfully deleted!'),
(340, 1, 'msg_suc_added', 'successfully added!'),
(341, 1, 'msg_suc_deleted', 'successfully deleted!'),
(342, 1, 'msg_suc_updated', 'successfully updated!'),
(343, 1, 'msg_unsubscribe', 'You will no longer receive emails from us!'),
(344, 1, 'msg_updated', 'Changes successfully saved!'),
(345, 1, 'msg_username_unique_error', 'The username has already been taken.'),
(346, 1, 'msg_user_added', 'User successfully added!'),
(347, 1, 'msg_user_banned', 'User successfully banned!'),
(348, 1, 'multilingual_system', 'Multilingual System'),
(349, 1, 'my_posts', 'My Posts'),
(350, 1, 'name', 'Name'),
(351, 1, 'navigation', 'Navigation'),
(352, 1, 'never', 'Never'),
(353, 1, 'newsletter', 'Newsletter'),
(354, 1, 'newsletter_desc', 'Join our subscribers list to get the latest news, updates and special offers directly in your inbox'),
(355, 1, 'newsletter_email_error', 'Select email addresses that you want to send mail!'),
(356, 1, 'newsletter_exp', 'Subscribe here to get interesting stuff and updates!'),
(357, 1, 'newsletter_popup', 'Newsletter Popup'),
(358, 1, 'newsletter_send_many_exp', 'Some servers do not allow mass mailing. Therefore, instead of sending your mails to all subscribers at once, you can send them part by part (Example: 50 subscribers at once). If your mail server stops sending mail, the sending process will also stop.'),
(359, 1, 'new_password', 'New Password'),
(360, 1, 'no', 'No'),
(361, 1, 'none', 'None'),
(362, 1, 'November', 'Nov'),
(363, 1, 'no_thanks', 'No, thanks'),
(364, 1, 'number_of_days', 'Number of Days'),
(365, 1, 'number_of_days_exp', 'If you add 30 here, the system will delete posts older than 30 days'),
(366, 1, 'number_of_posts_import', 'Number of Posts to Import'),
(367, 1, 'October', 'Oct'),
(368, 1, 'ok', 'OK'),
(369, 1, 'old_password', 'Old Password'),
(370, 1, 'online', 'Online'),
(371, 1, 'optional', 'Optional'),
(372, 1, 'optional_url', 'Optional Url'),
(373, 1, 'optional_url_name', 'Post Optional Url Button Name'),
(374, 1, 'options', 'Options'),
(375, 1, 'option_1', 'Option 1'),
(376, 1, 'option_10', 'Option 10'),
(377, 1, 'option_2', 'Option 2'),
(378, 1, 'option_3', 'Option 3'),
(379, 1, 'option_4', 'Option 4'),
(380, 1, 'option_5', 'Option 5'),
(381, 1, 'option_6', 'Option 6'),
(382, 1, 'option_7', 'Option 7'),
(383, 1, 'option_8', 'Option 8'),
(384, 1, 'option_9', 'Option 9'),
(385, 1, 'or', 'or'),
(386, 1, 'order', 'Order'),
(387, 1, 'or_login_with_email', 'Or login with email'),
(388, 1, 'or_register_with_email', 'Or register with email'),
(389, 1, 'our_picks', 'Our Picks'),
(390, 1, 'page', 'Page'),
(391, 1, 'pages', 'Pages'),
(392, 1, 'page_not_found', 'Page not found'),
(393, 1, 'page_not_found_sub', 'The page you are looking for doesn\'t exist.'),
(394, 1, 'page_type', 'Page Type'),
(395, 1, 'pagination_number_posts', 'Number of Posts Per Page (Pagination)'),
(396, 1, 'panel', 'Panel'),
(397, 1, 'paragraph', 'Paragraph'),
(398, 1, 'parent_category', 'Parent Category'),
(399, 1, 'parent_link', 'Parent Link'),
(400, 1, 'password', 'Password'),
(401, 1, 'paste_ad_code', 'Ad Code'),
(402, 1, 'paste_ad_url', 'Ad Url'),
(403, 1, 'pending_comments', 'Pending Comments'),
(404, 1, 'pending_posts', 'Pending Posts'),
(405, 1, 'permissions', 'Permissions'),
(406, 1, 'phone', 'Phone'),
(407, 1, 'phrases', 'Phrases'),
(408, 1, 'please_select_option', 'Please select an option!'),
(409, 1, 'png_not_animated', 'PNG (Not Animated)'),
(410, 1, 'poll', 'Poll'),
(411, 1, 'polls', 'Polls'),
(412, 1, 'popular_posts', 'Popular Posts'),
(413, 1, 'port', 'Port'),
(414, 1, 'post', 'Post'),
(415, 1, 'posts', 'Posts'),
(416, 1, 'post_comment', 'Post Comment'),
(417, 1, 'post_details', 'Post Details'),
(418, 1, 'post_owner', 'Post Owner'),
(419, 1, 'post_type', 'Post Type'),
(420, 1, 'preview', 'Preview'),
(421, 1, 'primary_font', 'Primary Font (Main)'),
(422, 1, 'priority', 'Priority'),
(423, 1, 'priority_exp', 'The priority of a particular URL relative to other pages on the same site'),
(424, 1, 'priority_none', 'Automatically Calculated Priority'),
(425, 1, 'profile', 'Profile'),
(426, 1, 'protocol', 'Protocol'),
(427, 1, 'publish', 'Publish'),
(428, 1, 'question', 'Question'),
(429, 1, 'random_posts', 'Random Posts'),
(430, 1, 'reading_list', 'Reading List'),
(431, 1, 'reading_list_empty', 'Your reading list is empty.'),
(432, 1, 'readmore', 'Read More'),
(433, 1, 'read_more_button_text', 'Read More Button Text'),
(434, 1, 'recently_added_comments', 'Recently added comments'),
(435, 1, 'recently_added_contact_messages', 'Recently added contact messages'),
(436, 1, 'recently_added_unapproved_comments', 'Recently added unapproved comments'),
(437, 1, 'recently_registered_users', 'Recently registered users'),
(438, 1, 'refresh_cache_database_changes', 'Refresh Cache Files When Database Changes'),
(439, 1, 'register', 'Register'),
(440, 1, 'registered_emails', 'Registered Emails'),
(441, 1, 'registration_system', 'Registration System'),
(442, 1, 'related_posts', 'Related Posts'),
(443, 1, 'remove_ban', 'Remove Ban'),
(444, 1, 'remove_picked', 'Remove From Our Picks'),
(445, 1, 'remove_slider', 'Remove From Slider'),
(446, 1, 'reply', 'Reply'),
(447, 1, 'reply_to', 'Reply to'),
(448, 1, 'reset_cache', 'Reset Cache'),
(449, 1, 'reset_password', 'Reset Password'),
(450, 1, 'reset_password_error', 'We can\'t find a user with that e-mail address!'),
(451, 1, 'right_to_left', 'Right to Left'),
(452, 1, 'role', 'Role'),
(453, 1, 'roles', 'Roles'),
(454, 1, 'roles_permissions', 'Roles Permissions'),
(455, 1, 'role_name', 'Role Name'),
(456, 1, 'rss', 'RSS'),
(457, 1, 'rss_feeds', 'RSS Feeds'),
(458, 1, 'sad', 'Sad'),
(459, 1, 'save', 'Save'),
(460, 1, 'save_changes', 'Save Changes'),
(461, 1, 'save_draft', 'Save as Draft'),
(462, 1, 'search', 'Search'),
(463, 1, 'search_exp', 'Search...'),
(464, 1, 'search_noresult', 'No results found.'),
(465, 1, 'secondary_font', 'Secondary Font (Titles)'),
(466, 1, 'secret_key', 'Secret Key'),
(467, 1, 'select', 'Select'),
(468, 1, 'select_ad_spaces', 'Select Ad Space'),
(469, 1, 'select_file', 'Select File'),
(470, 1, 'select_image', 'Select image'),
(471, 1, 'select_images', 'Select images'),
(472, 1, 'select_multiple_images', 'You can select multiple images.'),
(473, 1, 'select_option', 'Select an option'),
(474, 1, 'send_email', 'Send Email'),
(475, 1, 'send_reset_link', 'Send Password Reset Link'),
(476, 1, 'send_test_email', 'Send Test Email'),
(477, 1, 'send_test_email_exp', 'You can send a test mail to check if your mail server is working.'),
(478, 1, 'seo_options', 'SEO options'),
(479, 1, 'seo_tools', 'SEO Tools'),
(480, 1, 'September', 'Sep'),
(481, 1, 'server_response', 'Server\'s Response'),
(482, 1, 'settings', 'Settings'),
(483, 1, 'settings_language', 'Settings Language'),
(484, 1, 'set_as_album_cover', 'Set as Album Cover'),
(485, 1, 'set_as_default', 'Set as Default'),
(486, 1, 'shared', 'Shared'),
(487, 1, 'short_form', 'Short Form'),
(488, 1, 'show', 'Show'),
(489, 1, 'show_all_files', 'Show all Files'),
(490, 1, 'show_breadcrumb', 'Show Breadcrumb'),
(491, 1, 'show_cookies_warning', 'Show Cookies Warning'),
(492, 1, 'show_email_on_profile', 'Show Email on Profile Page'),
(493, 1, 'show_images_from_original_source', 'Show Images from Original Source'),
(494, 1, 'show_only_own_files', 'Show Only Users Own Files'),
(495, 1, 'show_only_registered', 'Show Only to Registered Users'),
(496, 1, 'show_on_menu', 'Show on Menu'),
(497, 1, 'show_post_view_counts', 'Show Post View Counts'),
(498, 1, 'show_read_more_button', 'Show Read More Button'),
(499, 1, 'show_right_column', 'Show Right Column'),
(500, 1, 'show_title', 'Show Title'),
(501, 1, 'sidebar', 'Sidebar'),
(502, 1, 'sitemap', 'Sitemap'),
(503, 1, 'site_color', 'Site Color'),
(504, 1, 'site_comments', 'Comments'),
(505, 1, 'site_description', 'Site Description'),
(506, 1, 'site_font', 'Site Font'),
(507, 1, 'site_key', 'Site Key'),
(508, 1, 'site_language', 'Site Language'),
(509, 1, 'site_title', 'Site Title'),
(510, 1, 'slider', 'Slider'),
(511, 1, 'slider_order', 'Slider Order'),
(512, 1, 'slider_posts', 'Slider Posts'),
(513, 1, 'slug', 'Slug'),
(514, 1, 'slug_exp', 'If you leave it blank, it will be generated automatically.'),
(515, 1, 'smtp', 'SMTP'),
(516, 1, 'social_accounts', 'Social Accounts'),
(517, 1, 'social_login_settings', 'Social Login Settings'),
(518, 1, 'social_media', 'Social Media'),
(519, 1, 'social_media_settings', 'Social Media Settings'),
(520, 1, 'status', 'Status'),
(521, 1, 'subcategories', 'Subcategories'),
(522, 1, 'subcategory', 'Subcategory'),
(523, 1, 'subject', 'Subject'),
(524, 1, 'submit', 'Submit'),
(525, 1, 'subscribe', 'Subscribe'),
(526, 1, 'subscribers', 'Subscribers'),
(527, 1, 'summary', 'Summary'),
(528, 1, 'tag', 'Tag'),
(529, 1, 'tags', 'Tags'),
(530, 1, 'terms_conditions', 'Terms & Conditions'),
(531, 1, 'terms_conditions_exp', 'I have read and agree to the'),
(532, 1, 'tertiary_font', 'Tertiary Font (Post & Page Text)'),
(533, 1, 'text_direction', 'Text Direction'),
(534, 1, 'text_editor_language', 'Text Editor Language'),
(535, 1, 'themes', 'Themes'),
(536, 1, 'timezone', 'Timezone'),
(537, 1, 'title', 'Title'),
(538, 1, 'top_menu', 'Top Menu'),
(539, 1, 'total_vote', 'Total Vote:'),
(540, 1, 'translation', 'Translation'),
(541, 1, 'txt_processing', 'Processing...'),
(542, 1, 'type_tag', 'Type tag and hit enter'),
(543, 1, 'unfollow', 'Unfollow'),
(544, 1, 'unsubscribe', 'Unsubscribe'),
(545, 1, 'unsubscribe_successful', 'Unsubscribe Successful!'),
(546, 1, 'update', 'Update'),
(547, 1, 'update_album', 'Update Album'),
(548, 1, 'update_category', 'Update Category'),
(549, 1, 'update_font', 'Update Font'),
(550, 1, 'update_image', 'Update Image'),
(551, 1, 'update_language', 'Update Language'),
(552, 1, 'update_link', 'Update Menu Link'),
(553, 1, 'update_page', 'Update Page'),
(554, 1, 'update_poll', 'Update Poll'),
(555, 1, 'update_post', 'Update Post'),
(556, 1, 'update_profile', 'Update Profile'),
(557, 1, 'update_rss_feed', 'Update Rss Feed'),
(558, 1, 'update_subcategory', 'Update Subcategory'),
(559, 1, 'update_video', 'Update Video'),
(560, 1, 'uploading', 'Uploading...'),
(561, 1, 'upload_image', 'Upload Image'),
(562, 1, 'upload_your_banner', 'Create Ad Code'),
(563, 1, 'url', 'Url'),
(564, 1, 'user', 'User'),
(565, 1, 'username', 'Username'),
(566, 1, 'username_or_email', 'Username or email'),
(567, 1, 'users', 'Users'),
(568, 1, 'video', 'Video'),
(569, 1, 'video_embed_code', 'Video Embed Code'),
(570, 1, 'video_image', 'Video Image'),
(571, 1, 'video_thumbnails', 'Video Thumbnails'),
(572, 1, 'video_url', 'Video Url'),
(573, 1, 'view_all', 'View All'),
(574, 1, 'view_options', 'View Options'),
(575, 1, 'view_results', 'View Results'),
(576, 1, 'view_site', 'View Site'),
(577, 1, 'visibility', 'Visibility'),
(578, 1, 'visual_settings', 'Visual Settings'),
(579, 1, 'vote', 'Vote'),
(580, 1, 'voted_message', 'You already voted this poll before.'),
(581, 1, 'voting_poll', 'Voting Poll'),
(582, 1, 'warning', 'Warning!'),
(583, 1, 'weekly', 'Weekly'),
(584, 1, 'whats_your_reaction', 'What\'s Your Reaction?'),
(585, 1, 'wow', 'Wow'),
(586, 1, 'wrong_password_error', 'Wrong old password!'),
(587, 1, 'yearly', 'Yearly'),
(588, 1, 'years_ago', 'years ago'),
(589, 1, 'year_ago', 'year ago'),
(590, 1, 'yes', 'Yes');

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` int(11) NOT NULL,
  `lang_id` tinyint(4) DEFAULT 1,
  `title` varchar(500) DEFAULT NULL,
  `page_description` varchar(500) DEFAULT NULL,
  `page_keywords` varchar(500) DEFAULT NULL,
  `slug` varchar(500) DEFAULT NULL,
  `is_custom` tinyint(1) DEFAULT 1,
  `page_content` longtext DEFAULT NULL,
  `page_order` int(11) DEFAULT 5,
  `page_active` tinyint(1) DEFAULT 1,
  `title_active` tinyint(1) DEFAULT 1,
  `breadcrumb_active` tinyint(1) DEFAULT 1,
  `right_column_active` tinyint(1) DEFAULT 1,
  `need_auth` tinyint(1) DEFAULT 0,
  `location` varchar(255) DEFAULT 'header',
  `link` varchar(1000) DEFAULT NULL,
  `parent_id` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `lang_id`, `title`, `page_description`, `page_keywords`, `slug`, `is_custom`, `page_content`, `page_order`, `page_active`, `title_active`, `breadcrumb_active`, `right_column_active`, `need_auth`, `location`, `link`, `parent_id`, `created_at`) VALUES
(1, 1, 'Gallery', 'Gallery Page', 'gallery, Ebook', 'gallery', 0, NULL, 5, 1, 1, 1, 0, 0, 'header', NULL, 0, '2023-04-09 01:34:08'),
(2, 1, 'Contact', 'Contact Page', 'contact, Ebook', 'contact', 0, NULL, 1, 1, 1, 1, 0, 0, 'top', NULL, 0, '2023-04-09 01:34:08'),
(3, 1, 'Terms & Conditions', 'Terms & Conditions Page', 'terms, conditions, Ebook', 'terms-conditions', 0, NULL, 1, 1, 1, 1, 0, 0, 'footer', NULL, 0, '2023-04-09 01:34:08');

-- --------------------------------------------------------

--
-- Table structure for table `photos`
--

CREATE TABLE `photos` (
  `id` int(11) NOT NULL,
  `lang_id` tinyint(4) DEFAULT 1,
  `title` varchar(500) DEFAULT NULL,
  `album_id` int(11) DEFAULT 1,
  `category_id` int(11) DEFAULT NULL,
  `path_big` varchar(255) DEFAULT NULL,
  `path_small` varchar(255) DEFAULT NULL,
  `is_album_cover` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `polls`
--

CREATE TABLE `polls` (
  `id` int(11) NOT NULL,
  `lang_id` tinyint(4) DEFAULT 1,
  `question` text DEFAULT NULL,
  `option1` text DEFAULT NULL,
  `option2` text DEFAULT NULL,
  `option3` text DEFAULT NULL,
  `option4` text DEFAULT NULL,
  `option5` text DEFAULT NULL,
  `option6` text DEFAULT NULL,
  `option7` text DEFAULT NULL,
  `option8` text DEFAULT NULL,
  `option9` text DEFAULT NULL,
  `option10` text DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `poll_votes`
--

CREATE TABLE `poll_votes` (
  `id` int(11) NOT NULL,
  `poll_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `vote` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `lang_id` tinyint(4) DEFAULT 1,
  `title` varchar(500) DEFAULT NULL,
  `title_slug` varchar(500) DEFAULT NULL,
  `title_hash` varchar(500) DEFAULT NULL,
  `summary` varchar(1000) DEFAULT NULL,
  `content` longtext DEFAULT NULL,
  `keywords` varchar(500) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `image_big` varchar(255) DEFAULT NULL,
  `image_mid` varchar(255) DEFAULT NULL,
  `image_small` varchar(255) DEFAULT NULL,
  `image_slider` varchar(255) DEFAULT NULL,
  `image_mime` varchar(100) DEFAULT 'jpg',
  `is_slider` tinyint(1) DEFAULT 0,
  `is_picked` tinyint(1) DEFAULT 0,
  `hit` int(11) DEFAULT 0,
  `slider_order` tinyint(4) DEFAULT 0,
  `optional_url` varchar(1000) DEFAULT NULL,
  `post_type` varchar(30) DEFAULT 'post',
  `video_url` varchar(1000) DEFAULT NULL,
  `video_embed_code` varchar(1000) DEFAULT NULL,
  `image_url` varchar(1000) DEFAULT NULL,
  `need_auth` tinyint(1) DEFAULT 0,
  `feed_id` int(11) DEFAULT NULL,
  `post_url` varchar(1000) DEFAULT NULL,
  `show_post_url` tinyint(1) DEFAULT 1,
  `visibility` tinyint(1) DEFAULT 1,
  `status` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `post_files`
--

CREATE TABLE `post_files` (
  `id` int(11) NOT NULL,
  `post_id` int(11) DEFAULT NULL,
  `file_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `post_images`
--

CREATE TABLE `post_images` (
  `id` int(11) NOT NULL,
  `post_id` int(11) DEFAULT NULL,
  `image_path` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reactions`
--

CREATE TABLE `reactions` (
  `id` int(11) NOT NULL,
  `post_id` int(11) DEFAULT NULL,
  `re_like` int(11) DEFAULT 0,
  `re_dislike` int(11) DEFAULT 0,
  `re_love` int(11) DEFAULT 0,
  `re_funny` int(11) DEFAULT 0,
  `re_angry` int(11) DEFAULT 0,
  `re_sad` int(11) DEFAULT 0,
  `re_wow` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reading_lists`
--

CREATE TABLE `reading_lists` (
  `id` int(11) NOT NULL,
  `post_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles_permissions`
--

CREATE TABLE `roles_permissions` (
  `id` int(11) NOT NULL,
  `role_name` text DEFAULT NULL,
  `permissions` text DEFAULT NULL,
  `is_super_admin` tinyint(1) DEFAULT 0,
  `is_admin` tinyint(1) DEFAULT 0,
  `is_author` tinyint(1) DEFAULT 0,
  `is_default` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `roles_permissions`
--

INSERT INTO `roles_permissions` (`id`, `role_name`, `permissions`, `is_super_admin`, `is_admin`, `is_author`, `is_default`) VALUES
(1, 'a:1:{i:0;a:2:{s:7:\"lang_id\";s:1:\"1\";s:4:\"name\";s:11:\"Super Admin\";}}', 'all', 1, 1, 1, 1),
(2, 'a:1:{i:0;a:2:{s:7:\"lang_id\";s:1:\"1\";s:4:\"name\";s:6:\"Author\";}}', '2', 0, 0, 1, 1),
(3, 'a:1:{i:0;a:2:{s:7:\"lang_id\";s:1:\"1\";s:4:\"name\";s:6:\"Member\";}}', '', 0, 0, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `rss_feeds`
--

CREATE TABLE `rss_feeds` (
  `id` int(11) NOT NULL,
  `lang_id` int(11) DEFAULT 1,
  `feed_name` varchar(500) DEFAULT NULL,
  `feed_url` varchar(1000) DEFAULT NULL,
  `post_limit` smallint(6) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `image_saving_method` varchar(30) DEFAULT 'url',
  `generate_keywords_from_title` tinyint(1) NOT NULL DEFAULT 1,
  `auto_update` tinyint(1) DEFAULT 1,
  `read_more_button` tinyint(1) DEFAULT 1,
  `read_more_button_text` varchar(255) DEFAULT 'Read More',
  `user_id` int(11) DEFAULT NULL,
  `add_posts_as_draft` tinyint(1) DEFAULT 0,
  `is_cron_updated` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `lang_id` tinyint(4) DEFAULT 1,
  `application_name` varchar(255) DEFAULT 'Ebook',
  `site_title` varchar(255) DEFAULT NULL,
  `home_title` varchar(255) DEFAULT NULL,
  `site_description` varchar(500) DEFAULT NULL,
  `keywords` varchar(500) DEFAULT NULL,
  `primary_font` smallint(6) DEFAULT 19,
  `secondary_font` smallint(6) DEFAULT 25,
  `facebook_url` varchar(500) DEFAULT NULL,
  `twitter_url` varchar(500) DEFAULT NULL,
  `instagram_url` varchar(500) DEFAULT NULL,
  `pinterest_url` varchar(500) DEFAULT NULL,
  `linkedin_url` varchar(500) DEFAULT NULL,
  `vk_url` varchar(500) DEFAULT NULL,
  `telegram_url` varchar(500) DEFAULT NULL,
  `youtube_url` varchar(500) DEFAULT NULL,
  `optional_url_button_name` varchar(500) DEFAULT 'Click Here to Visit',
  `about_footer` varchar(1000) DEFAULT NULL,
  `contact_text` text DEFAULT NULL,
  `contact_address` varchar(500) DEFAULT NULL,
  `contact_email` varchar(255) DEFAULT NULL,
  `contact_phone` varchar(255) DEFAULT NULL,
  `copyright` varchar(500) DEFAULT 'Copyright 2022 Ebook - All Rights Reserved.',
  `cookies_warning` tinyint(1) DEFAULT 0,
  `cookies_warning_text` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `lang_id`, `application_name`, `site_title`, `home_title`, `site_description`, `keywords`, `primary_font`, `secondary_font`, `facebook_url`, `twitter_url`, `instagram_url`, `pinterest_url`, `linkedin_url`, `vk_url`, `telegram_url`, `youtube_url`, `optional_url_button_name`, `about_footer`, `contact_text`, `contact_address`, `contact_email`, `contact_phone`, `copyright`, `cookies_warning`, `cookies_warning_text`) VALUES
(1, 1, 'Ebook', 'Ebook - ', 'Index', 'Ebook - Script', 'Ebook, Blog, Magazine', 19, 25, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Click Here to Visit', NULL, NULL, NULL, NULL, NULL, 'Copyright 2023 Ebook - All Rights Reserved.', 1, '<p>This site uses cookies. By continuing to browse the site you are agreeing to our use of cookies <a href=\"#\">Find out more here</a></p>');

-- --------------------------------------------------------

--
-- Table structure for table `subscribers`
--

CREATE TABLE `subscribers` (
  `id` int(11) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `id` int(11) NOT NULL,
  `post_id` int(11) DEFAULT NULL,
  `tag` varchar(255) DEFAULT NULL,
  `tag_slug` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT 'name@domain.com',
  `password` varchar(255) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `role_id` smallint(6) DEFAULT 3,
  `user_type` varchar(30) DEFAULT 'registered',
  `google_id` varchar(255) DEFAULT NULL,
  `facebook_id` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `about_me` varchar(5000) DEFAULT NULL,
  `last_seen` timestamp NULL DEFAULT NULL,
  `facebook_url` varchar(500) DEFAULT NULL,
  `twitter_url` varchar(500) DEFAULT NULL,
  `instagram_url` varchar(500) DEFAULT NULL,
  `pinterest_url` varchar(500) DEFAULT NULL,
  `linkedin_url` varchar(500) DEFAULT NULL,
  `vk_url` varchar(500) DEFAULT NULL,
  `telegram_url` varchar(500) DEFAULT NULL,
  `youtube_url` varchar(500) DEFAULT NULL,
  `show_email_on_profile` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ad_spaces`
--
ALTER TABLE `ad_spaces`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_lang_id` (`lang_id`),
  ADD KEY `idx_parent_id` (`parent_id`);

--
-- Indexes for table `ci_sessions`
--
ALTER TABLE `ci_sessions`
  ADD KEY `ci_sessions_timestamp` (`timestamp`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_parent_id` (`parent_id`),
  ADD KEY `idx_post_id` (`post_id`),
  ADD KEY `idx_user_id` (`user_id`),
  ADD KEY `idx_status` (`status`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user_id` (`user_id`);

--
-- Indexes for table `followers`
--
ALTER TABLE `followers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_following_id` (`following_id`),
  ADD KEY `idx_follower_id` (`follower_id`);

--
-- Indexes for table `fonts`
--
ALTER TABLE `fonts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gallery_albums`
--
ALTER TABLE `gallery_albums`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gallery_categories`
--
ALTER TABLE `gallery_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `general_settings`
--
ALTER TABLE `general_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user_id` (`user_id`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `language_translations`
--
ALTER TABLE `language_translations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_lang_id` (`lang_id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `photos`
--
ALTER TABLE `photos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `polls`
--
ALTER TABLE `polls`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `poll_votes`
--
ALTER TABLE `poll_votes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_lang_id` (`lang_id`),
  ADD KEY `idx_category_id` (`category_id`),
  ADD KEY `idx_is_slider` (`is_slider`),
  ADD KEY `idx_is_picked` (`is_picked`),
  ADD KEY `idx_visibility` (`visibility`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_created_at` (`created_at`),
  ADD KEY `idx_user_id` (`user_id`);

--
-- Indexes for table `post_files`
--
ALTER TABLE `post_files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `post_images`
--
ALTER TABLE `post_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reactions`
--
ALTER TABLE `reactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reading_lists`
--
ALTER TABLE `reading_lists`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles_permissions`
--
ALTER TABLE `roles_permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rss_feeds`
--
ALTER TABLE `rss_feeds`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscribers`
--
ALTER TABLE `subscribers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_post_id` (`post_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ad_spaces`
--
ALTER TABLE `ad_spaces`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `followers`
--
ALTER TABLE `followers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fonts`
--
ALTER TABLE `fonts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `gallery_albums`
--
ALTER TABLE `gallery_albums`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gallery_categories`
--
ALTER TABLE `gallery_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `general_settings`
--
ALTER TABLE `general_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `language_translations`
--
ALTER TABLE `language_translations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=591;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `photos`
--
ALTER TABLE `photos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `polls`
--
ALTER TABLE `polls`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `poll_votes`
--
ALTER TABLE `poll_votes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `post_files`
--
ALTER TABLE `post_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `post_images`
--
ALTER TABLE `post_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reactions`
--
ALTER TABLE `reactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reading_lists`
--
ALTER TABLE `reading_lists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles_permissions`
--
ALTER TABLE `roles_permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `rss_feeds`
--
ALTER TABLE `rss_feeds`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `subscribers`
--
ALTER TABLE `subscribers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
