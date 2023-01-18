<x-forms::field-wrapper
    :id="$getId()"
    :label="$getLabel() . ' (Click photo for edit)'"
    :label-sr-only="$isLabelHidden()"
    :helper-text="$getHelperText()"
    :hint="$getHint()"
    :hint-icon="$getHintIcon()"
    :required="$isRequired()"
    :state-path="$getStatePath()">
    <div
        x-cloak
        x-data="{state: $wire.entangle('{{ $getStatePath() }}'), lines: {{json_encode($getLines())}}, tags: {{ json_encode($getTags()) }} }"
        x-on:close-modal.window="if($event.detail.save == true && $event.detail.id == 'featured-image-editor-{{ $getStatePath() }}') {state = $event.detail.lines;}"
        >
        @if ($getImage())
        <div class="flex flex-col"
             x-on:click="$dispatch('open-modal', {id: 'featured-image-editor-{{ $getStatePath() }}', lines: lines, tags: tags})"
        >
            <img
                src="{{ $getImage() }}"
                class="rounded-lg cursor-pointer"
            >
        </div>
        @else
            <span class="text-sm text-gray-500">{{ __('You need to provide an image.') }}</span>
        @endif
    </div>
</x-forms::field-wrapper>

<x-filament::modal
    width="6xl"
    id="featured-image-editor-{{ $getStatePath() }}"
    x-data="{lines: null, tags: null}"
    x-cloak
    x-on:open-modal.window="lines = $event.detail.lines; tags = $event.detail.tags;"
>
    <template x-if="lines">
        <div class="featured-image-edit-modal">
            <div class="image-container">
                <figure>
                    <img
                        src="{{ $getImage() }}"
                    >
                </figure>
                <div class="text-content">
                    <template x-if="lines.gradient">
                        <div
                            class="gradient"
                            :class="lines.position == 'right' ? 'right-0' : 'left-0'"
                            :style="`background: linear-gradient(${lines.position == 'left' ? 'to right,' : ''} ${lines.position == 'right' ? 'to left,' : ''} ${lines.gradient} 0%, ${lines.gradient} 65%, rgba(0,0,0,0) 100%)`"
                            style="background: linear-gradient(
                                to right,
                                #16150c 0%,
                                #16150c 65%,
                                rgba(155, 155, 155,0) 100%);"></div>
                    </template>
                    <template x-if="lines.tag">
                        <div class="flash-badge" x-bind:class="lines.tagPosition" x-html="lines.tag"></div>
                    </template>

                    <h3 :class="{'items-start': lines.position == 'left','items-end': lines.position == 'right'}">
                        <span x-html="lines.line1.text" :style="`font-size: ${lines.line1.size}px;color: ${lines.line1.color};text-shadow: 2px 2px 1px ${lines.line1.shadow};max-width: ${lines.line1.width}%;line-height: ${lines.line1.space}px;`"></span>
                        <span
                            x-html="lines.line2.text"
                            :style="`font-size: ${lines.line2.size}px;
                            color: ${lines.line2.color};
                            text-shadow: 2px 2px 1px ${lines.line2.shadow};
                            max-width: ${lines.line2.width}%;
                            line-height: ${lines.line2.space}px;
                            `"
                        ></span>
                        <span
                            x-html="lines.line3.text"
                            :style="`font-size: ${lines.line3.size}px;
                            color: ${lines.line3.color};
                            text-shadow: 2px 2px 1px ${lines.line3.shadow};
                            max-width: ${lines.line3.width}%;
                            line-height: ${lines.line3.space}px;
                            `"
                        ></span>
                    </h3>

                </div>
            </div>
            <div class="fields">
                <div class="top-fields">
                    <div class="field">
                        <label class="flex items-center gap-2">
                            Gradient Color :
                            <input type="color" x-model="lines.gradient">
                        </label>
                    </div>
                    <div class="field">
                        <label class="flex items-center gap-2">
                            Text Position :
                            <select x-model="lines.position">
                                <option value="left">Left</option>
                                <option value="right">Right</option>
                            </select>
                        </label>
                    </div>
                    <div class="field">
                        <label class="flex items-center gap-2">
                            Tag :
                            <select x-model="lines.tag">
                                <option value="">@lang('Add Tag')</option>
                                <template x-for="tag in tags">
                                    <option x-text="tag.name"></option>
                                </template>
                            </select>
                        </label>
                    </div>
                    <div class="field">
                        <label class="flex items-center gap-2">
                            Tag Position :
                            <select x-model="lines.tagPosition">
                                <option value="top-right">Top Right</option>
                                <option value="top-left">Top Left</option>
                                <option value="bottom-right">Bottom Right</option>
                                <option value="bottom-left">Bottom Left</option>
                            </select>
                        </label>
                    </div>
                </div>
                <div class="lines">
                    <div class="line ">
                        <textarea x-model="lines.line1.text"></textarea>
                        <div class="inputs">
                            <div class="item">{{ __('Color') }} <input type="color" x-model="lines.line1.color"></div>
                            <div class="item">{{ __('Shadow') }} <input type="color" x-model="lines.line1.shadow"></div>
                            <div class="item">{{ __('Width %') }} <input type="number" x-model="lines.line1.width"></div>
                            <div class="item">{{ __('Size') }} <input type="number" x-model="lines.line1.size"></div>
                            <div class="item">{{ __('Line Height') }} <input type="number" x-model="lines.line1.space"></div>
                        </div>
                    </div>
                    <div class="line ">
                        <textarea x-model="lines.line2.text"></textarea>
                        <div class="inputs">
                            <div class="item">{{ __('Color') }} <input type="color" x-model="lines.line2.color"></div>
                            <div class="item">{{ __('Shadow') }} <input type="color" x-model="lines.line2.shadow"></div>
                            <div class="item">{{ __('Width %') }} <input type="number" x-model="lines.line2.width"></div>
                            <div class="item">{{ __('Size') }} <input type="number" x-model="lines.line2.size"></div>
                            <div class="item">{{ __('Line Height') }} <input type="number" x-model="lines.line2.space"></div>
                        </div>
                    </div>
                    <div class="line ">
                        <textarea x-model="lines.line3.text"></textarea>
                        <div class="inputs">
                            <div class="item">{{ __('Color') }} <input type="color" x-model="lines.line3.color"></div>
                            <div class="item">{{ __('Shadow') }} <input type="color" x-model="lines.line3.shadow"></div>
                            <div class="item">{{ __('Width %') }} <input type="number" x-model="lines.line3.width"></div>
                            <div class="item">{{ __('Size') }} <input type="number" x-model="lines.line3.size"></div>
                            <div class="item">{{ __('Line Height') }} <input type="number" x-model="lines.line3.space"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </template>
    <x-slot name="footer">
        <x-filament::button
            outlined
            color='secondary'
            x-on:click="$dispatch('close-modal', {id: 'featured-image-editor-{{ $getStatePath() }}'})">
            {{ __('Cancel') }}
        </x-filament::button>

        <x-filament::button
            x-on:click="$dispatch('close-modal', {id: 'featured-image-editor-{{ $getStatePath() }}', lines: lines, save: true})">
            {{ __('Save') }}
        </x-filament::button>

    </x-slot>
</x-filament::modal>
