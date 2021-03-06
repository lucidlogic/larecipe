<?php

namespace BinaryTorch\LaRecipe\Tests\Feature;

use Illuminate\Support\Facades\Config;
use BinaryTorch\LaRecipe\Tests\TestCase;

class ConfigurationTest extends TestCase
{
    /** @test */
    public function repository_button_is_visible_only_if_the_repository_url_is_given()
    {
        Config::set('larecipe.repository.url', '');

        $this->get('/docs/1.0')->assertDontSee('repository_button');

        Config::set('larecipe.repository.url', 'HollyMolly');

        $this->get('/docs/1.0')->assertSee('repository_button');
    }

    /** @test */
    public function back_to_top_button_is_visible_only_if_enabled()
    {
        Config::set('larecipe.ui.back_to_top', false);
        $this->get('/docs/1.0')->assertDontSee('<larecipe-back-to-top></larecipe-back-to-top>');

        Config::set('larecipe.ui.back_to_top', true);
        $this->get('/docs/1.0')->assertSee('<larecipe-back-to-top></larecipe-back-to-top>');
    }

    /** @test */
    public function ga_script_is_visible_only_if_ga_id_is_set()
    {
        Config::set('larecipe.settings.ga_id', '');
        $this->get('/docs/1.0')
            ->assertDontSee('googletagmanager');

        Config::set('larecipe.settings.ga_id', 'ga_code_id');
        $this->get('/docs/1.0')
            ->assertSee('googletagmanager')
                ->assertSee('ga_code_id');
    }

    /** @test */
    public function app_name_is_visible_only_if_enabled()
    {
        Config::set('larecipe.ui.show_app_name', false);
        Config::set('app.name', 'hoolla');
        $this->get('/docs/1.0')
            ->assertDontSee('<span>hoolla</span>');

        Config::set('larecipe.ui.show_app_name', true);
        Config::set('app.name', 'hoolla');
        $this->get('/docs/1.0')
            ->assertSee('<span>hoolla</span>');
    }

    /** @test */
    public function seo_support()
    {
        Config::set('larecipe.seo.author', 'Binary Torch Author');
        Config::set('larecipe.seo.description', 'seo description is here');
        Config::set('larecipe.seo.keywords', 'key1, key2, key3');
        Config::set('larecipe.seo.og.title', 'open graph title');
        Config::set('larecipe.seo.og.type', 'open graph type');
        Config::set('larecipe.seo.og.url', 'open graph url');
        Config::set('larecipe.seo.og.image', 'open graph image');
        Config::set('larecipe.seo.og.description', 'open graph description');

        $this->get('/docs/1.0')
            ->assertSee('Binary Torch Author')
            ->assertSee('seo description is here')
            ->assertSee('key1, key2, key3')
            ->assertSee('open graph title')
            ->assertSee('open graph type')
            ->assertSee('open graph url')
            ->assertSee('open graph image')
            ->assertSee('open graph description');
    }

    /** @test */
    public function dynamic_color_palette()
    {
        Config::set('larecipe.ui.colors.primary', '#custom_color');
        $this->get('/docs/1.0')
            ->assertSee('#custom_color');
    }
}
