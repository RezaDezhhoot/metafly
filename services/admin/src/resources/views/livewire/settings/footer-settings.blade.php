<div wire:init="init" class="h-100">
    @section('title', __('pages.pages.action',['item' => __('general.sidebar.footer')]) )
    <x-admin.form-control :deleteAble="false"  title="{{__('general.sidebar.footer')}}"/>
    <div class="card card-custom h-100 gutter-b example example-compact">
        <div class="card-header">
            <h3 class="card-title">{{__('general.sidebar.footer')}}</h3>
        </div>
        <x-admin.forms.validation-errors/>
        <div class="card-body ">
            <x-admin.form-section>
                <x-admin.forms.input  type="email" :required="true" id="email" label="{{__('general.email')}}" wire:model.defer="email"/>
                <x-admin.forms.text-area id="footerText" :required="true" label="{{__('general.footerText')}}" wire:model.defer="footerText"/>

                <x-admin.forms.input  type="text" id="telegram" label="{{__('general.telegram')}}" wire:model.defer="telegram"/>
                <x-admin.forms.input  type="text" id="whatsapp" label="{{__('general.whatsapp')}}" wire:model.defer="whatsapp"/>
                <x-admin.forms.input  type="text" id="youtube" label="{{__('general.youtube')}}" wire:model.defer="youtube"/>
                <x-admin.forms.input  type="text" id="instagram" label="{{__('general.instagram')}}" wire:model.defer="instagram"/>


            </x-admin.form-section>
            <x-admin.form-section label="{{ __('general.signs') }}">
                <div class="col-12">
                    <button wire:click="addSign" class="btn my-2 btn-outline-primary">{{__('general.add')}} <i class="fas fa-plus"></i></button>
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>{{__('general.value')}}</th>
                            <th>{{ __('general.actions.actions') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($signs as $k => $v)
                            <tr>
                                <td>
                                    <x-admin.forms.input type="text" :required="true" id="text" label="{{__('general.value')}}" wire:model.defer="signs.{{$k}}"/>
                                </td>
                                <td>
                                    <x-admin.delete-btn wire:click="deleteSign('{{$k}}')"  />
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </x-admin.form-section>
        </div>
    </div>
</div>
