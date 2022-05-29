<?php

namespace App\Http\Controllers;

class StaticsController extends BaseController
{
    public function getFAQ()
    {
        \GoogleTagManager::set('pageType', 'faq');

        return $this->handle('pages.statics.faq', []);
    }

    public function getPress()
    {
        \GoogleTagManager::set('pageType', 'press');

        return $this->handle('pages.statics.press', []);
    }

    public function getCookies()
    {
        \GoogleTagManager::set('pageType', 'cookies');

        return $this->handle('pages.statics.cookies', []);
    }

    public function getLegals()
    {
        \GoogleTagManager::set('pageType', 'legals');

        return $this->handle('pages.statics.legals', []);
    }

    public function getManual()
    {
        \GoogleTagManager::set('pageType', 'manual');

        return $this->handle('pages.statics.manual', []);
    }

    public function getAbout()
    {
        \GoogleTagManager::set('pageType', 'about');

        return $this->handle('pages.statics.about', []);
    }
}
