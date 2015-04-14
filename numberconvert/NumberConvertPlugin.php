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
		return '1.0';
	}

	function getDeveloper()
	{
		return 'carlcs';
	}

	function getDeveloperUrl()
	{
		return 'https://github.com/carlcs/craft-numberconvert';
	}

	public function addTwigExtension()
	{
		Craft::import('plugins.numberconvert.twigextensions.NumberConvertTwigExtension');
		return new NumberConvertTwigExtension();
	}
}
