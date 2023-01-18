<?php

namespace Ekremogul\FilamentFeaturedImage\Forms;

use Closure;
use Filament\Forms\Components\Field;
use Illuminate\Support\Facades\Storage;
use Livewire\TemporaryUploadedFile;

class FeaturedImage extends Field
{
    protected string $view = 'filament-featured-image::forms.components.fields.featured-image';

    protected bool $hasDefaultState = true;

    public ?Closure $image = null;
    public ?string $backgroundColor = null;
    public ?string $titlePosition = "top";
    public array $tags = [];
    public array $lines = [
        "position" => "left",
        "gradient" => null,
        "tag" => null,
        "tagPosition" => "top-right",
        "line1" => [
            "text" => null,
            "width" => 60,
            "color" => '#ffffff',
            "shadow" => null,
            "size" => 30,
            "space" => 30
        ],
        "line2" => [
            "text" => null,
            "width" => 60,
            "color" => "#ffffff",
            "shadow" => null,
            "size" => 30,
            "space" => 30
        ],
        "line3" => [
            "text" => null,
            "width" => 60,
            "color" => "#ffffff",
            "shadow" => null,
            "size" => 30,
            "space" => 30
        ],
    ];

    protected function setUp(): void
    {
        parent::setUp();
        $this->tags = config("filament-featured-image.tags");
    }

    public function imageField(string $field): static
    {
        return $this->image(function (Closure $get) use ($field) {
            $imageState = collect($get($field))?->first();

            if($imageState instanceof TemporaryUploadedFile) {
                return $imageState->temporaryUrl();
            }
            return is_string($imageState) ? Storage::url($imageState) : null;
        });
    }

    public function image(string | Closure | null $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->evaluate($this->image);
    }

    public function getLines()
    {
        return $this->lines;
    }

    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param array $tags
     */
    public function setTags(array $tags): void
    {
        $this->tags = $tags;
    }
}
