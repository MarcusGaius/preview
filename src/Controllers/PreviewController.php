<?php

namespace MarcusGaius\Preview\Controllers;

use craft\elements\Entry;
use craft\helpers\StringHelper;
use craft\web\Controller;
use craft\web\Response;
use MarcusGaius\Preview\Events\PreviewActionEvent;
use MarcusGaius\Preview\Preview;

class PreviewController extends Controller
{
	const EVENT_CUSTOMIZE_PREVIEW_ACTION = 'customizePreviewActionEvent';

	public $defaultAction = 'index';

	public function actionIndex(string $slug, string $section): Response
	{
		$event = new PreviewActionEvent();
		$event->sectionHandle = StringHelper::toCamelCase($section);

		$this->trigger(self::EVENT_CUSTOMIZE_PREVIEW_ACTION, $event);
		$template = $event->template ?: sprintf("%'/s/previews/%s", Preview::getInstance()::$settings->defaultTemplatePath, $section);

		$entry = Entry::find()
			->slug(\craft\helpers\Db::escapeParam($slug))
			->section(\craft\helpers\Db::escapeParam(StringHelper::toCamelCase($section)))
			->with($event->with)
			->one();

		return $this->renderTemplate($template, array_merge([
			'entry' => $entry,
		], $event->vars));
	}
}