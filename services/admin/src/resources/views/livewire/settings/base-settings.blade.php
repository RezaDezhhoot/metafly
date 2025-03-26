<div wire:init="init" class="h-100">
    @section('title', __('pages.pages.action',['item' => __('general.sidebar.base')]) )
    <x-admin.form-control :deleteAble="false"  title="{{__('general.sidebar.base')}}"/>
    <div class="card card-custom h-100 gutter-b example example-compact">
        <div class="card-header">
            <h3 class="card-title">{{__('general.sidebar.base')}}</h3>
        </div>
        <x-admin.forms.validation-errors/>
        <div class="card-body ">
            <x-admin.form-section>
                <x-admin.forms.input width="6" type="text" :required="true" id="title" label="{{__('general.title')}}" wire:model.defer="title"/>
                <x-admin.forms.lfm-standalone width="6" :required="true" id="logo" label="{{__('general.logo')}}" :file="$logo" wire:model="logo"/>
                <x-admin.forms.text-area id="keywords" :required="true" label="{{__('general.seo_keywords')}}" help="{{__('general.descriptions.separate_words_with_commas')}}" wire:model.defer="keywords"/>
                <x-admin.forms.text-area id="description" :required="true" label="{{__('general.seo_description')}}" wire:model.defer="description"/>
            </x-admin.form-section>
        </div>
    </div>
</div>
