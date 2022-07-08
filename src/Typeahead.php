<?php

declare(strict_types=1);

namespace Mailery\Widget\Typeahead;

use Yiisoft\Assets\AssetManager;
use Yiisoft\Html\Html;
use Yiisoft\Form\Field\Base\InputField;
use Yiisoft\Form\Field\Base\EnrichmentFromRules\EnrichmentFromRulesTrait;
use Yiisoft\Form\Field\Base\EnrichmentFromRules\EnrichmentFromRulesInterface;
use Yiisoft\Form\Field\Base\ValidationClass\ValidationClassTrait;
use Yiisoft\Form\Field\Base\ValidationClass\ValidationClassInterface;
use Yiisoft\Form\Field\Base\Placeholder\PlaceholderInterface;
use Yiisoft\Form\Field\Base\Placeholder\PlaceholderTrait;

class Typeahead extends InputField implements EnrichmentFromRulesInterface, ValidationClassInterface, PlaceholderInterface
{

    use EnrichmentFromRulesTrait;
    use ValidationClassTrait;
    use PlaceholderTrait;

    /**
     * @param AssetManager $assetManager
     */
    public function __construct(
        private AssetManager $assetManager
    ) {}

    /**
     * @param int $value
     * @return self
     */
    public function maxlength(int $value): self
    {
        $new = clone $this;
        $new->inputAttributes['maxlength'] = $value;
        return $new;
    }

    /**
     * @param int $value
     * @return self
     */
    public function minlength(int $value): self
    {
        $new = clone $this;
        $new->inputAttributes['minlength'] = $value;
        return $new;
    }

    /**
     * @param string $value
     * @return self
     */
    public function pattern(string $value): self
    {
        $new = clone $this;
        $new->inputAttributes['pattern'] = $value;
        return $new;
    }

    /**
     * @param string $value
     * @return self
     */
    public function url(string $value): self
    {
        $new = clone $this;
        $new->inputAttributes['url'] = $value;
        return $new;
    }

    /**
     * @param string $value
     * @return self
     */
    public function type(string $value): self
    {
        $new = clone $this;
        $new->inputAttributes['type'] = $value;
        return $new;
    }

    /**
     * @inheritdoc
     */
    protected function generateInput(): string
    {
        $this->assetManager->register(TypeaheadAssetBundle::class);

        $attributes = $this->getInputAttributes();

        $attributes['value'] ??= $this->getFormAttributeValue();

        if (null !== $attributes['value'] && !is_string($attributes['value'])) {
            throw new \InvalidArgumentException('Typeahead value must be a string or null value.');
        }

        $attributes['type'] ??= 'text';
        $attributes['name'] ??= $this->getInputName();
        $attributes['class-name'] = implode(' ', $attributes['class'] ?? '');
        unset($attributes['class']);

        return Html::tag('ui-typeahead', '', $attributes)->render();
    }

}