<?php

namespace MarcusGaius\Preview\Models;

use craft\base\Model;

class Settings extends Model
{
	public string $defaultTemplatePath = '';

	public function defineRules(): array
	{
		return [
			[['defaultTemplatePath'], 'string'],
		];
	}
}
