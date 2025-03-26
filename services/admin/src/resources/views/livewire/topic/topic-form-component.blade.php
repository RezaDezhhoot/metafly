<div class="col-12 p-0">
    <div class="d-flex align-items-end">
        <x-admin.forms.input width="4" type="text"  id="topic_title" label="{{__('general.new_topic')}}"
                             wire:model.defer="title"/>
        <x-admin.button class="btn btn-outline-primary font-weight-bolder btn-sm" content="{{ __('general.actions.create') }}" wire:click="addTopic()"/>
    </div>
    <x-admin.forms.select2 :data="$oldTopics" :multiple="true" text="title" label="{{__('general.topics')}}"  id="topics" ajaxUrl="{{route('topic.feed')}}" wire:model.defer="topics"/>
</div>
