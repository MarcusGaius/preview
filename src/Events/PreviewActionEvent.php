<?php

namespace MarcusGaius\Preview\Events;

use Exception;
use yii\base\Event;

class PreviewActionEvent extends Event
{
	private string $_sectionHandle;
	public string $template = '';
	public array $with = [];
	public array $vars = [];

	public function getSectionHandle(): string
	{
		return $this->_sectionHandle;
	}

	public function setSectionHandle(string $section): self
	{
		if (isset($this->_sectionHandle) && $this->_sectionHandle !== null) throw new Exception('Section cannot be modified');

		$this->_sectionHandle = $section;

		return $this;
	}
}
