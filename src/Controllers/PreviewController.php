<?php

namespace MarcusGaius\Preview\Controllers;

use craft\elements\Entry;
use craft\helpers\StringHelper;
use craft\web\Controller;
use MarcusGaius\Preview\Events\PreviewActionEvent;
use MarcusGaius\Preview\Preview;
use yii\web\Response;

class PreviewController extends Controller
{
	public const EVENT_CUSTOMIZE_PREVIEW_ACTION = 'customizePreviewActionEvent';

	public $defaultAction = 'index';

	public function actionIndex(string $slug, string $section): Response
	{
		$sectionHandle = StringHelper::toCamelCase($section);
		$event = new PreviewActionEvent(
			sectionHandle: $sectionHandle,
		);

		$this->trigger(self::EVENT_CUSTOMIZE_PREVIEW_ACTION, $event);
		$template = $event->template ?: sprintf("%'/s/previews/%s", Preview::getInstance()::$settings->defaultTemplatePath, $section);

		$entry = Entry::find()
			->slug(\craft\helpers\Db::escapeParam($slug))
			->section(\craft\helpers\Db::escapeParam($sectionHandle))
			->with($event->with)
			->one();

		return $this->renderTemplate($template, array_merge([
			'entry' => $entry,
		], $event->vars));
	}
}
