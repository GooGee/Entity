
<form v-on:submit.prevent="save(@echo($form->instance))" method="@echo($form->method)" class="form-horizontal">

@foreach($form->fieldList as $field)
@if($field->type == 'hidden')
    @if(empty($field->vModel))
        <input name="@echo($field->name)" value="@echo($field->value)" type="hidden">
    @else
        <input v-model="@echo($field->vModel)" name="@echo($field->name)" type="hidden">
    @endif

@else
    <div class="form-group">
        <label class="control-label col-xs-2">@echo($field->label)</label>
        <div class="col-xs-9">
        @if($field->type == 'text' or $field->type == 'password')
            @if(empty($field->vModel))
                <input name="@echo($field->name)" value="@echo($field->value)" class="form-control" type="@echo($field->type)">
            @else
                <input v-model="@echo($field->vModel)" name="@echo($field->name)" class="form-control" type="@echo($field->type)">
            @endif

        @elseif($field->type == 'textarea')
            <textarea v-model="@echo($field->vModel)" name="@echo($field->name)" class="form-control"></textarea>

        @elseif($field->type == 'checkbox')
            <label class="checkbox-inline">
                <input v-model="@echo($field->vModel)" name="@echo($field->name)" value="@echo($field->value)" type="checkbox">
                <span>@echo($field->label)</span>
            </label>

        @elseif($field->type == 'group')
            <label v-for="item in itemList" class="checkbox-inline">
                <input v-model="@echo($field->vModel)" name="@echo($field->name)" v-bind:value="item.value" type="checkbox">
                <span v-text="item.name"></span>
            </label>

        @elseif($field->type == 'radio')
            <label v-for="item in itemList" class="radio-inline">
                <input v-model="@echo($field->vModel)" name="@echo($field->name)" v-bind:value="item.value" type="radio">
                <span v-text="item.name"></span>
            </label>

        @elseif($field->type == 'select')
            <select v-model="@echo($field->vModel)" name="@echo($field->name)" class="form-control">
                <option v-for="item in itemList" v-bind:value="item.value" v-text="item.name"></option>
            </select>
        @endif
        </div>
    </div>

@endif
@endforeach

    <div class="form-group">
        <label class="control-label col-xs-2"></label>
        <div class="col-xs-9">
            <button class="btn btn-primary" type="submit">Save</button>
        </div>
    </div>

</form>
