<?php
/**
 * @var \NguyenTranChung\Rookie\Form $form
 */

?>
@switch($form->type)
    @case('select')
    <x-form-select
        :id="$form->id"
        :class="$form->class"
        :label="$form->label"
        :name="$form->name"
        :value="$form->value"
        :options="$form->options"
        :multiple="$form->multiple"
        :placeholder="$form->placeholder"
        :language="$form->language"></x-form-select>
    @break

    @case('textarea')
    <x-form-textarea
        :id="$form->id"
        :class="$form->class"
        :label="$form->label"
        :name="$form->name"
        :value="$form->value"
        :placeholder="$form->placeholder"
        :language="$form->language"></x-form-textarea>
    @break

    @case('radio')
    <x-form-group
        :id="$form->id"
        :class="$form->class"
        :label="$form->label"
        :name="$form->name"
    >
        @foreach($form->items as  $index => $item)
            <x-form-radio
                :name="$form->name"
                :value="$item[0]"
                :label="$item[1]"
                :language="$form->language"></x-form-radio>
        @endforeach
    </x-form-group>
    @break

    @case('checkbox')
    <x-form-group>
        <x-form-checkbox
            :id="$form->id"
            :class="$form->class"
            :label="$form->label"
            :name="$form->name"
            :value="$form->value"
            :placeholder="$form->placeholder"
            :language="$form->language"></x-form-checkbox>
    </x-form-group>
    @break

    @default
    <x-form-input
        :id="$form->id"
        :class="$form->class"
        :type="$form->type"
        :label="$form->label"
        :name="$form->name"
        :value="$form->value"
        :default="$form->default"
        :placeholder="$form->placeholder"
        :language="$form->language"></x-form-input>
@endswitch
