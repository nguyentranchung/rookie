<?php
/**
 * @var \NguyenTranChung\Rookie\Form $form
 */

?>
@if((isset($model) && $form->showOnUpdate) || (is_null($model) && $form->showOnCreation))
    @include('rookie::input')
@endif
