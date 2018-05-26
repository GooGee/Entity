<script type="text/x-template" id="tttValidation">
    <table class="table">
        <caption><h3>Validation</h3></caption>
        <thead>
        <tr>
            <th width="50px"></th>
            <th>Field</th>
            <th>Fillable</th>
            <th>Hidden</th>
            <th>integer</th>
            <th>numeric</th>
            <th>alpha</th>
            <th>alpha_num</th>
            <th>string</th>
            <th>email</th>
            <th>required</th>
            <th class="col-xs-1">Min</th>
            <th class="col-xs-1">Max</th>
            <th>RegExp</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="field in model.validation.list">
            <td>
                <span v-on:click="remove(field)" class="btn btn-danger">X</span>
            </td>
            <td v-text="field.name"></td>
            <td><input v-model="field.fillable" class="form-control" type="checkbox"></td>
            <td><input v-model="field.hidden" class="form-control" type="checkbox"></td>
            <td><input v-model="field.rule.integer" class="form-control" type="checkbox"></td>
            <td><input v-model="field.rule.numeric" class="form-control" type="checkbox"></td>
            <td><input v-model="field.rule.alpha" class="form-control" type="checkbox"></td>
            <td><input v-model="field.rule.alpha_num" class="form-control" type="checkbox"></td>
            <td><input v-model="field.rule.string" class="form-control" type="checkbox"></td>
            <td><input v-model="field.rule.email" class="form-control" type="checkbox"></td>
            <td><input v-model="field.rule.required" class="form-control" type="checkbox"></td>
            <td><input v-model="field.rule.min" class="form-control" type="text"></td>
            <td><input v-model="field.rule.max" class="form-control" type="text"></td>
            <td><input v-model="field.rule.regex" class="form-control" type="text"></td>
        </tr>
        </tbody>
        <tfoot>
        <tr>
            <td></td>
            <td><span v-on:click="model.update()" class="btn btn-primary">All</span></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        </tfoot>
    </table>
</script>


<script type="text/javascript">

    Vue.component('ccc-validation', {
        template: '#tttValidation',
        props: ['model'],
        methods: {
            remove: function (field) {
                if(confirm('Are you sure?')){
                    this.model.validation.remove(field);
                }
            }
        }
    });

</script>
