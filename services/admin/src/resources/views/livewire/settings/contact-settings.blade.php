<div wire:init="init" class="h-100">
    @section('title', __('pages.pages.action',['item' => __('general.sidebar.contact')]) )
    <x-admin.form-control :deleteAble="false"  title="{{__('general.sidebar.contact')}}"/>
    <div class="card card-custom h-100 gutter-b example example-compact">
        <div class="card-header">
            <h3 class="card-title">{{__('general.sidebar.contact')}}</h3>
        </div>
        <x-admin.forms.validation-errors/>
        <div class="card-body ">
            <x-admin.form-section>
                <x-admin.forms.input  type="text" :required="true" id="phone1" label="{{__('general.phone')}} 1" wire:model.defer="phone1"/>
                <x-admin.forms.input  type="text" :required="true" id="phone2" label="{{__('general.phone')}} 2" wire:model.defer="phone2"/>
                <x-admin.forms.input  type="text" :required="true" id="address" label="{{__('general.address')}}" wire:model.defer="address"/>
                <x-admin.forms.text-area id="location" :required="true" label="{{__('general.location')}} Iframe" wire:model.defer="location"/>
                <x-admin.forms.full-text-editor id="aboutUs" :required="true" label="{{__('general.body')}}" wire:model.defer="aboutUs"/>
            </x-admin.form-section>
        </div>
    </div>
</div>
