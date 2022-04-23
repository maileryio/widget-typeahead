<?php

declare(strict_types=1);

namespace Mailery\Widget\Typeahead;

use InvalidArgumentException;
use Yiisoft\Form\Widget\Attribute\InputAttributes;
use Yiisoft\Form\Widget\Attribute\PlaceholderInterface;
use Yiisoft\Form\Widget\Validator\HasLengthInterface;
use Yiisoft\Form\Widget\Validator\RegexInterface;
use Yiisoft\Html\Html;
use Mailery\Assets\AssetBundleRegistry;
use Mailery\Widget\Typeahead\RbacAssetBundle;

class Typeahead extends InputAttributes implements HasLengthInterface, RegexInterface, PlaceholderInterface
{

    /**
     * @param AssetBundleRegistry $assetBundleRegistry
     */
    public function __construct(
        private AssetBundleRegistry $assetBundleRegistry
    ) {}

    /**
     * @param int $value
     * @return self
     */
    public function maxlength(int $value): self
    {
        $new = clone $this;
        $new->attributes['maxlength'] = $value;
        return $new;
    }

    /**
     * @param int $value
     * @return self
     */
    public function minlength(int $value): self
    {
        $new = clone $this;
        $new->attributes['minlength'] = $value;
        return $new;
    }

    /**
     * @param string $value
     * @return self
     */
    public function pattern(string $value): self
    {
        $new = clone $this;
        $new->attributes['pattern'] = $value;
        return $new;
    }

    /**
     * @param string $value
     * @return self
     */
    public function placeholder(string $value): self
    {
        $new = clone $this;
        $new->attributes['placeholder'] = $value;
        return $new;
    }

    /**
     * @param string $value
     * @return self
     */
    public function url(string $value): self
    {
        $new = clone $this;
        $new->attributes['url'] = $value;
        return $new;
    }

    /**
     * @param string $value
     * @return self
     */
    public function type(string $value): self
    {
        $new = clone $this;
        $new->attributes['type'] = $value;
        return $new;
    }

    /**
     * @inheritdoc
     */
    protected function run(): string
    {
        $this->assetBundleRegistry->add(RbacAssetBundle::class);

        $attributes = $this->build($this->attributes);

        /** @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.text.html#input.text.attrs.value */
        $attributes['value'] = $attributes['value'] ?? $this->getAttributeValue();

        if (null !== $attributes['value'] && !is_string($attributes['value'])) {
            throw new InvalidArgumentException('Text widget must be a string or null value.');
        }

        $attributes['type'] = $attributes['type'] ?? 'text';
        $attributes['classname'] = $attributes['class'] ?? '';

        unset($attributes['class']);

        return Html::tag('ui-typeahead', '', $attributes)->render();
    }

}