<?php

namespace MarcusGaius\Preview\Events;

use Exception;
use yii\base\Event;

/**
 * @property string $sectionHandle
 * @package MarcusGaius\Preview\Events
 */
class PreviewActionEvent extends Event
{
	public function __construct(
		public string $sectionHandle = '',
		public string $template = '',
		public array $with = [],
		public array $vars = [],
	) {
	}
}
