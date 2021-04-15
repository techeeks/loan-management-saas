<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ThemeSetting extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'theme',
        'option',
        'value'
    ];

    /**
     * Default Theme Settings for Bikin Theme
     *
     * @var array
     */
    public static $defaultSettings = [
        'hero_title' => 'Build the Future With Foxtrot',
        'hero_description' => 'We are team of talanted engineers making applications at Varus Creative',

        'about_title' => 'Voluptatem dignissimos provident quasi',
        'about_description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Duis aute irure dolor in reprehenderit',
        'about_1_title' => 'Corporis voluptates sit',
        'about_1_description' => 'Consequuntur sunt aut quasi enim aliquam quae harum pariatur laboris nisi ut aliquip',
        'about_2_title' => 'Ullamco laboris nisi',
        'about_2_description' => 'Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt',
        'about_3_title' => 'Labore consequatur',
        'about_3_description' => 'Aut suscipit aut cum nemo deleniti aut omnis. Doloribus ut maiores omnis facere',
        'about_4_title' => 'Beatae veritatis',
        'about_4_description' => 'Expedita veritatis consequuntur nihil tempore laudantium vitae denat pacta',

        'features_title' => 'Features',
        'features_description' => 'Magnam dolores commodi suscipit. Necessitatibus eius consequatur ex aliquid fuga eum quidem. Sit sint consectetur velit. Quisquam quos quisquam cupiditate. Et nemo qui impedit suscipit alias ea. Quia fugiat sit in iste officiis commodi quidem hic quas.',
        'features_1_title' => 'Corporis voluptates sit',
        'features_1_description' => 'Consequuntur sunt aut quasi enim aliquam quae harum pariatur laboris nisi ut aliquip',
        'features_2_title' => 'Ullamco laboris nisi',
        'features_2_description' => 'Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt',
        'features_3_title' => 'Labore consequatur',
        'features_3_description' => 'Aut suscipit aut cum nemo deleniti aut omnis. Doloribus ut maiores omnis facere',
        'features_4_title' => 'Beatae veritatis',
        'features_4_description' => 'Expedita veritatis consequuntur nihil tempore laudantium vitae denat pacta',

        'services_title' => 'Services',
        'services_description' => 'Magnam dolores commodi suscipit. Necessitatibus eius consequatur ex aliquid fuga eum quidem. Sit sint consectetur velit. Quisquam quos quisquam cupiditate. Et nemo qui impedit suscipit alias ea. Quia fugiat sit in iste officiis commodi quidem hic quas.',
        'services_1_title' => 'Corporis voluptates sit',
        'services_1_description' => 'Consequuntur sunt aut quasi enim aliquam quae harum pariatur laboris nisi ut aliquip',
        'services_2_title' => 'Ullamco laboris nisi',
        'services_2_description' => 'Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt',
        'services_3_title' => 'Labore consequatur',
        'services_3_description' => 'Aut suscipit aut cum nemo deleniti aut omnis. Doloribus ut maiores omnis facere',
        'services_4_title' => 'Beatae veritatis',
        'services_4_description' => 'Expedita veritatis consequuntur nihil tempore laudantium vitae denat pacta',

        'faq_1_title' => 'FAQ 1',
        'faq_1_description' => 'Consequuntur sunt aut quasi enim aliquam quae harum pariatur laboris nisi ut aliquip',
        'faq_2_title' => 'FAQ 2',
        'faq_2_description' => 'Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt',
        'faq_3_title' => 'FAQ 3',
        'faq_3_description' => 'Aut suscipit aut cum nemo deleniti aut omnis. Doloribus ut maiores omnis facere',
        'faq_4_title' => 'FAQ 4',
        'faq_4_description' => 'Expedita veritatis consequuntur nihil tempore laudantium vitae denat pacta',
        'faq_5_title' => 'FAQ 5',
        'faq_5_description' => 'Aut suscipit consequuntur nihil tempore laudantium vitae denat pacta',
        'faq_6_title' => 'FAQ 6',
        'faq_6_description' => 'Consequuntur veritatis consequuntur nihil tempore laudantium vitae denat pacta',

        'contact_address' => 'A108 Adam Street, New York, NY 535022',
        'contact_email' => 'info@example.com',
        'contact_phone' => '+1 5589 55488 55',

        'social_twitter_link' => '',
        'social_facebook_link' => '',
        'social_instagram_link' => '',
        'social_linkedin_link' => '',
    ];

    /**
     * Set new or update existing System Settings.
     *
     * @param string $theme
     * @param string $key
     * @param string $setting
     *
     * @return void
     */
    public static function setSetting($theme, $key, $setting)
    {
        $old = self::whereTheme($theme)->whereOption($key)->first();

        if ($old) {
            $old->value = $setting;
            $old->save();
            return;
        }

        $set = new ThemeSetting();
        $set->theme = $theme;
        $set->option = $key;
        $set->value = $setting;
        $set->save();
    }
 
    /**
     * Get Default Theme Setting.
     *
     * @param string $key
     *
     * @return string|null
     */
    public static function getDefaultSetting($key)
    {
        $setting = self::$defaultSettings[$key];

        if ($setting) {
            return $setting;
        } else {
            return null;
        }
    }

    /**
     * Get Theme Setting.
     *
     * @param string $key
     *
     * @return string|null
     */
    public static function getSetting($theme, $key)
    {
        $setting = static::whereTheme($theme)->whereOption($key)->first();

        if ($setting) {
            return $setting->value;
        } else {
            return self::getDefaultSetting($key);
        }
    }
}
