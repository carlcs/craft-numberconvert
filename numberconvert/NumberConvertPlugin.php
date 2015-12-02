<?php
namespace Craft;

class NumberConvertPlugin extends BasePlugin
{
	function getName()
	{
		return 'Number Convert';
	}

	function getVersion()
	{
		return '1.1';
	}

	function getSchemaVersion()
	{
		return null;
	}

	function getDeveloper()
	{
		return 'carlcs';
	}

	function getDeveloperUrl()
	{
		return 'https://github.com/carlcs/craft-numberconvert';
	}

	function getDocumentationUrl()
	{
		return 'https://github.com/carlcs/craft-numberconvert';
	}

	function getReleaseFeedUrl()
	{
		return 'https://github.com/carlcs/craft-numberconvert/raw/master/releases.json';
	}

	public function addTwigExtension()
	{
		Craft::import('plugins.numberconvert.twigextensions.NumberConvertTwigExtension');
		return new NumberConvertTwigExtension();
	}
}
