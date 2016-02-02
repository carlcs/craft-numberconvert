<?php
namespace Craft;

class NumberConvertPlugin extends BasePlugin
{
    public function getName()
    {
        return 'Number Convert';
    }

    public function getVersion()
    {
        return '1.1';
    }

    public function getSchemaVersion()
    {
        return null;
    }

    public function getDeveloper()
    {
        return 'carlcs';
    }

    public function getDeveloperUrl()
    {
        return 'https://github.com/carlcs/craft-numberconvert';
    }

    public function getDocumentationUrl()
    {
        return 'https://github.com/carlcs/craft-numberconvert';
    }

    public function getReleaseFeedUrl()
    {
        return 'https://github.com/carlcs/craft-numberconvert/raw/master/releases.json';
    }

    public function addTwigExtension()
    {
        Craft::import('plugins.numberconvert.twigextensions.NumberConvertTwigExtension');
        return new NumberConvertTwigExtension();
    }
}
