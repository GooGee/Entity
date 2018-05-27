
<form method="@echo($form->method)" class="form-horizontal">

@foreach($form->fieldList as $field)
@if($field->type == 'hidden')
    <input v-model="@echo($field->vModel)" name="@echo($field->name)" class="form-control" type="hidden">

@else
    <div class="form-group">
        <label class="control-label col-xs-2">@echo($field->label)</label>
        <div class="col-xs-9">
        @if($field->type == 'text' or $field->type == 'password')
            <input v-model="@echo($field->vModel)" name="@echo($field->name)" class="form-control" type="@echo($field->type)">
        @elseif($field->type == 'textarea')
            <textarea v-model="@echo($field->vModel)" name="@echo($field->name)" class="form-control"></textarea>
        @elseif($field->type == 'checkbox')
            <label v-for="item in itemArray" class="checkbox-inline">
                <input v-model="@echo($field->vModel)" name="@echo($field->name)" v-bind:value="item.value" type="checkbox">@{{item.name}}</label>
        @elseif($field->type == 'radio')
            <label v-for="item in itemArray" class="radio-inline">
                <input v-model="@echo($field->vModel)" name="@echo($field->name)" v-bind:value="item.value" type="radio">@{{item.name}}</label>
        @elseif($field->type == 'select')
            <select v-model="@echo($field->vModel)" name="@echo($field->name)" class="form-control">
                <option v-for="item in itemArray" v-bind:value="item.value">@{{item.name}}</option>
            </select>
        @endif
        </div>
    </div>

@endif
@endforeach

    <div class="form-group">
        <label class="control-label col-xs-2"></label>
        <div class="col-xs-9">
            <button v-on:click="save(@echo($form->instance))" class="btn btn-primary" type="button">Save</button>
        </div>
    </div>

</form>
